<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\ProductOwnerRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ImageRepository;
use App\Models\ProductOwner;
use App\Models\Product;
use App\Models\Image;
use App\Repositories\BrandRepository;
use ImageLib;
use File;

class ProductsController extends Controller
{
    public $layout = 'layouts.admin-default';
    public $nameHelper = " Продукты";
    public $idHelper = "product";
    
    protected $productRepo;
    protected $productOwnerRepo;
    protected $imageRepo;
    protected $categoryRepo;
    protected $brandRepo;
 
    public function __construct(
        ProductOwnerRepository $productOwnerRepo,
        ProductRepository $productRepo,
        ImageRepository $imageRepo,
        CategoryRepository $categoryRepo,
        BrandRepository $brandRepo
    )
    {
        $this->productOwnerRepo = $productOwnerRepo;
        $this->productRepo = $productRepo;
        $this->imageRepo = $imageRepo;
        $this->categoryRepo = $categoryRepo;
        $this->brandRepo = $brandRepo;
    }

    public function index(Request $request)
    {
        $p_title = "Все" . $this->nameHelper;
        $items = Product::orderBy('created_at', 'DESC');
        if ($request->isMethod('post'))
        {
            // $items->where([$request->input('param') => $request->input('search')]);
            foreach($request->input('param') as $param){
                $items->orWhere($param, 'like', '%' . $request->input('search') . '%');
            }
            // $items->where($request->input('param'), 'like', '%' . $request->input('search') . '%');
        }
        // $items->paginate(40);
        

        return view('admin-part.' . $this->idHelper . '.index', [
            'p_title' => $p_title,
            'items' => $items->paginate(40),
            'idHelper' => $this->idHelper,
            'nameHelper' => $this->nameHelper,
            'search_header' => $request->isMethod('post') ? "Результаты поиска для " . "'" . $request->input('search') . "'" : false,
            'data_search' => $request->input('search'),
        ]);
    }

    //Create
    public function create(Request $request)
    {
        $p_title = "Создать" . $this->nameHelper;

        $categories = $this->categoryRepo->getAllItems();
        $brands = $this->brandRepo->getAllItems();
        $productOwners = $this->productOwnerRepo->getAllItems();

        if ($request->isMethod('post')) {
            // dd($request->input('imagesInfo'));
            // dd($request->hasfile('files'));
            
            $params = [
                'category_id'        =>  (int) $request->input('category_id'),
                'brand_id'       =>  (int) $request->input('brand_id'),
                'owner_id'       =>  (int) $request->input('owner_id'),
                'alias'       =>  $request->input('alias'),
                'price'       =>  (int) $request->input('price'),
                'short_title'       =>  $request->input('short_title'),
                'title'      =>  $request->input('title'),
                'description'      =>  $request->input('description'),
                'tags'      =>  $request->input('tags'),
                'header'      =>  $request->input('header'),
                'content'      =>  $request->input('content'),
                'owner_article'      =>  $request->input('owner_article'),
                'in_stock'      =>  (int) $request->input('in_stock'),
                'product_state'      =>  (int) $request->input('product_state'),
                'my_noties'      =>  $request->input('my_noties'),
                'status'      =>  (int) $request->input('status'),

            ];

            $res = $this->productRepo->createItem($params);

            
            if($res){//if product saved

                // //---Image creation
                $prodId = $res->id;
                $imgAlt = $request->input('short_title') . " фото-";

                $imagesInfo = $request->input('imagesInfo');//inputs with src
                // dd($imagesInfo);return;
                // $request->hasFile('input_img');
                $images = $request->file('images');//files
                //to update
                // $this->imageRepo->getItemsByProductId($id);
                
                foreach($images as $image){
                    //create file
                    // $image = $request->file('input_img');
                    $name = $image->getClientOriginalName();
                    // dd($image);
                    $destinationPath = public_path("images/products/$prodId/");
                    $middle = $destinationPath . "middle/";
                    $big = $destinationPath . "big/";

                    if (!file_exists($middle)) {
                        mkdir($middle, 0755, true);
                    }
                    if (!file_exists($big)) {
                        mkdir($big, 0755, true);
                    }

                    // dd($destinationPath);
                    // $image->store($destinationPath.$name);

                    $img = ImageLib::make($image->path());
                    // dd($middle);
                    $img->resize(700, null, function ($const) {
                        $const->aspectRatio();
                    })->save($big.$name);

                    $img->resize(300, null, function ($const) {
                        $const->aspectRatio();
                    })->save($middle.$name);
                    
            
                    // return back()->with('success','Image Upload successfully');
                }//---Image creation


                foreach($imagesInfo as $index => $imageInfo){
                    $item = [
                        'alias'       =>  $imageInfo,
                        'product_id'  =>  $prodId,
                        'status'      =>  (int) 1,
                        'title'       =>  $imgAlt . $index,
                        'alt'         =>  $imgAlt . $index,
                        'is_first'    =>  (int) $index == 0 ? 1 : 0,
                        'order-num'   =>  (int) $index,
                    ];
                    $res = $this->imageRepo->createItem($item);
                }

                return redirect()->route('admin-' . $this->idHelper . '-index');
            }
            
        }
        
        return view('admin-part.' . $this->idHelper . '.create', [
            'p_title' => $p_title,
            'idHelper' => $this->idHelper,
            'nameHelper' => $this->nameHelper,
            'categories' => $categories,
            'brands' => $brands,
            'productOwners' => $productOwners,
        ]);
    }

    //update
    public function update($id, Request $request)
    {
        $p_title = "Обновить " . $this->nameHelper;
        $product = $this->productRepo->getItemById($id);
        $old_status = $product->status;
        $categories = $this->categoryRepo->getAllItems();
        $brands = $this->brandRepo->getAllItems();
        $productOwners = $this->productOwnerRepo->getAllItems();

        if ($request->isMethod('post')) {
             $params = [
                'category_id'        =>  (int) $request->input('category_id'),
                'brand_id'       =>  (int) $request->input('brand_id'),
                'owner_id'       =>  (int) $request->input('owner_id'),
                'alias'       =>  $request->input('alias'),
                'price'       =>  (int) $request->input('price'),
                'short_title'       =>  $request->input('short_title'),
                'title'      =>  $request->input('title'),
                'description'      =>  $request->input('description'),
                'tags'      =>  $request->input('tags'),
                'header'      =>  $request->input('header'),
                'content'      =>  $request->input('content'),
                'owner_article'      =>  $request->input('owner_article'),
                'in_stock'      =>  (int) $request->input('in_stock'),
                'product_state'      =>  (int) $request->input('product_state'),
                'my_noties'      =>  $request->input('my_noties'),
                'status'      =>  (int) $request->input('status'),
                // 'created_at'      =>  (int) $request->input('status'),
            ];
            
            $res = $this->productRepo->updateItem($product, $params);
            
            if($res->status == 1 && $old_status == 0){
                $res = $this->productRepo->updateItem($product, ['created_at' => $res->updated_at]);
            }
            
            if($res){//if product saved

                // //---Image creation
                $prodId = $res->id;
                $imgAlt = $request->input('short_title') . " фото-";

                $imagesInfo = $request->input('imagesInfo');//inputs with src
                
                
                $images = $request->file('images');//files
                // dd($images);
                if($request->hasFile('images')){
                        $destinationPath = public_path("images/products/$prodId/");
                        $middle = $destinationPath . "middle/";
                        $big = $destinationPath . "big/";
                        //remove dir
                        static::removeDirectory($destinationPath);
                    foreach($images as $image){
                        //create file
                        $name = $image->getClientOriginalName();
                        // dd($image);
                        

                        if (!file_exists($middle)) {
                            mkdir($middle, 0755, true);
                        }
                        if (!file_exists($big)) {
                            mkdir($big, 0755, true);
                        }

                        $img = ImageLib::make($image->path());
                        // dd($middle);
                        $img->resize(700, null, function ($const) {
                            $const->aspectRatio();
                        })->save($big.$name);

                        $img->resize(300, null, function ($const) {
                            $const->aspectRatio();
                        })->save($middle.$name);
                        
                        
                    }//---Image creation
                }

                //Delete images from db
                $this->imageRepo->deleteItemsByProductId($prodId);
                if($imagesInfo){
                    foreach($imagesInfo as $index => $imageInfo){
                        $item = [
                            'alias'       =>  $imageInfo,
                            'product_id'  =>  $prodId,
                            'status'      =>  (int) 1,
                            'title'       =>  $imgAlt . $index,
                            'alt'         =>  $imgAlt . $index,
                            'is_first'    =>  (int) $index == 0 ? 1 : 0,
                            'order-num'   =>  (int) $index,
                        ];
                        $res = $this->imageRepo->createItem($item);
                    }
                }
                

                return redirect()->route('admin-' . $this->idHelper . '-index');
            }
        }
        
        return view('admin-part.' . $this->idHelper . '.update', [
            'p_title' => $p_title,
            'idHelper' => $this->idHelper,
            'nameHelper' => $this->nameHelper,
            'categories' => $categories,
            'brands' => $brands,
            'productOwners' => $productOwners,
            'product' => $product,
        ]);   
    }


    //delete
    public function delete($id)
    {
        $this->productRepo->deleteItem($id);
        $this->imageRepo->deleteItemsByProductId($id);
        static::removeDirectory(public_path("images/products/$id/"));

        return redirect()->route('admin-' . $this->idHelper . '-index');
    }

    public static function removeDirectory($dir, $options = [])
    {
        if (!is_dir($dir)) {
            return;
        }
        if (!empty($options['traverseSymlinks']) || !is_link($dir)) {
            if (!($handle = opendir($dir))) {
                return;
            }
            while (($file = readdir($handle)) !== false) {
                if ($file === '.' || $file === '..') {
                    continue;
                }
                $path = $dir . DIRECTORY_SEPARATOR . $file;
                if (is_dir($path)) {
                    static::removeDirectory($path, $options);
                } else {
                    static::unlink($path);
                }
            }
            closedir($handle);
        }
        if (is_link($dir)) {
            static::unlink($dir);
        } else {
            rmdir($dir);
        }
    }


    //helpers
    public static function unlink($path)
    {
        $isWindows = DIRECTORY_SEPARATOR === '\\';

        if (!$isWindows) {
            return unlink($path);
        }

        if (is_link($path) && is_dir($path)) {
            return rmdir($path);
        }

        try {
            return unlink($path);
        } catch (ErrorException $e) {
            // last resort measure for Windows
            if (is_dir($path) && count(static::findFiles($path)) !== 0) {
                return false;
            }
            if (function_exists('exec') && file_exists($path)) {
                exec('DEL /F/Q ' . escapeshellarg($path));

                return !file_exists($path);
            }

            return false;
        }
    }
}
