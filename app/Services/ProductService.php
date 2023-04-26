<?php

namespace App\Services;

use App\Repositories\ProductRepository;
// $app = app();
// $likeService = app()->make(App\Services\CookieService::class)->getCookieUid();
class ProductService
{
    
    protected $productRepo;

    public function __construct()
    {
        $this->productRepo = app()->make(ProductRepository::class);
    }

    public function randomProducts($limit, $ownerId)
    {
        return $this->productRepo->getAllRandomItems($limit, $ownerId);
    }
    
}    