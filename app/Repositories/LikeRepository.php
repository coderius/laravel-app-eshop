<?php

namespace App\Repositories;


use App\Models\Like;

class LikeRepository
{
    public function getAllItems() 
    {
        return Like::all();
    }

    public function getItem($product_id, $cookie_val)
    {
        return Like::where('product_id', $product_id)->where('cookie_val', $cookie_val)->get()->first();
    }

    public function getQueryLikesForPerson($cookie_val, $status = 1)
    {
        return Like::where('status', $status)->where('cookie_val', $cookie_val);
    }

    public function getCountLikesForPerson($cookie_val, $status = 1)
    {
        return Like::where('status', $status)->where('cookie_val', $cookie_val)->get()->count();
    }
    
    ////////////////////////////////////////////////
    public function createItem(array $params){
        $item = new Like;
        foreach($params as $name => $info){
            $item->$name = $info;
        }
        return $item->save() ? $item : false;
    }

    public function updateItem(Like $item, array $params){
        foreach($params as $name => $info){
            $item->$name = $info;
        }
        return $item->save() ? $item : false;
    }

    public function deleteItem($id){
        return Like::where(['id' => $id])->delete();
    }

    public function deleteItemsByProductId($id){
        return Like::where(['product_id' => $id])->delete();
    }
}