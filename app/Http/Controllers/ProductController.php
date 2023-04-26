<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ContactRepository;
use App\Repositories\ShippingMethodRepository;
use App\Repositories\ProductViewRepository;
use App\Models\Product;
use App\Services\CookieService;

class ProductController extends Controller
{
    protected $categoryRepo;
    protected $productRepo;
    protected $contactRepo;
    protected $shippingMethodRepo;
    protected $productViewRepo;
 
    public function __construct(
        CategoryRepository $categoryRepo, 
        ProductRepository $productRepo, 
        ContactRepository $contactRepo, 
        ShippingMethodRepository $shippingMethodRepo,
        ProductViewRepository $productViewRepo
    )
    {
        $this->categoryRepo = $categoryRepo;
        $this->productRepo = $productRepo;
        $this->contactRepo = $contactRepo;
        $this->shippingMethodRepo = $shippingMethodRepo;
        $this->productViewRepo = $productViewRepo;
    }

    // public static function getImgSrc($idImg, $aliasImg, $size = "big")
    // {
    //     return asset("images/products/$idImg/$size/$aliasImg");
    // }

    public function index($alias)
    {
        $product = $this->productRepo->getItemByAlias($alias);
        
        if(!$product){
            return response()->view('errors.404')->setStatusCode(404); 
        }
        

        $product_state = Product::flags()['product_state'][$product->product_state];
        $in_stock = Product::flags()['in_stock'][$product->in_stock];
        $images = $product->images()->get();
        $category = $product->category()->first();
        $brand = $product->brand()->first();
        $phone = $this->contactRepo->getPhone();
        $viber = $this->contactRepo->getViber();
        $viberMobile = $this->contactRepo->getViberMobile();
        $telegram = $this->contactRepo->getTelegram();
        $shippingMethods = $this->shippingMethodRepo->getItemsByOwnerId($product->owner_id);
        //dd($shippingMethods);
        // $shippingMethods;
        // return response('grg');

        $widget = $this->toWidget($category);

        $this->viewCounter($product->id);

        return view('product.index', [
            // 'home' => User::findOrFail($id),
            'product' => $product,
            'product_state' => $product_state,
            'in_stock' => $in_stock,
            'images' => $images,
            'category' => $category,
            'brand' => $brand,
            'phone' => $phone,
            'viber' => $viber,
            'viberMobile' => $viberMobile,
            'telegram' => $telegram,
            'shippingMethods' => $shippingMethods,
            'widget' => $widget
        ]);
    }

    protected function toWidget($category = false, $brand = false, $limit = 5){

        
        // dd(get_class($category));
        if(!$category && !$brand){
            return false;
        }

        if($category){
            return Product::where(['status' => 1])
            ->where(['category_id' => $category->id])
            ->inRandomOrder()
            ->take($limit)
            ->get();
        }

        if($brand){
            return Product::where(['status' => 1])
            ->where(['brand_id' => $brand->id])
            ->inRandomOrder()
            ->take($limit)
            ->get();
        }
    }    

    protected function viewCounter($prodId){
        $ip = request()->ip();
        $notAdminIp = $ip !== "185.38.219.148";
        $notAdmin = Auth::check() && Auth::user()->is_admin ?  false : true;
        $cookie_uid = app()->make(CookieService::class)->getCookieUid();

        if(!$ip){
            return false;
        }

        if(!$cookie_uid){
            return false;
        }

        if($notAdmin && $notAdminIp){
            $res = $this->productViewRepo->getItemByProductId($prodId);
            //update
            if($res){
                $res->views = $res->views + 1;
                $res->user_id = Auth::check() ? Auth::id() : null;
                $res->cookie_uid = $cookie_uid;
                $res->ip = $ip;
                $res->save();

            //create
            }else{
                $this->productViewRepo->createItem($prodId);
            }
        }
    }

}
