<?php

namespace App\Repositories;


use App\Models\Product;

class ProductRepository
{
    public function getAllItems($status = false) 
    {
        return $status === false ? Product::all() : Product::where(['status' => $status])->get();
    }

    // public function getAllItems($status = false, $orderBy = false) 
    // {
    //     $res = $status === false ? Product::all() : Product::where(['status' => $status]);

    //     if($orderBy){
    //         $res->orderBy('created_at', 'DESC')
    //     }

    //     return $res->get();
    // }

    public function getAllNewItems($limit = 4) 
    {
        return Product::where(['status' => 1])
            ->orderBy('created_at', 'DESC')
            ->skip(0)
            ->take($limit)
            ->get();
    }

    public function getAllRandomItems($limit = 4, $ownerId = false) 
    {
        $params = [];
        $params['status'] = 1;
        if($ownerId){
            $params['owner_id'] = $ownerId;
        }
        
        return Product::where($params)
            ->inRandomOrder()
            ->take($limit)
            ->get();
    }

    // public function getAllRandomItemsWhere($limit = 4) 
    // {
    //     return Product::where(['status' => 1])
    //         ->inRandomOrder()
    //         ->take($limit)
    //         ->get();
    // }

    public function getItemByAlias($alias) 
    {
        return Product::where(['alias'=> $alias])->get()->first();
    }

    public function getItemById($id) 
    {
        return Product::where(['id'=> $id])->get()->first();
    }

    public function hasOwnerArt($owner_id, $art) 
    {
        return Product::where(['owner_article'=> $art])->where(['owner_id'=>$owner_id])->get()->count() > 0 ? true : false;
    }

    ////////////////////////////////////////////////
    public function createItem(array $params){
        $item = new Product;
        foreach($params as $name => $info){
            $item->$name = $info;
        }
        return $item->save() ? $item : false;
    }

    public function updateItem(Product $item, array $params){
        foreach($params as $name => $info){
            $item->$name = $info;
        }
        return $item->save() ? $item : false;
    }

    public function deleteItem($id){
        return Product::where(['id' => $id])->delete();
    }
}