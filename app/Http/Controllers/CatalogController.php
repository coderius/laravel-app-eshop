<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use App\Repositories\BrandRepository;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Category;

class CatalogController extends Controller
{
    protected $categoryRepo;
    protected $productRepo;
    protected $brandRepo;
 
    public function __construct(
        CategoryRepository $categoryRepo, 
        ProductRepository $productRepo,
        BrandRepository $brandRepo
    )
    {
        $this->categoryRepo = $categoryRepo;
        $this->productRepo = $productRepo;
        $this->brandRepo = $brandRepo;

    }
    
    // private function getCategoriesTree($categories){
    //     foreach($categories as $c){
    //         dd($c->categoriesByLevel());
    //         if($c->parent_id == 0){

    //         }
    //     }
    // }

    private function filter($products, $request){
        $sort  = $request->query('sort');
        $stock = $request->query('stock');

        $stock_title = "";
        if($stock){
            $stock_title = Product::flags()['in_stock'][$stock];
            $products = $products->where('in_stock', $stock);
        }

        $sort_title = '';
        if($sort){

            switch ($sort) {
                case "expensive":
                    $products = $products->orderBy('price', 'DESC');
                    $sort_title = "-сначала дороже";
                    break;
                case "cheaper":
                    $products = $products->orderBy('price', 'ASC');
                    $sort_title = "-сначала дешевле";
                    break;
                case "newest":
                    $products = $products->orderBy('created_at', 'DESC');
                    $sort_title = "-сначала вновь добавленые";
                    break;
                case "oldest":
                    $products = $products->orderBy('created_at', 'ASC');
                    $sort_title = "-сначала добавленые ранее";
                    break;    
            }
            
        }else{
            $products = $products->orderBy('created_at', 'DESC');
        }


        return [$products, $stock_title, $sort_title];
    }



    public function index(Request $request)
    {
        
        $categoris = $this->categoryRepo->getAllItems()->where('status', 1)->where('parent_id', 0);
        // $categoriesTree = $this->getCategoriesTree($categoris);
        $allProdCount = Product::where('status', 1)->count();
        $brands = $this->brandRepo->getAllItems()->where('status', 1);
        
        $products = Product::where('status', 1);
        
        //Filter-----------------------------------------------------------------------
        list($products, $stock_title, $sort_title) = $this->filter($products, $request);
        //Filter-----------------------------------------------------------------------

        $products = $products->paginate(24);
        // $sortRouteName = 'catalog';
        
        return view('catalog.index', [
            'categoris' => $categoris,
            'products' => $products,
            'brands' => $brands,
            'sort_title' => $sort_title,
            'stock_title' => $stock_title,
            'allProdCount' => $allProdCount
        ]);
    }

    public function brand($alias, Request $request)
    {
        $categoris = $this->categoryRepo->getAllItems()->where('status', 1)->where('parent_id', 0);
        // $products = $this->productRepo->getAllItems()->where('status', 1);
        $brands = $this->brandRepo->getAllItems()->where('status', 1);
        $allProdCount = Product::where('status', 1)->count();
        $products = Product::where('status', 1);

        //Add this code
        // $sortRouteName = 'brand';
        $brand = $this->brandRepo->getItemByAlias($alias);
        if($alias){
            $products = $products->where('brand_id', $brand->id);
        }
        
        //Filter-----------------------------------------------------------------------
        list($products, $stock_title, $sort_title) = $this->filter($products, $request);
        //Filter-----------------------------------------------------------------------
       
        $products = $products->paginate(24);
        
        return view('catalog.brand', [
            'categoris' => $categoris,
            'products' => $products,
            'brands' => $brands,
            'sort_title' => $sort_title,
            'stock_title' => $stock_title,
            'alias' => $alias,
            'brand' => $brand,
            'allProdCount' => $allProdCount
        ]);
    }

    private function getWithSubcatIds($ctgr){
        $res = $ctgr->categoriesByLevel($status = 1);
        $ar = [];
        $ar[] = $ctgr->id;
        foreach($res as $r){
            $ar[] = $r->id;
        }
        return $ar;
    }

    public function category($alias, Request $request)
    {
        $categoris = $this->categoryRepo->getAllItems()->where('status', 1)->where('parent_id', 0);
        $brands = $this->brandRepo->getAllItems()->where('status', 1);
        
        $products = Product::where('status', 1);
        $allProdCount = Product::where('status', 1)->count();
        
        //Add this code
        // $sortRouteName = 'category';
        $ctgr = $this->categoryRepo->getItemByAlias($alias);
        $withSubcatIds = $this->getWithSubcatIds($ctgr);
        // dd($withSubcatIds);
        if($alias){
            // $products = $products->where('category_id', $ctgr->id);
            $products = $products->whereIn('category_id', $withSubcatIds);
            // dd($products);
            // if($ctgr->categoriesByLevel()->count() > 0){
            //     foreach($ctgr->categoriesByLevel() as $subcat){
            //         $products = $products->where('category_id', $subcat->id);
            //     }
            // }

        }
        //Filter-----------------------------------------------------------------------
        list($products, $stock_title, $sort_title) = $this->filter($products, $request);
        //Filter-----------------------------------------------------------------------
        $products = $products->paginate(24);
        
        
        return view('catalog.category', [
            'categoris' => $categoris,
            'products' => $products,
            'brands' => $brands,
            'sort_title' => $sort_title,
            'stock_title' => $stock_title,
            'alias' => $alias,
            'ctgr' => $ctgr,
            'allProdCount' => $allProdCount
        ]);
    }
}
