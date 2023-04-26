<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;

class CategoryController extends Controller
{
    protected $categoryRepo;
    protected $productRepo;
 
    public function __construct(CategoryRepository $categoryRepo, ProductRepository $productRepo)
    {
        $this->categoryRepo = $categoryRepo;
        $this->productRepo = $productRepo;
    }

    public function index($alias)
    {
        $category = $this->categoryRepo->getItemByAlias($alias);
        // return response('grg');
        return view('category.index', [
            // 'home' => User::findOrFail($id),
            'category' => $category
        ]);
    }
}
