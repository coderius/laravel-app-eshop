<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeaderMenu extends Model
{
    protected $table = 'header_menu';

        //status
        const STATUS_ACTIVE = 1;
        const STATUS_DESIBLED = 0;
    
        public static function flags()
        {
            return [
                
                'status' => [
                    self::STATUS_ACTIVE => "активно",
                    self::STATUS_DESIBLED => "не активно",
                ]
            ];
        }
}
