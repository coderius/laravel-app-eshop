<?php

namespace App\Repositories;


use App\Models\ShippingMethod;

class ShippingMethodRepository
{
    public function getAllItems() 
    {
        return ShippingMethod::all();
    }

    public function getItemsByOwnerId($id, $status = ShippingMethod::STATUS_ACTIVE) 
    {
        return ShippingMethod::where(['owner_id'=> $id,'status' => $status])->get();
    }

    // public function getItemByAlias($alias) 
    // {
    //     return Category::where(['alias'=> $alias])->get()->first();
    // }

    // public function getTopLevelItems()
    // {
    //     return Category::where(['parent_id'=> 0,'status' => 1])->get();
    // }

    // public function getTopLevelItemsWithProducts()
    // {
    //     $cat = Category::where('parent_id', 0);

    //     return $cat->with(['products' => function($query) {
    //         $query->where(['status'=> 1,'in_stock'=> 1]);
    //     }])->get();
    // }

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