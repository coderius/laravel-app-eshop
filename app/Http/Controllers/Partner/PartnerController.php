<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Repositories\ProductOwnerRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ImageRepository;
use App\Repositories\PartnerRepository;
use App\Services\PartnersService;
use App\Models\ProductOwner;
use App\Models\Product;
use App\Models\Image;
use App\Repositories\BrandRepository;
use ImageLib;
use File;
use App\Models\Partner\PartnerRequestWithdraw;

class PartnerController extends Controller
{
    public $layout = 'layouts.default';
    public $nameHelper = " Продукты";
    public $idHelper = "product";
    
    protected $productRepo;
    protected $productOwnerRepo;
    protected $imageRepo;
    protected $categoryRepo;
    protected $brandRepo;
    protected $partnerRepo;
 
    public function __construct(
        ProductOwnerRepository $productOwnerRepo,
        ProductRepository $productRepo,
        ImageRepository $imageRepo,
        CategoryRepository $categoryRepo,
        BrandRepository $brandRepo,
        PartnerRepository $partnerRepo
    )
    {
        $this->productOwnerRepo = $productOwnerRepo;
        $this->productRepo = $productRepo;
        $this->imageRepo = $imageRepo;
        $this->categoryRepo = $categoryRepo;
        $this->brandRepo = $brandRepo;
        $this->partnerRepo = $partnerRepo;
    }

    public function index(Request $request)
    {
        $id = $request->session()->get('partnerId');
        $partner = $this->partnerRepo->getById($id);
        $partnerCheck = $this->partnerRepo->getPartnerCheck($partner->id);//Баланс средств по портнерке
        $partnerIncreases = $this->partnerRepo->getPartnerIncreases($partner->id);//Все поступившие деньги по партнерке
        $partnerWithdraws = $this->partnerRepo->getPartnerWithdraws($partner->id);//Все выведеные деньги по партнерке
        $partnerWithdrawsSumUAN = PartnersService::partnerWithdrawsSumUAN($partnerWithdraws);//Сумма денег в гривне выведеная
        $partnerIncreasesSumUAN = PartnersService::partnerIncreasesSumUAN($partnerIncreases);//Сумма денег в гривне зарпаботаная
        $partnerTransactionsHistory = PartnersService::partnerTransactionsHistory($partnerIncreases, $partnerWithdraws);
        
        return view('partner.index', [
            'header' => "Личный кабинет партнера",
            'partner' => $partner,
            'partnerCheck' => $partnerCheck,
            'partnerIncreases' => $partnerIncreases,
            'partnerIncreasesSumUAN' => $partnerIncreasesSumUAN,
            'partnerWithdrawsSumUAN' => $partnerWithdrawsSumUAN,
            'partnerTransactionsHistory' => $partnerTransactionsHistory
        ]);
    }

    //История всех транзакций
    public static function partnerTransactionsHistory($partnerIncreases, $partnerWithdraws){
        $arr1 = [];
        if($partnerIncreases){
            foreach($partnerIncreases as $k => $v){
                $arr1[$k]['data'] = $v->created_at->toDateTimeString();
                $arr1[$k]['type'] = "Поступление от продажи";
                $arr1[$k]['info'] = "<a href='" . route('product', ['alias' => $v->order->product->alias]) . "'>". $v->order->product->short_title ."</a>";
                $arr1[$k]['money'] = $v->bid;
            }
        }
        
        $arr2 = [];
        if($partnerWithdraws){
            foreach($partnerWithdraws as $k => $v){
                $arr2[$k]['data'] = $v->created_at->toDateTimeString();
                $arr2[$k]['type'] = "Вывод денег";
                $arr2[$k]['info'] = "";
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

    public function partnerСonditions(Request $request)
    {
        return view('partner.сonditions', [
            // 'header' => "bgfbfb",
        ]);
    }

    public function registerForm(Request $request)
    {
        return view('partner.register', []);
    }

    public function loginForm(Request $request)
    {
        return view('partner.login', []);
    }

    public function login(Request $request)
    {
        $this->validate(request(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        $partner = $this->partnerRepo->getByEmail($request->email);
        
        if($partner && Hash::check($request->password, $partner->password)){
            $partnerId = $partner->id;
            $this->setAccess($partnerId, $request);
            return redirect()->to('/partner');
        }else{
            return redirect()->back()->withErrors(['error'=>'Не корректный логин или пароль'])->withInput();
        }
    }

    public function logout(Request $request)
    {
        $this->deleteAccess($request);
        return redirect()->to('/');
    }
    
    public function create(Request $request)
    {
        $this->validate(request(), [
            'login' => 'required|unique:referal,login',
            'email' => 'required|email|unique:referal,email',
            'password' => 'required|confirmed|min:8',
            // 'password_confirmation' => 'required'
        ]);
        
        $partner = $this->partnerRepo->registerPartner(request(['login', 'email', 'password', 'phone', 'telegram_phone', 'viber_phone']));


        if($partner){
            $partnerId = $partner->id;
            $this->setAccess($partnerId, $request);
        }

        // dd($request);
        return redirect()->to('/partner')->withInput();
    }

    public function changePartnerInfo(Request $request)
    {
        $name = $request->name;
        $value = $request->value;
        $partnerId = $request->partnerId;

        $partner = $this->partnerRepo->getById($partnerId);

        if($partner){
            
            $partner->$name = $value;

            if($partner->save()){
                return response()->json(['status'=> 'success', 'value' => $value]);
            }else{
                return response()->json(['status'=> 'error', 'value' => "Not saved"]);
            }
        }

        return response()->json(['success'=>'error', 'value' => "Not find"]);
    }

    public function partnerCashOutForm(Request $request)
    {
        
        $partner = $this->getPartner($request);
        $partnerCheck = $this->partnerRepo->getPartnerCheck($partner->id);

        return view('partner.partner-cash-out-form', [
            "partner" => $partner,
            "partnerCheck" => $partnerCheck
        ]);
    }

    //Запрос на вывод денег партнера
    public function partnerCashOutFormRequest(Request $request)
    {
        $this->validate(request(), [
            'amaunt' => 'required',
            'card_num' => 'required',
            'fio' => 'required',
        ]);
        
        $partnerId = $this->getPartner($request)->id;
        $status = PartnerRequestWithdraw::NEW;
        $amaunt = $request->amaunt;
        $card_num = $request->card_num;
        $fio = $request->fio;
// dd($partnerId);
        //Get balance
        $partnerCheck = $this->partnerRepo->getPartnerCheck($partnerId);
        $partnerCheck->balance;

        if($partnerCheck->balance < $amaunt){
            return redirect()->back()->withErrors(['error'=>'Сумма указанная Вами превышает доступный баланс для вывода денег'])->withInput();
        }

        $params = [
            'partner_id' => $partnerId,
            'fio' => $fio,
            'card_num' => $card_num,
            'status' => $status,
            'amaunt' => $amaunt,
        ];
        
        $this->partnerRepo->createPartnerRequestWithdraw($partnerId, $params);

        return redirect()->back()->with('success', 'Ваш запрос принят. В ближайшее время '. $amaunt .'грн. будут перечислены на карту, указанную Вами!'); ;
        
    }

    ////////////////////////////////////////////////////////////////


    protected function setAccess($partnerId, Request $request){
        $request->session()->put('partnerId', $partnerId);
    }

    protected function deleteAccess(Request $request){
        $request->session()->forget('partnerId');
    }

    protected function checkAccess(Request $request){
        return $request->session()->has('partnerId');
    }
    
    protected function getPartner(Request $request){
        $partnerId = $request->session()->get('partnerId');
        if($this->checkAccess($request)){
            return $this->partnerRepo->getById($partnerId);
        }
        return false;
    }

    

    

}
