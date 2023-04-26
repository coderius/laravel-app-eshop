<?php

namespace App\Repositories;


use App\Models\Partner\Referal;
use App\Models\Partner\PartnerCheck;
use App\Models\Partner\PartnerCheckIncrease;
use App\Models\Partner\PartnerCheckWithdraw;
use App\Models\Partner\PartnerRequestWithdraw;

class PartnerRepository
{
    public function registerPartner(array $params){
        $item = new Referal;
        $check = new PartnerCheck;
        foreach($params as $name => $info){
            $item->$name = $info;
            // if($name == "password"){
            //     $item->$name = setPasswordAttribute($info);
            // }else{
            //     $item->$name = $info;
            // }
        }
        
        if($item->save()){
            $check->partner_id = $item->id;
            $check->save();
            return $item;
        }else{
            return false;
        }
    }

    public function getByEmail($email){
        $item = Referal::where(["email" => $email])
        ->get()
        ->first();
        
        return $item ? $item : false;
    }

    public function getById($id){
        $item = Referal::where(["id" => $id])
        ->get()
        ->first();
        
        return $item ? $item : false;
    }

    public function getPartnerCheck($partnerId){
        $item = PartnerCheck::where(["partner_id" => $partnerId])
        ->get()
        ->first();
        
        return $item ? $item : false;
    }

    //Все партнерские балансы
    public function getAllPartnerChecks(){
        $item = PartnerCheck::get();
        return $item;
    }

    public function updatePartnerCheck(PartnerCheck $item, array $params){
        foreach($params as $name => $info){
            $item->$name = $info;
        }
        return $item->save() ? $item : false;
    }

    //Все поступившие средства по партнерской программе для указанного партнера
    public function getPartnerIncreases($partnerId){
        $items = PartnerCheckIncrease::where(["partner_id" => $partnerId])
            ->get();
        
        return $items ? $items : false;
    }

    //Все выведеные средства по партнерской программе для указанного партнера
    public function getPartnerWithdraws($partnerId){
        $items = PartnerCheckWithdraw::where(["partner_id" => $partnerId])
            ->get();
        
        return $items ? $items : false;
    }

    //Создать поступление по партнерке
    public function setPartnerIncrease($partnerId, $params){
        $item = new PartnerCheckIncrease;
        foreach($params as $name => $info){
            $item->$name = $info;
        }
        return $item->save() ? $item : false;
    }

    //Создать вывод средств по партнерке
    public function setPartnerWithdraw($partnerId, $params){
        $item = new PartnerCheckWithdraw;
        foreach($params as $name => $info){
            $item->$name = $info;
        }
        return $item->save() ? $item : false;
    }

    public function getAllItemsWithPagination($pagesCount) 
    {
        return Referal::paginate($pagesCount);
    }

    //----------------------------------------------
    //Запросы на вывод денег партнером
    public function createPartnerRequestWithdraw($partnerId, $params){
        $item = new PartnerRequestWithdraw;
        foreach($params as $name => $info){
            $item->$name = $info;
        }
        return $item->save() ? $item : false;
    }

    public function hasPartnerRequestWithdraw($partnerId, $status = []){
        $result =  $this->getPartnerRequestWithdraw($partnerId, $status);
        return $result->count() > 0 ? true : false;
    }

    public function countPartnerRequestWithdraw($partnerId, $status = []){
        $result =  $this->getPartnerRequestWithdraw($partnerId, $status);
        // dd($result->count());
        return $result->count();
    }

    public function getPartnerRequestWithdraw($partnerId, $status){
        $res = PartnerRequestWithdraw::where(['partner_id' => $partnerId]);
        if(!empty($status)){
            $res->whereIn('status', $status);
        }
        // dd($res->get()->count());
        return $res->get();
    }

    public function getRequestWithdrawById($id){
        $res = PartnerRequestWithdraw::where(['id' => $id]);
        return $res->get()->first();
    }

    //Тут обнавляем статус запроса на вывод денег
    public function updateRequestWithdraw(PartnerRequestWithdraw $item, array $params){
        foreach($params as $name => $info){
            $item->$name = $info;
        }
        return $item->save() ? $item : false;
    }

    //-------------------------------------------
    
}