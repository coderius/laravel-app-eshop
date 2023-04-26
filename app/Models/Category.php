<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Category extends Model
{
    protected $table = 'categories';

    //status
    const STATUS_ACTIVE = 1;
    const STATUS_DESIBLED = 0;

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }

    public function productsActive($status = 1)
    {
        return $this->products()->where('status', $status);
    }

    public function productsCount($status = 1)
    {
        $selfCount =  $this->productsActive($status)->count();

        $subCats = $this->categoriesByLevel($status);
        if($this->categoriesByLevel()->count() > 0){
            foreach($subCats as $subCat){
                $selfCount += $subCat->productsActive($status)->count();
            }
        }

        return $selfCount;
    }

    

    public function categoriesByLevel($status = 1)
    {
        return static::where('status', $status)
            ->where('parent_id', $this->id)
            ->orderBy('created_at', 'ASC')
            ->get();
    }

    public function parentCategories($status = 1)
    {
        return static::where('status', $status)
            ->where('id', $this->parent_id)
            ->orderBy('created_at', 'ASC')
            ->get();
    }

}
