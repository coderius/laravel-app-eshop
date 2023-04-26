<?php

namespace App\Repositories;


use App\Models\Brand;

class BrandRepository
{
    public function getAllItems($status = 1) 
    {
        return Brand::where(['status' => $status])->get();
    }

    public function getItemByAlias($alias) 
    {
        return Brand::where(['alias'=> $alias])->get()->first();
    }

    public function getItemById($id) 
    {
        return Brand::where(['id' => $id])->get()->first();
    }

    ////////////////////////////////////////////////
    public function createItem(array $params){
        $item = new Brand;
        foreach($params as $name => $info){
            $item->$name = $info;
        }
        return $item->save();
    }

    public function updateItem(Brand $item, array $params){
        foreach($params as $name => $info){
            $item->$name = $info;
        }
        return $item->save();
    }

    public function deleteItem($id){
        return Brand::where(['id' => $id])->delete();
    }

    // public function getOrderById($orderId) 
    // {
    //     return Order::findOrFail($orderId);
    // }

    // public function deleteOrder($orderId) 
    // {
    //     Order::destroy($orderId);
    // }

    // public function createOrder(array $orderDetails) 
    // {
    //     return Order::create($orderDetails);
    // }

    // public function updateOrder($orderId, array $newDetails) 
    // {
    //     return Order::whereId($orderId)->update($newDetails);
    // }

    // public function getFulfilledOrders() 
    // {
    //     return Order::where('is_fulfilled', true);
    // }
}