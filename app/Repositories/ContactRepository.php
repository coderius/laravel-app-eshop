<?php

namespace App\Repositories;


use App\Models\Contact;

class ContactRepository
{
    public function getAllItems() 
    {
        return Contact::all();
    }

    public function getPhone() 
    {
        return Contact::where(['type'=> Contact::TYPE_PHONE,'status' => 1])->get();
    }

    public function getTelegram() 
    {
        return Contact::where(['type'=> Contact::TYPE_TELEGRAM,'status' => 1])->get();
    }

    public function getViber() 
    {
        return Contact::where(['type'=> Contact::TYPE_VIBER,'status' => 1])->get();
    }

    public function getViberMobile()
    {
        return Contact::where(['type'=> Contact::TYPE_VIBER_MOB,'status' => 1])->get();
    }

    public function getUrl()
    {
        return Contact::where(['type'=> Contact::TYPE_URL,'status' => 1])->get();
    }

    public function getTelegramGroupShop()
    {
        return Contact::where(['type'=> Contact::TYPE_TELEGRAM_GROUP_SHOP,'status' => 1])->get();
    }

    public function getItemById($id) 
    {
        return Contact::where(['id' => $id])->get()->first();
    }

    ////////////////////////////////////////////////
    public function createItem(array $params){
        $item = new Contact;
        foreach($params as $name => $info){
            $item->$name = $info;
        }
        return $item->save();
    }

    public function updateItem(Contact $item, array $params){
        foreach($params as $name => $info){
            $item->$name = $info;
        }
        return $item->save();
    }

    public function deleteItem($id){
        return Contact::where(['id' => $id])->delete();
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