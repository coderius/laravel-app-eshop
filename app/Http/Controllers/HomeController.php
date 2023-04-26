<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\CategoryRepository;
use App\Repositories\ContactRepository;
use App\Repositories\ProductRepository;

class HomeController extends Controller
{
    
    // public $layout = 'layouts.default';

    protected $categoryRepo;
    protected $contactRepo;
    protected $productRepo;
 
    public function __construct(
        CategoryRepository $categoryRepo, 
        ContactRepository $contactRepo,
        ProductRepository $productRepo
    )
    {
        $this->categoryRepo = $categoryRepo;
        $this->contactRepo = $contactRepo;
        $this->productRepo = $productRepo;
    }

    public function index(Request $request)
    {
        // $categories = $this->categoryRepo->getTopLevelItemsWithProducts();
        $categories = $this->categoryRepo->getTopLevelItems();
        $newProducts = $this->productRepo->getAllNewItems(10);
        $randomProducts = $this->productRepo->getAllRandomItems(8);
        // return response('grg');
        return view('home.index', [
            // 'home' => User::findOrFail($id),
            'categories' => $categories,
            'newProducts' => $newProducts,
            'randomProducts' => $randomProducts,
        ]);
    }

    public function contacts(Request $request)
    {
        // $contacts = $this->contactRepo->getAllItems();
        $phone = $this->contactRepo->getPhone();
        $viber = $this->contactRepo->getViber();
        $viberMobile = $this->contactRepo->getViberMobile();
        $telegram = $this->contactRepo->getTelegram();
        $telegramGroupShop = $this->contactRepo->getTelegramGroupShop();
        $urls = $this->contactRepo->getUrl();
        
        return view('home.contacts', [
            'phone' => $phone,
            'viber' => $viber,
            'viberMobile' => $viberMobile,
            'telegram' => $telegram,
            'telegramGroupShop' => $telegramGroupShop,
            'urls' => $urls,
        ]);
    }

    public function update(Request $request, $id)
    {
        //
    }

}
