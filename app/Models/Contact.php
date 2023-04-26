<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'shop_contacts';

    //type
    const TYPE_PHONE = 1;
    const TYPE_TELEGRAM = 2;
    const TYPE_VIBER = 3;
    const TYPE_VIBER_MOB = 4;
    const TYPE_URL = 5;
    const TYPE_TELEGRAM_GROUP_SHOP = 10;
    //status
    const STATUS_ACTIVE = 1;
    const STATUS_DESIBLED = 0;

    public static function flags()
    {
        return [
            'in_stock' => [
                self::TYPE_PHONE => "телефон",
                self::TYPE_TELEGRAM => "telegram",
                self::TYPE_VIBER => "viber",
                self::TYPE_VIBER_MOB => "viber для мобильного",
                self::TYPE_URL => "ссылка",
                self::TYPE_TELEGRAM_GROUP_SHOP => "telegram группа магазина",
            ],
            'status' => [
                self::STATUS_ACTIVE => "не активно",
                self::STATUS_DESIBLED => "активно",
            ]
        ];
    }

}
