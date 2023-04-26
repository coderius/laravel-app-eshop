<?php

namespace App\Repositories;


use App\Models\Product;
use App\Models\Chat\Chat;
use App\Models\Chat\ChatMessages;

class ChatRepository
{
    
    
    // public function getAllItems($status = false) 
    // {
    //     return $status === false ? Product::all() : Product::where(['status' => $status])->get();
    // }

    // public function getAllItems($status = false, $orderBy = false) 
    // {
    //     $res = $status === false ? Product::all() : Product::where(['status' => $status]);

    //     if($orderBy){
    //         $res->orderBy('created_at', 'DESC')
    //     }

    //     return $res->get();
    // }

    // public function getAllNewItems($limit = 4) 
    // {
    //     return Product::where(['status' => 1])
    //         ->orderBy('created_at', 'DESC')
    //         ->skip(0)
    //         ->take($limit)
    //         ->get();
    // }

    // public function getAllRandomItems($limit = 4) 
    // {
    //     return Product::where(['status' => 1])
    //         ->inRandomOrder()
    //         ->take($limit)
    //         ->get();
    // }

    // public function getAllRandomItemsWhere($limit = 4) 
    // {
    //     return Product::where(['status' => 1])
    //         ->inRandomOrder()
    //         ->take($limit)
    //         ->get();
    // }

    // public function getItemByAlias($alias) 
    // {
    //     return Product::where(['alias'=> $alias])->get()->first();
    // }

    // public function getItemById($id) 
    // {
    //     return Product::where(['id'=> $id])->get()->first();
    // }

    // public function hasOwnerArt($owner_id, $art) 
    // {
    //     return Product::where(['owner_article'=> $art])->where(['owner_id'=>$owner_id])->get()->count() > 0 ? true : false;
    // }

    ////////////////////////////////////////////////
        
    public function addMessage(array $params){
        if($this->hasChatByCreatorAndProduct($params) == false){
            //Create new chat
            $сhat = new Chat;
            $сhat->status = Chat::STATUS_ACTIVE;
            $сhat->product_id = $params["product_id"];
            $сhat->created_by = $params["created_by"];

            if($сhat->save() == false){
                return false;
            }

            $сhatMessages = new ChatMessages;
            $сhatMessages->chat_id = $сhat->id;
            $сhatMessages->status = ChatMessages::STATUS_ACTIVE;
            $сhatMessages->is_seen = ChatMessages::SEEN_NOT;
            $сhatMessages->message = $params["message"];
            $сhatMessages->created_by = $params["created_by"];
            
            return $сhatMessages->save() ? $сhat->id : false;
            
        }else{
            $сhat = $this->getChatByCreatorAndProduct($params);
            $сhatMessages = new ChatMessages;
            $сhatMessages->chat_id = $сhat->id;
            $сhatMessages->status = ChatMessages::STATUS_ACTIVE;
            $сhatMessages->is_seen = ChatMessages::SEEN_NOT;
            $сhatMessages->message = $params["message"];
            $сhatMessages->created_by = $params["created_by"];

            return $сhatMessages->save() ? $сhat->id : false;
        }
    }

    //Add new message from chat form
    public function postMessage(array $params){
        $item = new ChatMessages;
        foreach($params as $name => $info){
            $item->$name = $info;
        }
        return $item->save() ? $item : false;
    }

    public function getChatById($id){
        return Chat::where(['id'=> $id])->get()->first();
    }

    public function hasChatById($id){
        return (bool) Chat::where(['id'=> $id])->get()->count();
    }

    public function getChatByCreatorAndProduct($params){
        return Chat::where(['product_id'=> $params['product_id']])->where(['created_by'=> $params['created_by']])->get()->first();
    }

    public function hasChatByCreatorAndProduct($params){
        return (bool) Chat::where(['product_id'=> $params['product_id']])->where(['created_by'=> $params['created_by']])->get()->count();
    }

    public function getUserChats($userId){
        return Chat::where(['created_by'=> $userId])->get();
    }

    public function getAdminChats(){
        return Chat::get();
    }

    public function hasUserChats($userId){
        return (bool) Chat::where(['created_by'=> $userId])->get()->count();
    }



    // public function createItem(array $params){
    //     $item = new Product;
    //     foreach($params as $name => $info){
    //         $item->$name = $info;
    //     }
    //     return $item->save() ? $item : false;
    // }

    // public function updateItem(Product $item, array $params){
    //     foreach($params as $name => $info){
    //         $item->$name = $info;
    //     }
    //     return $item->save() ? $item : false;
    // }

    // public function deleteItem($id){
    //     return Product::where(['id' => $id])->delete();
    // }
}