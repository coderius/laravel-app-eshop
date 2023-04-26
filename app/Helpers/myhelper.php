<?php

function currentUrlWithoutSortParam(){
    $u = substr( url()->current(), 0, strpos(url()->current(), 'sort=') );
    $current = $u != "" ? $u : url()->current();
    $current = rtrim($current, '/');
    return $current;
}

function isAdmin(){
    if(Auth::check()){
        return Auth::user()->is_admin == 1;
    }
    return false;
}

function isPartner(){
    $partnerId = getPartnerId();
    if($partnerId){
        $partner = (new App\Repositories\PartnerRepository)->getById($partnerId);
        if($partner){
            return true;
        }
    }
    return false;
}

function getPartnerId(){
    return session()->get('partnerId');
}

