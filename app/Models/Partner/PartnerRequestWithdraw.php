<?php

namespace App\Models\Partner;

use Illuminate\Database\Eloquent\Model;

class PartnerRequestWithdraw extends Model
{
    
    const NEW = 1;//Новый запрос
    const CONFIRMED = 2;//Подтвержденный
    const SUCCESSED = 3;//Выполненный
    const DISMISSED = 4;//Отклоненный

    protected $table = 'partner_request_withdraw';

    public static function getStatusName($status){
        switch($status){
            case static::NEW :
                return "Новый";
            case static::CONFIRMED :
                return "Подтвержденный";
            case static::SUCCESSED :
                return "Выполненный";
            case static::DISMISSED :
                return "Отклоненный";        
        }
    }

    public static function flags(){
        return [
            static::NEW       => static::getStatusName(static::NEW),
            static::CONFIRMED => static::getStatusName(static::CONFIRMED),
            static::SUCCESSED => static::getStatusName(static::SUCCESSED),
            static::DISMISSED => static::getStatusName(static::DISMISSED),
        ];
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

}
