<?php

namespace App\Repositories;


use App\Models\Image;

class ImageRepository
{
    public function getAllItems() 
    {
        return Image::all();
    }

    public function getItemByAlias($alias) 
    {
        return Image::where(['alias'=> $alias])->get()->first();
    }

    public function getItemById($id) 
    {
        return Image::where(['id'=> $id])->get()->first();
    }

    public function getItemsByProductId($id) 
    {
        return Image::where(['product_id'=> $id])->get()->first();
    }

    public function getFirstItemInProduct($id, $status = Image::STATUS_ACTIVE) 
    {
        return Image::where(['product_id'=> $id, 'is_first' => Image::FIRST_IMG, 'status' => $status])->get()->first();
    }

    ////////////////////////////////////////////////
    public function createItem(array $params){
        $item = new Image;
        foreach($params as $name => $info){
            $item->$name = $info;
        }
        return $item->save() ? $item : false;
    }

    public function updateItem(Image $item, array $params){
        foreach($params as $name => $info){
            $item->$name = $info;
        }
        return $item->save() ? $item : false;
    }

    public function deleteItem($id){
        return Image::where(['id' => $id])->delete();
    }
    public function deleteItemsByProductId($id){
        return Image::where(['product_id' => $id])->delete();
    }
}