<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\OrderRepository;
use App\Repositories\PartnerRepository;
use App\Services\OrdersService;
use App\Services\PartnersService;
use App\Models\Deals\Orders;
use App\Models\Partner\PartnerRequestWithdraw;

class PartnerController extends Controller
{
    public $layout = 'layouts.admin-default';
    public $name = " Партнеры";
    
    protected $orderRepo;
    protected $partnerRepo;
 
    public function __construct(
        OrderRepository $orderRepo,
        PartnerRepository $partnerRepo
    )
    {
        $this->orderRepo = $orderRepo;
        $this->partnerRepo = $partnerRepo;
    }

    public function index()
    {
        $p_title = "Все" . $this->name;
        $items = $this->partnerRepo->getAllItemsWithPagination(50);

        return view('admin-part.partners.index', [
            'p_title' => $p_title,
            'items' => $items
        ]);
    }

    //Ajax get
    public function getPartnerActiveOrders($partnerId){
        $partner = $this->partnerRepo->getById($partnerId);
        $result = OrdersService::partnerOrdersActive($partner);
        
        return view('admin-part.partners._get-partner-active-orders', [
            'result' => $result,
        ]);
    }

    //Ajax get
    public function getPartnerAllOrders($partnerId){
        $partner = $this->partnerRepo->getById($partnerId);
        $result = OrdersService::partnerOrders($partner);
        
        return view('admin-part.partners._get-partner-all-orders', [
            'result' => $result,
        ]);
    }

    //Ajax get
    public function getPartnerTransactionsInfo($partnerId){
        $partnerIncreases = $this->partnerRepo->getPartnerIncreases($partnerId);//Все поступившие деньги по партнерке
        $partnerWithdraws = $this->partnerRepo->getPartnerWithdraws($partnerId);//Все выведеные деньги по партнерке
        $partnerTransactionsHistory = PartnersService::partnerTransactionsHistory($partnerIncreases, $partnerWithdraws);
        // $partner = $this->partnerRepo->getById($partnerId);
        // $result = OrdersService::partnerOrders($partner);
        
        return view('admin-part.partners._partner-transactions-info', [
            'partnerTransactionsHistory' => $partnerTransactionsHistory,
        ]);
    }
    //Ajax get
    public function getRequestWithdrawInfo($partnerId, $status){
        
        if($status == 0){
            $items = PartnersService::getPartnerRequestWithdraw($partnerId);
            $status = "Все запросы";//для партнера
        }else{
            $items = PartnersService::getPartnerRequestWithdraw($partnerId, [$status]);
            $status = PartnersService::getPartnerRequestWithdrawStatusName($status);//для партнера
        }
        // dd($items);
        return view('admin-part.partners._request_withdraw_info', [
            'items' => $items,
            'status' => $status
        ]);
    }

    //Обновляем запись о запросе вывода средств
    //Форма обновления на новой странице
    public function updateRequestWithdraw($id, Request $request){
        $item = $this->partnerRepo->getRequestWithdrawById($id);
        $p_title = "Обновить запрос на вывод денег для партнера ID " . $item->partner_id;
        
        if ($request->isMethod('post')){

            $params = [
                'partner_id'        =>  $request->input('partner_id'),
                'fio'       =>  $request->input('fio'),
                'card_num'       =>  $request->input('card_num'),
                'status' =>  $request->input('status'),
                'amaunt'      =>  $request->input('amaunt'),
                'admin_comments'      =>  $request->input('admin_comments'),
            ];

            if($this->partnerRepo->updateRequestWithdraw($item, $params)){
                //Тут уменьшаем внутренний счет на сумму, которую перевели на карточку партнера
                //И делаем запись в таблицу выводов из внутреннего счета
                //Если статус админ установил для запроса на вывод средств как PartnerRequestWithdraw::SUCCESSED
                if($request->input('status') == PartnerRequestWithdraw::SUCCESSED){
                    $check = $this->partnerRepo->getPartnerCheck($request->input('partner_id'));
                    $newBalance = (int) $check->balance - (int) $request->input('amaunt');
                    if($newBalance < 0){
                        $newBalance = 0;
                    }
                    
                    if($this->partnerRepo->updatePartnerCheck($check, ['balance' => $newBalance])){
                        //Записываем в историю выплат
                        $paramsWithdraw = [
                            'partner_id' => $request->input('partner_id'),
                            'ammount' => $request->input('amaunt'),
                            'request_withdraw_id' => $id
                        ];

                        $this->partnerRepo->setPartnerWithdraw($request->input('partner_id'), $paramsWithdraw);
                    }

                }
                
                return redirect()->route('admin-partners-index');
            }
            
        }

        return view('admin-part.partners.update-request-withdraw', [
            'item' => $item,
            'p_title' => $p_title
        ]);
    }


    // public function create(Request $request)
    // {
    //     $p_title = "Создать" . $this->name;

    //     if ($request->isMethod('post')) {

    //         $params = [
    //             'name'        =>  $request->input('name'),
    //             'alias'       =>  $request->input('alias'),
    //             'title'       =>  $request->input('title'),
    //             'description' =>  $request->input('description'),
    //             'status'      =>  $request->input('status'),
    //         ];

    //         if($this->brandRepo->createItem($params)){
    //             return redirect()->route('admin-brand-index');
    //         }
            
    //     }
        
    //     return view('admin-part.brand.create', [
    //         'p_title' => $p_title
    //     ]);
    // }

    // public function update($id, Request $request)
    // {
    //     $p_title = "Обновить" . $this->name;
    //     $item = $this->brandRepo->getItemById($id);

    //     if ($request->isMethod('post')) {

    //         $params = [
    //             'name'        =>  $request->input('name'),
    //             'alias'       =>  $request->input('alias'),
    //             'title'       =>  $request->input('title'),
    //             'description' =>  $request->input('description'),
    //             'status'      =>  $request->input('status'),
    //         ];

    //         if($this->brandRepo->updateItem($item, $params)){
    //             return redirect()->route('admin-brand-index');
    //         }

    //     }

    //     return view('admin-part.brand.update', [
    //         'p_title' => $p_title,
    //         'item' => $item
    //     ]);
    // }

    public function delete($id)
    {
        $this->brandRepo->deleteItem($id);
        return redirect()->route('admin-partners-index');
    }
}
