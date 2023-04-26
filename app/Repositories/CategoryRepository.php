<?php

namespace App\Repositories;


use App\Models\Category;

class CategoryRepository
{
    public function getAllItems($status = 1) 
    {
        return Category::where(['status' => $status])->get();
    }

    public function getItemById($id) 
    {
        return Category::where(['id' => $id])->get()->first();
    }

    public function getItemsByConditions() 
    {
        return Category::all();
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

    ////////////////////////////////////////////////
    public function createItem(array $params){
        $item = new Category;
        foreach($params as $name => $info){
            $item->$name = $info;
        }
        return $item->save();
    }

    public function updateItem(Category $item, array $params){
        foreach($params as $name => $info){
            $item->$name = $info;
        }
        return $item->save();
    }

    public function deleteItem($id){
        return Category::where(['id' => $id])->delete();
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