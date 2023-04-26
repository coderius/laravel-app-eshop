<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\Repositories\LikeRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Auth;
use Cookie;
use Illuminate\Support\Str;
use App\Services\LikeService;

class LikesController extends Controller
{
    protected $likeRepo;
    protected $productRepo;
    protected $service;

    private $_cookieName = "uId";
 
    public function __construct(
        LikeRepository $likeRepo,
        ProductRepository $productRepo,
        LikeService $service
    )
    {
        $this->likeRepo = $likeRepo;
        $this->productRepo = $productRepo;
        $this->service = $service;
    }
    
    public function like(Request $request)
    {
        $prodId = $request->prodId;
        $uId = Cookie::get($this->_cookieName);

        //New user
        //Set cookie and create item
        if(!$uId){
            $uId = (string) Str::uuid();
            Cookie::queue($this->_cookieName, $uId, 60*24*365*2);
            $params = [
                'product_id' => $prodId,
                'cookie_name' => $this->_cookieName,
                'cookie_val' => $uId,
                'user_id' => Auth::id(),
                'status' => 1
            ];
    
            $this->likeRepo->createItem($params);
            return response()->json(['success'=>'ok.', 'status'=>1]);
        }

        //User not new
        $item = $this->likeRepo->getItem($prodId, $uId);
        
        //User clicked to button later
        if($item){
            $item->status = $item->status == 0 ? 1 : 0;
            $item->save();
            return response()->json(['success'=>'ok', 'status'=>$item->status]);
        }else{//new click to like in current product by user with registyered cookies
            $params = [
                'product_id' => $prodId,
                'cookie_name' => $this->_cookieName,
                'cookie_val' => $uId,
                'user_id' => Auth::id(),
                'status' => 1
            ];
    
            $this->likeRepo->createItem($params);
            return response()->json(['success'=>'ok', 'status'=>1]);
        }
    }

    public function unlike(Request $request)
    {
        // $input = $request->all();
          
        // Log::info($input);
     
        return response()->json(['success'=>'Got Simple Ajax Request.']);
    }

    public function getCountLikesForPerson(Request $request){
        $count = $this->service->countPersonLikes();
        return response()->json(['success'=>'ok', 'count'=>$count]);
    }

    public function wishlist(Request $request){
        $count = $this->service->countPersonLikes();
        $list = $this->service->getWishList();
        $list = $list ? $list->paginate(25) : false;
        
        return view('likes.wishlist', [
            'list' => $list,
        ]);
    }
}
