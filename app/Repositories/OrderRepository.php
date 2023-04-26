<?php

namespace App\Repositories;


use App\Models\Partner\Referal;
use App\Models\Partner\PartnerCheck;
use App\Models\Partner\PartnerCheckIncrease;
use App\Models\Partner\PartnerCheckWithdraw;
use App\Models\Deals\Orders;

class OrderRepository
{
    public function getAllItems($status = false) 
    {
        // Orders::where(['status' => $status])->get();
        if($status){
            return Orders::where(['status' => $status])->get();
        }else{
            return Orders::get();
        }
        
    }

    public function getById($id){
        $item = Orders::where(["id" => $id])
        ->get()
        ->first();
        
        return $item ? $item : false;
    }

    public function getByPartnerId($id){
        $item = Orders::where(["partner_id" => $id])
        ->get();
        
        return $item ? $item : false;
    }

    public function getActiveOrdersByPartnerId($id){
        $item = Orders::where(["partner_id" => $id])
        ->whereIn('status', [Orders::STATUS_NEW, Orders::STATUS_ACCEPTED])
        ->get();
        
        return $item ? $item : false;
    }

    public function updateItem(Orders $item, array $params){
        foreach($params as $name => $info){
            $item->$name = $info;
        }
        return $item->save() ? $item : false;
    }
    
    public function getAllItemsWithPagination($pagesCount) 
    {
        return Orders::paginate($pagesCount);
    }

    


    // public function registerPartner(array $params){
    //     $item = new Referal;
    //     $check = new PartnerCheck;
    //     foreach($params as $name => $info){
    //         $item->$name = $info;
    //         // if($name == "password"){
    //         //     $item->$name = setPasswordAttribute($info);
    //         // }else{
    //         //     $item->$name = $info;
    //         // }
    //     }
        
    //     if($item->save()){
    //         $check->partner_id = $item->id;
    //         $check->save();
    //         return $item;
    //     }else{
    //         return false;
    //     }
    // }

    // public function getByEmail($email){
    //     $item = Referal::where(["email" => $email])
    //     ->get()
    //     ->first();
        
    //     return $item ? $item : false;
    // }

    // public function getById($id){
    //     $item = Referal::where(["id" => $id])
    //     ->get()
    //     ->first();
        
    //     return $item ? $item : false;
    // }

    // public function getPartnerCheck($partnerId){
    //     $item = PartnerCheck::where(["partner_id" => $partnerId])
    //     ->get()
    //     ->first();
        
    //     return $item ? $item : false;
    // }

    // //Все поступившие средства по партнерской программе для указанного партнера
    // public function getPartnerIncreases($partnerId){
    //     $items = PartnerCheckIncrease::where(["partner_id" => $partnerId])
    //         ->get();
        
    //     return $items ? $items : false;
    // }

    // //Все выведеные средства по партнерской программе для указанного партнера
    // public function getPartnerWithdraws($partnerId){
    //     $items = PartnerCheckWithdraw::where(["partner_id" => $partnerId])
    //         ->get();
        
    //     return $items ? $items : false;
    // }



    
}