<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Image;
use App\Models\ProductOwner;
use App\Models\ProductView;
use App\User;

class ExportProduct extends Model
{
    protected $table = 'exsport_products';

    //product_state
    const PRODUCT_STATE_NEW = 1;
    const PRODUCT_STATE_OLD = 2;
    //in_stock
    const STOCK_HAVE = 1;
    const STOCK_EXPECTED = 2;
    const STOCK_NOTHAVE = 3;
    //status
    const STATUS_ACTIVE = 1;
    const STATUS_DESIBLED = 0;

    public static function flags()
    {
        return [
            'product_state' => [
                self::PRODUCT_STATE_NEW => "новое",
                self::PRODUCT_STATE_OLD => "б/у",
            ],
            'in_stock' => [
                self::STOCK_HAVE => "в наличии",
                self::STOCK_EXPECTED => "ожидается",
                self::STOCK_NOTHAVE => "нет в наличии",
            ],
            'status' => [
                self::STATUS_ACTIVE => "объявление активно",
                self::STATUS_DESIBLED => "объявление не активно",
            ]
        ];
    }
    

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function views()
    {
        return $this->belongsTo(ProductView::class, 'id', 'product_id');
    }

    public function viewsProduct()
    {
        return $this->views()->count() > 0 ? $this->views()->first()->views : 0;
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function productOwner()
    {
        return $this->belongsTo(ProductOwner::class, 'owner_id', 'id');
    }

    // public function images($status = 1)
    // {
    //     $rel = $this->hasMany(Image::class, 'product_id', 'id');
        
    //     return $rel->where('status', $status);
    // }

    // //Main image in product
    // public function imageFirst()
    // {
    //     return $this->images()
    //     ->where('status', 1)->first();
        
    // }

    // public function imagesCount($status = 1)
    // {
    //     if($status === null){
    //         return $this->images()->count();
    //     }
        
    //     return $this->images()->where('status', $status)->count();
    // }

    // public function hasImages($status = 1)
    // {
    //     return $this->imagesCount($status) > 0 ? true : false;
    // }

    public function createdBy()
	{
		return $this->belongsTo(User::class, 'created_by', 'id');
	}
}
