<?php

namespace App\Services;

use Cookie;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Partner\PartnerCheckIncrease;
use App\Models\Partner\PartnerCheckWithdraw;
use App\Repositories\OrderRepository;
use App\Models\Deals\CastomersOrders;
use App\Models\Deals\Castomers;
use App\Models\Deals\Orders;
use App\Models\Partner\Referal;


// $app = app();
// $likeService = app()->make(App\Services\CookieService::class)->getCookieUid();
class OrdersService
{
    
    public function __construct()
    {
        
    }
    
    //Все заказы партнера
    public static function partnerOrders(Referal $partner){
        $repo = new OrderRepository;
        return $repo->getByPartnerId($partner->id);
    }

    //Все заказы партнера число
    public static function partnerOrdersCount(Referal $partner){
        $items = static::partnerOrders($partner);
        return $items ? count($items) : "0";
    }

    //Активные заказы партнера
    public static function partnerOrdersActive(Referal $partner){
        $repo = new OrderRepository;
        return $repo->getActiveOrdersByPartnerId($partner->id);
    }

    //Все активные заказы партнера число
    public static function partnerOrdersActiveCount(Referal $partner){
        $items = static::partnerOrdersActive($partner);
        return $items ? count($items) : "0";
    }
    



    

}    