<?php

namespace App\Repositories;


use App\Models\ProductView;


class ProductViewRepository
{
    public function getAllItems() 
    {
        return ProductView::all();
    }

    public function getItemByProductId($id) 
    {
        return ProductView::where(['product_id'=> $id])->get()->first();
    }

    public function createItem($prodId) 
    {
        $model = new ProductView;
        $model->product_id = $prodId;
        $model->views = 1;
        
        return $model->save();
    }

    public function updateItemCounter($prodId, $views) 
    {
        return ProductView::where('product_id', $prodId)->update(['views' => $views]);
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