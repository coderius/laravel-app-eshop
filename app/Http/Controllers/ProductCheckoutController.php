<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ContactRepository;
use App\Repositories\ShippingMethodRepository;
use App\Repositories\ImageRepository;
use App\Repositories\CheckoutRepository;
use App\Services\CookieService;
use App\Models\Deals\Orders;
use App\Models\Product;
use App\Repositories\PartnerRepository;

class ProductCheckoutController extends Controller
{
    protected $categoryRepo;
    protected $productRepo;
    protected $contactRepo;
    protected $shippingMethodRepo;
    protected $imageRepo;
    protected $checkoutRepository;
    protected $partnerRepo;
 
    public function __construct(
        CategoryRepository $categoryRepo, 
        ProductRepository $productRepo, 
        ContactRepository $contactRepo, 
        ShippingMethodRepository $shippingMethodRepo,
        ImageRepository $imageRepo,
        CheckoutRepository $checkoutRepository,
        PartnerRepository $partnerRepo
    )
    {
        $this->categoryRepo = $categoryRepo;
        $this->productRepo = $productRepo;
        $this->contactRepo = $contactRepo;
        $this->shippingMethodRepo = $shippingMethodRepo;
        $this->imageRepo = $imageRepo;
        $this->checkoutRepository = $checkoutRepository;
        $this->partnerRepo = $partnerRepo;
        
    }

    public function making($id)
    {
        $product = $this->productRepo->getItemById($id);
        $product_state = Product::flags()['product_state'][$product->product_state];
        $in_stock = Product::flags()['in_stock'][$product->in_stock];
        $image = $this->imageRepo->getFirstItemInProduct($id);
        $category = $product->category()->first();
        $brand = $product->brand()->first();
        $phone = $this->contactRepo->getPhone();
        $viber = $this->contactRepo->getViber();
        $viberMobile = $this->contactRepo->getViberMobile();
        $telegram = $this->contactRepo->getTelegram();
        $shippingMethods = $this->shippingMethodRepo->getItemsByOwnerId($product->owner_id);
        // dd($shippingMethods);
        // $shippingMethods;
        // return response('grg');
        return view('product-checkout.making', [
            // 'home' => User::findOrFail($id),
            'product' => $product,
            'product_state' => $product_state,
            'in_stock' => $in_stock,
            'image' => $image,
            'category' => $category,
            'brand' => $brand,
            'phone' => $phone,
            'viber' => $viber,
            'viberMobile' => $viberMobile,
            'telegram' => $telegram,
            'shippingMethods' => $shippingMethods,
        ]);
    }

    public function orderProcessing(Request $request)
    {
        $validated = $request->validate([
            'surname' => 'required|string|max:50',
            'name' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
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
            'user_id' => Auth::check() ? Auth::id() : null,
            'cookie_uid' => app()->make(CookieService::class)->getCookieUid(),//для идентификации не зарегестрированого юзера, точнее что он смотрел
        ];

        $customer = $this->checkoutRepository->registerCastomer($params1);

        if($customer){

            $partner_id = null;
            $partnerCookie = app()->make(CookieService::class)->getCookiePartner();
            if($partnerCookie){
                $pId = explode("-", $partnerCookie);
                $partner_id = end($pId);
                
                //If cookie isset but in db no current partner enymore.
                if($this->partnerRepo->getById($partner_id) == false){
                    $partner_id = null;
                    app()->make(CookieService::class)->removeCookiePartner();
                }
            }
            

            $params2 = [
                'product_id' => $request->product_id,
                'partner_id' => $partner_id,
                'amount' => $request->amount,//Цена в магазине
                // 'margin' => $request->product_id,//Моя наценка. Устанавливаю вручную в админке при проверке поступившего заказа
                // 'partner_bid' => $request->product_id,//Партнерские
                'currensy' => $request->currensy,
                'status' => Orders::STATUS_NEW,//Статус заказа
                'comments' => $request->comments,//Комментарии клиента к заказу
            ];

            $order = $this->checkoutRepository->createOrder($params2);

            if($order){
                $this->checkoutRepository->createCustomerOrder(['castomer_id' => $customer->id, 'order_id' => $order->id]);

                return redirect()->back()->with('success', 'Спасибо! С Вами в ближайшее время свяжется наш менеджер.'); 
            }
        }
        

    }


}
