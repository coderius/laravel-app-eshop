<?php

namespace App\Services;

use App\Models\Like;
use App\Repositories\LikeRepository;
use App\Repositories\ProductRepository;
use Cookie;

class LikeService
{
    protected $likeRepo;
    protected $productRepo;

    private $_cookieName = "uId";
 
    public function __construct(
        LikeRepository $likeRepo,
        ProductRepository $productRepo
    )
    {
        $this->likeRepo = $likeRepo;
        $this->productRepo = $productRepo;
    }
    
    public function isProductLiked($product_id){
        $uId = Cookie::get($this->_cookieName);
        if($uId){
            $like = $this->likeRepo->getItem($product_id, $uId);
            if($like){
                return (bool) $like->status;
            }
        }

        return false;
    }

    public function countPersonLikes(){
        $uId = Cookie::get($this->_cookieName);
        if($uId){
            return $this->likeRepo->getCountLikesForPerson($uId);
        }

        return 0;
    }

    public function getCookieUid(){
        return Cookie::get($this->_cookieName);
    }

    public function getWishList(){
        $uid = $this->getCookieUid();
        if($uid){
            $likes = $this->likeRepo->getQueryLikesForPerson($uid);
            if($likes->count()){
                return $likes;
            }
        }
        return false;
    }

}    