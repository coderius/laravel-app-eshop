<?php

namespace App\Repositories;

use App\Interfaces\HeaderMenuRepositoryInterface;
use App\Models\ProductOwner;

class ProductOwnerRepository implements HeaderMenuRepositoryInterface 
{

    public function getAllItems($status = 1) 
    {
        return ProductOwner::where(['status' => $status])->get();
    }

    public function getItemById($id) 
    {
        return ProductOwner::where(['id' => $id])->get()->first();
    }

    ////////////////////////////////////////////////
    public function createItem(array $params){
        $item = new ProductOwner;
        foreach($params as $name => $info){
            $item->$name = $info;
        }
        return $item->save();
    }

    public function updateItem(ProductOwner $item, array $params){
        foreach($params as $name => $info){
            $item->$name = $info;
        }
        return $item->save();
    }

    public function deleteItem($id){
        return ProductOwner::where(['id' => $id])->delete();
    }

}