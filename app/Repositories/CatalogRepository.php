<?php

namespace App\Repositories;


use App\Models\Category;

class CatalogRepository
{
    public function getAllItems($status = 1) 
    {
        return Category::all()->where(['status' => $status])->get();
    }

    public function getItemByAlias($alias) 
    {
        return Category::where(['alias'=> $alias])->get()->first();
    }

    public function getTopLevelItems()
    {
        return Category::where(['parent_id'=> 0,'status' => 1])->get();
    }

    public function getTopLevelItemsWithProducts()
    {
        $cat = Category::where('parent_id', 0);

        return $cat->with(['products' => function($query) {
            $query->where(['status'=> 1,'in_stock'=> 1]);
        }])->get();
    }

}