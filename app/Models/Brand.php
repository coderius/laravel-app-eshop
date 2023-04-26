<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Brand extends Model
{
    protected $table = 'brands';

    const STATUS_ACTIVE = 1;
    const STATUS_DESIBLED = 0;

    public function products()
    {
        return $this->hasMany(Product::class, 'brand_id', 'id');
    }

    public function productsActive($status = 1)
    {
        return $this->products()->where('status', $status);
    }

    public function productsCount($status = 1)
    {
        return $this->productsActive($status)->count();
    }
}
