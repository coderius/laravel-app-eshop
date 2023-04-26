<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use App\Repositories\BrandRepository;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class SitemapXmlController extends Controller
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
        $products   = Product::where(['status' => 1])->orderBy('updated_at', 'DESC')->get();
        $categories = Category::where(['status' => 1])->orderBy('updated_at', 'DESC')->get();
        $brands     = Brand::where(['status' => 1])->orderBy('updated_at', 'DESC')->get();


        return response()->view('sitemap-xml.index', [
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands,
        ])->header('Content-Type', 'text/xml');
      }
}
