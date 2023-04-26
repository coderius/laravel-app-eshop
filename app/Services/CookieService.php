<?php

namespace App\Services;

use Cookie;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

// $app = app();
// $likeService = app()->make(App\Services\CookieService::class)->getCookieUid();
class CookieService
{
    
    private $_cookieName = "uId";
    private $_cookiePartner = "partner";//cookie name
 
    public function __construct()
    {
        
    }
    
    public function getCookieUid(){
        return Cookie::get($this->_cookieName);
    }

    public function setCookieUid(){
        $uId = (string) Str::uuid();
        Cookie::queue($this->_cookieName, $uId, 60*24*365*2);
        return $uId;
    }

    public function getOrSetCookieUid(){
        $uId = $this->getCookieUid();
        if(!$uId){
            $uId = $this->setCookieUid();
        }
        
        return $uId;
    }
    //------------
    //PartnerLink
    //------------
    public function getCookiePartner(){
        return Cookie::get($this->_cookiePartner);//get param by name
    }

    public function setCookiePartner(){
        $alias = request()->query('partner');//get referal param from link visiter
        if($alias){
            Cookie::queue($this->_cookiePartner, $alias, 60*24*30);//30 days
            return $alias;
        }
        return;
    }

    public function getOrSetCookiePartner(){
        $cookie = $this->getCookiePartner();
        if(!$cookie){
            $cookie = $this->setCookiePartner();
        }
        
        return;
    }

    public function removeCookiePartner(){
        Cookie::forget($this->_cookiePartner);
        return;
    }


    

}    