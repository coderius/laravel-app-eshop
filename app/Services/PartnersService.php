<?php

namespace App\Services;

use Cookie;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Partner\PartnerCheckIncrease;
use App\Models\Partner\PartnerCheckWithdraw;
use App\Models\Partner\PartnerRequestWithdraw;
use App\Models\Partner\Referal;
use App\Repositories\PartnerRepository;
use App\Models\Deals\Orders;

// $app = app();
// $likeService = app()->make(App\Services\CookieService::class)->getCookieUid();
class PartnersService
{
    
    public function __construct()
    {
        
    }
    
    //История всех транзакций
    public static function partnerTransactionsHistory($partnerIncreases, $partnerWithdraws){
        $arr1 = [];
        if($partnerIncreases){
            foreach($partnerIncreases as $k => $v){
                $arr1[$k]['data'] = $v->created_at->timezone('Europe/Kiev')->translatedFormat('d M Y H:i ');
                $arr1[$k]['type'] = "Поступление от продажи";
                $arr1[$k]['info'] = "<a href='" . route('product', ['alias' => $v->order->product->alias]) . "'>". $v->order->product->short_title ."</a>";
                $arr1[$k]['money'] = $v->bid;
            }
        }
        
        $arr2 = [];
        if($partnerWithdraws){
            foreach($partnerWithdraws as $k => $v){
                $arr2[$k]['data'] = $v->created_at->timezone('Europe/Kiev')->translatedFormat('d M Y H:i ');
                $arr2[$k]['type'] = "Вывод денег";
                if(isAdmin()){
                    $arr2[$k]['info'] = "ID запроса вывода №" . $v->request_withdraw_id . "<br>" . $v->requestWithdraw->admin_comments;
                }else{
                    $arr2[$k]['info'] = "ID запроса вывода №" . $v->request_withdraw_id;
                }
                
                $arr2[$k]['money'] = $v->ammount;
            }
        }
        
        $com = array_merge($arr1, $arr2);
        if(!empty($com)){
            \App\Services\YiiArrayHelper::multisort($com, ['data'], [SORT_DESC]);
            return $com;
        }

        
        return false;
        // dd($com);
    }

    public static function partnerTransactionsCount($partnerIncreases, $partnerWithdraws){
        return $partnerIncreases->count() + $partnerWithdraws->count();
        
    }


    //Сумма всех заработков по партнерке в гривне
    public static function partnerIncreasesSumUAN($partnerIncreases){
        $sum = 0;
        // dd($partnerIncreases);
        if($partnerIncreases){
            foreach($partnerIncreases as $value){
                $sum += $value->bid;
            }
        }
        
        return $sum . " грн.";
    }

    //Сумма всех выведеных средств по партнерке в гривне
    public static function partnerWithdrawsSumUAN($partnerWithdraws){
        $sum = 0;
        // dd($partnerIncreases);
        if($partnerWithdraws){
            foreach($partnerWithdraws as $value){
                $sum += $value->ammount;
            }
        }
        
        return $sum . " грн.";
    }

    //Пополнение внутреннего счета партнера в двух таблицах
    //В таблице partner_check_increase
    //В таблице partner_check
    public static function partnerCreateIncrease(Referal $partner, Orders $order){
        $partnerId = $partner->id;
        $partnerRepo =  new PartnerRepository();
        $params = [
            'partner_id' => $partnerId,
            'order_id' => $order->id,
            'bid' => $order->partner_bid,//сумма пополнения партнерского счета, как правило 100 грн.
            'currensy' => $order->currensy,
        ];
        $incrase = $partnerRepo->setPartnerIncrease($partnerId, $params);//Создаем поле в таблице
        if($incrase){
            // partner_check обновляем внутренний баланс партнера. Так как данная запись конкретного партнера в таблице создается тогда, когда создается новый партнер
            // dd($partnerId);
            $partnerCheck = $partnerRepo->getPartnerCheck($partnerId);
            $newBalance = $partnerCheck->balance + $order->partner_bid;
            $partnerRepo->updatePartnerCheck($partnerCheck, ['balance' => $newBalance]);
        }
    }

    public static function partnerCheckBalance(Referal $partner){
        $partnerRepo =  new PartnerRepository();
        return $partnerRepo->getPartnerCheck($partner->id)->balance;
    }

    public static function allPartnerCheckBalances(){
        $partnerRepo =  new PartnerRepository();
        $all = $partnerRepo->getAllPartnerChecks();
        $balance = 0;
        foreach($all as $item){
            $balance += $item->balance;
        }
        return $balance;
        
    }

    //Снятие средств с внутреннего счета партнера
    public static function partnerCreateWithdraw(Referal $partner){
        
    }

    //Запрос на вывод партнером средств со статусом
    // public function hasPartnerRequestWithdraw($partnerId, $status = []){
    //     $item = new PartnerRepository;
    //     return $item->hasPartnerRequestWithdraw($partnerId, $status);
    // }

    public static function getPartnerRequestWithdraw($partnerId, $status = []){
        $item = new PartnerRepository;
        $has = $item->hasPartnerRequestWithdraw($partnerId, $status);
        return $has ? $item->getPartnerRequestWithdraw($partnerId, $status) : false;
    }

    public static function countPartnerRequestWithdraw($partnerId, $status = []){
        $item = new PartnerRepository;
        $count = $item->countPartnerRequestWithdraw($partnerId, $status);
        // dd($count);
        return $count;
    }

    public static function getPartnerRequestWithdrawStatusName($status){
        return PartnerRequestWithdraw::getStatusName($status);
    }

}    