<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use App\Repositories\BrandRepository;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class RssController extends Controller
{
    protected $productRepo;
    protected $categoryRepo;
    protected $brandRepo;
 
    public function __construct(
        ProductRepository $productRepo,
        CategoryRepository $categoryRepo,
        BrandRepository $brandRepo
    )
    {
        $this->productRepo = $productRepo;
        $this->categoryRepo = $categoryRepo;
        $this->brandRepo = $brandRepo;
    }
    
    public function index() {
        $products   = Product::where(['status' => 1])->orderBy('created_at', 'DESC')->get();

        return response()->view('rss.index', [
            'products' => $products,
        ])->header('Content-Type', 'text/xml');
    }


    public function theme($alias) {
        $category = $this->categoryRepo->getItemByAlias($alias);
        $products = Product::where('status', 1)->where('category_id', $category->id)->orderBy('created_at', 'DESC')->get();
        
        return response()->view('rss.theme', [
            'products' => $products,
            'category' => $category,
        ])->header('Content-Type', 'text/xml');
    }

    public function getActiveRssFeeds() {
        $categoris = $this->categoryRepo->getAllItems()->where('status', 1);
        $feeds = [];
        foreach($categoris as $c){
            if($c->productsActive()->count() > 0){
                $feeds[] = route('rss-theme', ['alias' => $c->alias]);
            }
            
            // $feeds[] = $c->alias;
        }
        dd($feeds);
        return response()->json(['success'=>'ok.', 'feeds' => $feeds]);
    }

    public function getActiveProductUrls() {
        $products   = Product::where(['status' => 1])->orderBy('created_at', 'DESC')->get();

        return response()->view('rss.text', [
            'products' => $products,
        ]);
    }

}
