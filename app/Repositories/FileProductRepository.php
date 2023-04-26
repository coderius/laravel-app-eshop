<?php

namespace App\Repositories;


use App\Models\ExportProduct;

class FileProductRepository
{
    public function getAllItems($status = false) 
    {
        return $status === false ? ExportProduct::all() : ExportProduct::where(['status' => $status])->get();
    }

    // public function getAllItems($status = false, $orderBy = false) 
    // {
    //     $res = $status === false ? ExportProduct::all() : ExportProduct::where(['status' => $status]);

    //     if($orderBy){
    //         $res->orderBy('created_at', 'DESC')
    //     }

    //     return $res->get();
    // }

    public function getAllNewItems($limit = 4) 
    {
        return ExportProduct::where(['status' => 1])
            ->orderBy('created_at', 'DESC')
            ->skip(0)
            ->take($limit)
            ->get();
    }

    public function hasArticle($owner_article) 
    {
        return ExportProduct::where(['owner_article' => $owner_article])->get()->count();
    }

    public function hasAlias($alias)
    {
        return ExportProduct::where(['alias'=> $alias])->get()->count();
    }


    public function getAllRandomItems($limit = 4) 
    {
        return ExportProduct::where(['status' => 1])
            ->inRandomOrder()
            ->take($limit)
            ->get();
    }

    // public function getAllRandomItemsWhere($limit = 4) 
    // {
    //     return ExportProduct::where(['status' => 1])
    //         ->inRandomOrder()
    //         ->take($limit)
    //         ->get();
    // }

    public function getItemByAlias($alias) 
    {
        return ExportProduct::where(['alias'=> $alias])->get()->first();
    }

    public function getItemById($id) 
    {
        return ExportProduct::where(['id'=> $id])->get()->first();
    }


    ////////////////////////////////////////////////
    public function createItem(array $params){
        $item = new ExportProduct;
        foreach($params as $name => $info){
            $item->$name = $info;
        }
        return $item->save() ? $item : false;
    }

    public function updateItem(ExportProduct $item, array $params){
        foreach($params as $name => $info){
            $item->$name = $info;
        }
        return $item->save() ? $item : false;
    }

    public function deleteItem($id){
        return ExportProduct::where(['id' => $id])->delete();
    }
}