<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use App\Repositories\BrandRepository;

class BrandController extends Controller
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
    
    public function index($alias)
    {
        $brand = $this->brandRepo->getItemByAlias($alias);
        // return response('grg');
        return view('brand.index', [
            // 'home' => User::findOrFail($id),
            'brand' => $brand
        ]);
    }
}
