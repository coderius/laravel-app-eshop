<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Like extends Model
{
    protected $table = 'likes';

    //status
    const STATUS_ACTIVE = 1;
    const STATUS_DESIBLED = 0;

    public static function flags()
    {
        return [
            'status' => [
                self::STATUS_ACTIVE => "не активно",
                self::STATUS_DESIBLED => "активно",
            ]
        ];
    }

    public function product()
	{
		return $this->belongsTo(Product::class, 'product_id', 'id');
	}
}
