<?php

namespace App\Models\Deals;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Partner\Referal;
use App\Models\Deals\CastomersOrders;
use App\Models\Deals\Castomers;

//App\Models\Deals\Orders
class Orders extends Model
{
    const STATUS_NEW = 1;//создан но не просмотрен админом
    const STATUS_ACCEPTED = 2;//принят
    const STATUS_DISMISSED = 3;//отменен
    const STATUS_SUCCESS = 4;//завершен успешно
    
    protected $table = 'orders';

    public static function statusColor($status){
        switch($status){
            case static::STATUS_NEW:
                return "text-warning";
            case static::STATUS_ACCEPTED:
                return "text-primary";
            case static::STATUS_DISMISSED:
                return "text-danger";
            case static::STATUS_SUCCESS:
                return "text-success";
            
            default:
                return "text-dark";
        }
    }

    //Те статусы, которые не завершены еще
    public static function activeStatuses(){
        return [static::STATUS_NEW, static::STATUS_ACCEPTED];
    }

    public static function isActiveStatuses($status){
        switch($status){
            case static::STATUS_NEW:
                return true;
            case static::STATUS_ACCEPTED:
                return true;
        }
        return false;
    }

    public static function statusDescription($status){
        switch($status){
            case static::STATUS_NEW:
                return "новый";
            case static::STATUS_ACCEPTED:
                return "принят в работу";
            case static::STATUS_DISMISSED:
                return "отменен";
            case static::STATUS_SUCCESS:
                return "завершен успешно";
            
        }
    }

    public static function flags()
    {
        return [
            'statuses' => [
                self::STATUS_NEW => static::statusDescription(self::STATUS_NEW),
                self::STATUS_ACCEPTED => static::statusDescription(self::STATUS_ACCEPTED),
                self::STATUS_DISMISSED => static::statusDescription(self::STATUS_DISMISSED),
                self::STATUS_SUCCESS => static::statusDescription(self::STATUS_SUCCESS),
            ]
        ];
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function partner()
    {
        return $this->belongsTo(Referal::class, 'partner_id', 'id');
    }

    //Покупатель
    public function getCustomer($id)
    {
        $c = CastomersOrders::where(['order_id' => $id])->get()->first(); 
        return $c->customer;
    }

}
