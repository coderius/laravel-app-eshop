<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ShippingMethod;

class ProductOwner extends Model
{
    protected $table = 'product_owners';

        //type
        const TYPE_OWNER_MY = 1;
        const TYPE_OWNER_DROP = 2;
        
        //status
        const STATUS_ACTIVE = 1;
        const STATUS_DESIBLED = 0;
    
        public static function flags()
        {
            return [
                'type' => [
                    self::TYPE_OWNER_MY => "мой товар",
                    self::TYPE_OWNER_DROP => "дропшиппинг",
                ],
                'status' => [
                    self::STATUS_ACTIVE => "активно",
                    self::STATUS_DESIBLED => "не активно",
                ]
            ];
        }

    public function shippingMethods($status = ShippingMethod::STATUS_ACTIVE)
    {
        $rel = $this->hasMany(ShippingMethod::class, 'owner_id', 'id');
        
        return $rel->where('status', $status);
    }
}
