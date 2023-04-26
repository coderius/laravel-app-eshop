<?php

namespace App\Repositories;

use App\Interfaces\FooterMenuRepositoryInterface;
use App\Models\FooterMenu;

class FooterMenuRepository implements FooterMenuRepositoryInterface 
{
    public function getAllItems() 
    {
        return FooterMenu::all();
    }

    public function getItemById($id) 
    {
        return FooterMenu::where(['id' => $id])->get()->first();
    }

    ////////////////////////////////////////////////
    public function createItem(array $params){
        $item = new FooterMenu;
        foreach($params as $name => $info){
            $item->$name = $info;
        }
        return $item->save();
    }

    public function updateItem(FooterMenu $item, array $params){
        foreach($params as $name => $info){
            $item->$name = $info;
        }
        return $item->save();
    }

    public function deleteItem($id){
        return FooterMenu::where(['id' => $id])->delete();
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