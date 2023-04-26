<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FooterMenu extends Model
{
    protected $table = 'footer_menu';

    //type
    const TYPE_LINK_EX = 1;
    const TYPE_LINK_IN = 0;
    
    //status
    const STATUS_ACTIVE = 1;
    const STATUS_DESIBLED = 0;

    public static function flags()
    {
        return [
            'type_link' => [
                self::TYPE_LINK_EX => "внешняя",
                self::TYPE_LINK_IN => "внутренняя",
            ],
            'status' => [
                self::STATUS_ACTIVE => "активно",
                self::STATUS_DESIBLED => "не активно",
            ]
        ];
    }
}
