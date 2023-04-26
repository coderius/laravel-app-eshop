<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\OrderRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use App\Repositories\PartnerRepository;
use App\Repositories\ContactRepository;
use App\Repositories\ShippingMethodRepository;
use App\Repositories\ImageRepository;
use App\Repositories\CheckoutRepository;
use App\Services\CookieService;
use App\Services\PartnersService;
use App\Models\Deals\Orders;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public $layout = 'layouts.admin-default';
    public $name = " Заказы";
    
    protected $orderRepo;
    protected $categoryRepo;
    protected $productRepo;
    protected $contactRepo;
    protected $shippingMethodRepo;
    protected $imageRepo;
    protected $checkoutRepository;
    protected $partnerRepo;
 
    public function __construct(
        OrderRepository $orderRepo,
        CategoryRepository $categoryRepo, 
        ProductRepository $productRepo, 
        ContactRepository $contactRepo, 
        ShippingMethodRepository $shippingMethodRepo,
        ImageRepository $imageRepo,
        CheckoutRepository $checkoutRepository,
        PartnerRepository $partnerRepo
    )
    {
        $this->orderRepo = $orderRepo;
        $this->categoryRepo = $categoryRepo;
        $this->productRepo = $productRepo;
        $this->contactRepo = $contactRepo;
        $this->shippingMethodRepo = $shippingMethodRepo;
        $this->imageRepo = $imageRepo;
        $this->checkoutRepository = $checkoutRepository;
        $this->partnerRepo = $partnerRepo;
    }

    public function index(Request $request)
    {
        $p_title = "Все" . $this->name;
        $items = Orders::orderBy('created_at', 'DESC');

        if ($request->isMethod('post'))
        {
            foreach($request->input('search-param') as $param){
                $items->orWhere($param, 'like', '%' . $request->input('search') . '%');
            }
        }

        
        return view('admin-part.orders.index', [
            'p_title' => $p_title,
            'items' => $items->paginate(40),
        ]);
    }

    //Изменение статуса заказов выбранных чекбоксом
    //ТУТ ПОПОЛНЯЕТСЯ ВНУТРЕННИ СЧЕТ ПАРТНЕРА
    public function checkboxAction(Request $request)
    {
        if ($request->isMethod('post')) {
            $ids = $request->input('ids');
            $status = $request->input('checkbox-select-status');
            if($status)
            {
                foreach($ids as $id){
                    $order = $this->orderRepo->getById($id);
                    $this->orderRepo->updateItem($order, ['status' => $status]);
                    //-----------------------------------
                    //ТУТ ПОПОЛНЯЕМ ВНУТРЕННИ БАЛАНС ПАРТНЕРА 
                    //Если статус заказа ставится как завершенный, то тут проверяем
                    //есть ли партнерка, если да, то пополняем внутренний баланс партнера на сумму, указанную в заказе
                    //Обьект $order должен быть уже обнавлен
                    $this->eventStatusSuccess($order);
                    
                }
            }
        }
        return redirect()->route('admin-orders-index');
    }

    //Это просто хелпер. Не событие фреймворка.
    public function eventStatusSuccess(Orders $order){
        // var_dump($order->status);exit();
        if($order->status == Orders::STATUS_SUCCESS){
            // var_dump($order->status);exit();
            //ТУТ ПОПОЛНЯЕМ ВНУТРЕННИ БАЛАНС ПАРТНЕРА 
            //Если статус заказа ставится как завершенный, то тут проверяем
            //есть ли партнерка, если да, то пополняем внутренний баланс партнера на сумму, указанную в заказе
            $partnerId = $order->partner_id ? : false;
            if($partnerId){
                $partner = $this->partnerRepo->getById($partnerId);
                PartnersService::partnerCreateIncrease($partner, $order);
            }
        }
        return;
    }

    public function create(Request $request)
    {
        $p_title = "Создать" . $this->name;

        if ($request->isMethod('post')) {

            $validated = $request->validate([
                'surname' => 'required|string|max:50',
                'name' => 'required|string|max:50',
                'region' => 'required|string|max:50',
                'locality' => 'required|string|max:50',
                'phone' => 'required|string|max:50',
                'mail_num' => 'required|numeric',
                // 'phone_viber' => 'required',
                // 'phone_telegram' => 'required',
                'email' => 'required|email',
                // 'product_id' => 'required|confirmed|min:8',
            ]);
    
            $params1 = [
                'surname' => $request->surname,
                'name' => $request->name,
                'region' => $request->region,
                'locality' => $request->locality,
                'phone' => $request->phone,
                'mail_num' => $request->mail_num,
                'phone_viber' => $request->phone_viber,
                'phone_telegram' => $request->phone_telegram,
                'email' => $request->email,
                'user_id' => Auth::check() ? Auth::id() : null,
                'cookie_uid' => null,//зачем админу куки!
            ];

            $customer = $this->checkoutRepository->registerCastomer($params1);

            if($customer){
                $params2 = [
                    'product_id' => $request->product_id,
                    'partner_id' => $request->partner_id,
                    'amount' => $request->amount,//Цена в магазине
                    'margin' => $request->product_id,//Моя наценка. Устанавливаю вручную в админке при проверке поступившего заказа
                    'partner_bid' => $request->partner_bid,//Партнерские
                    'currensy' => $request->currensy,
                    'status' => $request->status,//Статус заказа
                    'comments' => $request->comments,//Комментарии клиента к заказу
                    'admin_noties' => $request->admin_noties,
                ];
    
                $order = $this->checkoutRepository->createOrder($params2);
    
                if($order){
                    $this->checkoutRepository->createCustomerOrder(['castomer_id' => $customer->id, 'order_id' => $order->id]);
                    //-----------------------------------
                    //ТУТ ПОПОЛНЯЕМ ВНУТРЕННИ БАЛАНС ПАРТНЕРА 
                    //Если статус заказа ставится как завершенный, то тут проверяем
                    //есть ли партнерка, если да, то пополняем внутренний баланс партнера на сумму, указанную в заказе
                    //Обьект $order должен быть уже обнавлен
                    $this->eventStatusSuccess($order);
                    return redirect()->route('admin-orders-index');
                }
            }

        }
        
        return view('admin-part.orders.create', [
            'p_title' => $p_title,
            'products' => $this->productRepo->getAllItems(Product::STATUS_ACTIVE),
        ]);
    }

    public function update($id, Request $request)
    {
        $p_title = "Обновить" . $this->name;
        $item = $this->orderRepo->getById($id);
        $cus = $item->getCustomer($item->id);

        if ($request->isMethod('post')) {

            $validated = $request->validate([
                'surname' => 'required|string|max:50',
                'name' => 'required|string|max:50',
                'lastname' => 'max:50',
                'region' => 'required|string|max:50',
                'locality' => 'required|string|max:50',
                'phone' => 'required|string|max:50',
                'mail_num' => 'required|numeric',
                // 'phone_viber' => 'required',
                // 'phone_telegram' => 'required',
                'email' => 'required|email',
                // 'product_id' => 'required|confirmed|min:8',
            ]);
    
            $params1 = [
                'surname' => $request->surname,
                'name' => $request->name,
                'lastname' => $request->lastname,
                'region' => $request->region,
                'locality' => $request->locality,
                'phone' => $request->phone,
                'mail_num' => $request->mail_num,
                'phone_viber' => $request->phone_viber,
                'phone_telegram' => $request->phone_telegram,
                'email' => $request->email,
                'user_id' => $request->user_id,
                'cookie_uid' => $request->cookie_uid,
            ];

            $customer = $this->checkoutRepository->updateCustomer($cus, $params1);

            if($customer){
                $params2 = [
                    'product_id' => $request->product_id,
                    'partner_id' => $request->partner_id,
                    'amount' => $request->amount,//Цена в магазине
                    'margin' => $request->margin,//Моя наценка. Устанавливаю вручную в админке при проверке поступившего заказа
                    'partner_bid' => $request->partner_bid,//Партнерские
                    'currensy' => $request->currensy,
                    'status' => $request->status,//Статус заказа
                    'comments' => $request->comments,//Комментарии клиента к заказу
                    'admin_noties' => $request->admin_noties,
                ];
    
                $order = $this->orderRepo->updateItem($item, $params2);
    
                if($order){
                    //-----------------------------------
                    //ТУТ ПОПОЛНЯЕМ ВНУТРЕННИ БАЛАНС ПАРТНЕРА 
                    //Если статус заказа ставится как завершенный, то тут проверяем
                    //есть ли партнерка, если да, то пополняем внутренний баланс партнера на сумму, указанную в заказе
                    //Обьект $order должен быть уже обнавлен
                    $this->eventStatusSuccess($order);
                    // $this->checkoutRepository->createCustomerOrder(['castomer_id' => $customer->id, 'order_id' => $order->id]);//id не меняем, нахрен этот метод тут
                    return redirect()->route('admin-orders-index');
                }
            }

        }

        return view('admin-part.orders.update', [
            'p_title' => $p_title,
            'item' => $item
        ]);
    }

    public function delete($id)
    {
        return redirect()->back();
    }
}
