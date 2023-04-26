<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\ProductOwnerRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\FileProductRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ImageRepository;
use App\Models\ProductOwner;
use App\Models\ExportProduct;
use App\Models\Image;
use App\Repositories\BrandRepository;
use Illuminate\Support\Str;
use ImageLib;
use File;
use Session;

class ExportFileProduct extends Controller
{
    const BEZBREND = "bezbrand";
    const AMYBABY = 7;//in db
    public $idHelper;
    public $nameHelper = " Продукты из файла";

    protected $fileProductRepo;
    protected $productRepo;
    protected $productOwnerRepo;
    protected $imageRepo;
    protected $categoryRepo;
    protected $brandRepo;

    public function __construct(
        ProductOwnerRepository $productOwnerRepo,
        FileProductRepository $fileProductRepo,
        ProductRepository $productRepo,
        ImageRepository $imageRepo,
        CategoryRepository $categoryRepo,
        BrandRepository $brandRepo
    )
    {
        $this->productOwnerRepo = $productOwnerRepo;
        $this->fileProductRepo = $fileProductRepo;
        $this->productRepo = $productRepo;
        $this->imageRepo = $imageRepo;
        $this->categoryRepo = $categoryRepo;
        $this->brandRepo = $brandRepo;
        $this->idHelper = "export-file-product";
    }

    public function index()
    {
        $p_title = "Все" . $this->nameHelper;
        $items = ExportProduct::orderBy('created_at', 'DESC')->paginate(40);
        

        return view('admin-part.' . $this->idHelper . '.index', [
            'p_title' => $p_title,
            'items' => $items,
            'idHelper' => $this->idHelper,
            'nameHelper' => $this->nameHelper
        ]);
    }

    public function create(Request $request)
    {
        $p_title = "Создать" . $this->nameHelper;
        $categories = $this->categoryRepo->getAllItems();
        $brands = $this->brandRepo->getAllItems();
        $productOwners = $this->productOwnerRepo->getAllItems();

        if ($request->isMethod('post')) {
            $files = $request->file('json');
            // dd($this->decodedJson($file->path()));
            // $res = false;
            if($request->input('owner_id') == self::AMYBABY){
                foreach($files as $file){
                    $array = $this->decodedJson($file->path());
                    foreach($array as $item){
                        $res = $this->saveAmmyToDb($item, $request);
                    }
                }
            }else{
                exit("owner_id: " . $request->input('owner_id') . " не соответствует типу AMYBABY: " . self::AMYBABY);
            }
            // if((bool) $res){
                return redirect()->route('admin-' . $this->idHelper . '-index');
            // }
            
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
            $product = $this->fileProductRepo->getItemById($id);
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
                ];
    
                $res = $this->fileProductRepo->updateItem($product, $params);
    
                
                if($res){//if product saved
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
            $this->fileProductRepo->deleteItem($id);
            return redirect()->route('admin-' . $this->idHelper . '-index');
        }

        //------------------------------------------------------
        // <option value="1" >Разместить в продуктах</option>
        // <option value="2" >Удалить</option>
        // <option value="3" >Сделать статус desibled</option>
        // <option value="4" >Сделать статус enabled</option>
        const CHEX_EXPORT = 1;
        const CHEX_DEL = 2;
        const CHEX_STAT_DES = 3;
        const CHEX_STAT_ENABL = 4;

        public function checkboxAction(Request $request)
        {
            if ($request->isMethod('post')) {
                $ids = $request->input('ids');
                $act = $request->input('checkbox-select');
                if($act == static::CHEX_EXPORT){
                    $idMes = "";
                    $ownMes = "";
                    foreach($ids as $id){
                        $ex = $this->fileProductRepo->getItemById($id);
                        $params = [
                            'category_id'   =>  $ex->category_id,
                            'brand_id'      =>  $ex->brand_id,
                            'owner_id'      =>  $ex->owner_id,
                            'alias'         =>  $ex->alias,
                            'price'         =>  $ex->price,
                            'short_title'   =>  $ex->short_title,
                            'title'         =>  $ex->title,
                            'description'   =>  $ex->description,
                            'tags'          =>  $ex->tags,
                            'header'        =>  $ex->header,
                            'content'       =>  $ex->content,
                            'owner_article' =>  $ex->owner_article,
                            'in_stock'      =>  $ex->in_stock,
                            'product_state' =>  $ex->product_state,
                            'my_noties'     =>  $ex->my_noties,
                            'status'        =>  $ex->status,
                        ];
                        if($this->productRepo->hasOwnerArt($ex->owner_id, $ex->owner_article) == false){
                            $this->productRepo->createItem($params);
                            $this->fileProductRepo->deleteItem($id);
                        }else{
                            $idMes .= "$id, ";
                            $ownMes .= "$ex->owner_article, ";
                        }
                    }
                    if($idMes != ""){
                        // session(['message' => "Материалы ( id: $idMes ) с таким ( owner_article: $ownMes ) уже есть в основаной таблице"]);
                        $this->setMessage("Материалы ( id: $idMes ) с таким ( owner_article: $ownMes ) уже есть в основаной таблице");
                    }
                    // else{
                    //     session(['message' => ""]);
                    // }
                    
                }
                if($act == static::CHEX_DEL){
                    foreach($ids as $id){
                        $this->fileProductRepo->deleteItem($id);
                    }
                }
                if($act == static::CHEX_STAT_DES){
                    foreach($ids as $id){
                        $product = $this->fileProductRepo->getItemById($id);
                        $params = [
                            'status'=> ExportProduct::STATUS_DESIBLED,
                        ];
                        $this->fileProductRepo->updateItem($product, $params);
                    }
                }
                if($act == static::CHEX_STAT_ENABL){
                    foreach($ids as $id){
                        $product = $this->fileProductRepo->getItemById($id);
                        $params = [
                            'status'=> ExportProduct::STATUS_ACTIVE,
                        ];
                        $this->fileProductRepo->updateItem($product, $params);
                    }
                }
                // dd($request->input('ids'));
                // dd($request->input('checkbox-select'));
            }
            return redirect()->route('admin-' . $this->idHelper . '-index');
        }




    //---------------------------
    //HELPERS
    //---------------------------
    public function decodedJson($file){
        $json = file_get_contents($file);
        return json_decode($json, true);
    }

    private function saveAmmyToDb($array, Request $request){
        $short_title = $array['title'];
        $short_title .= (isset($array['colors'])) ? " " . $array['colors'] : "";
        $short_title .= (isset($array['material'])) ? " " . $array['material'] : "";

        $alias = Str::slug($short_title, '-');

        $title = "Купить " . mb_strtolower($array['title']);
        $title .= (isset($array['colors'])) ? " цвета " . $array['colors'] : "";
        $title .= (isset($array['material'])) ? " " . $array['material'] : "";
        $title .= " недорого";

        $header = $short_title;

        $description = "Модная женская одежда " . mb_strtolower($array['title']);
        $description .= (isset($array['colors'])) ? ",цвета " . $array['colors'] : "";
        $description .= (isset($array['material'])) ? ",материал " . $array['material'] : "";
        $description .= (isset($array['sizes'])) ? ",размер " . $array['sizes'] : "";
        $description .= " выгодная цена. Купить с доставкой в интернет магазине";


        $params = [
            'alias'          =>  $alias,//
            'price'          =>  ((int) isset($array['price']) ? $array['price'] : 0) + 200,
            'short_title'    =>  $short_title,//
            'title'          =>  $title,//
            'description'    =>  $description,//
            'tags'           =>  $array['title'],
            'header'         =>  $header,//
            'content'        =>  $array['content'],
            'owner_article'  =>  $array['owner_article'],
            'my_noties'      =>  $array['content'] . "Модель" . $array['owner_article'],
            'category_id'    =>  (int) $request->input('category_id'),
            'brand_id'       =>  (int) $request->input('brand_id'),
            'owner_id'       =>  (int) $request->input('owner_id'),
            'in_stock'       =>  (int) $request->input('in_stock'),
            'product_state'  =>  (int) $request->input('product_state'),
            'status'         =>  (int) $request->input('status'),
            
        ];

        $hasArt = $this->fileProductRepo->hasArticle($array['owner_article']);
        $hasAlias = $this->fileProductRepo->hasAlias($alias);
        if($hasArt){
            // exit($array['owner_article'] . " can not by created, because this item exists in db");
            $this->setMessage($array['owner_article'] . " can not by created, because this item exists in db");
            return false;
        }else{
            if($hasAlias){
                $new_alias = $alias. "-cena-super-". mt_rand(1, 9);
                $this->setMessage("alias $alias уже есть в базе данных, поэтому я сохраню его как $new_alias");
                $params['alias'] = $new_alias;
            }
            $res = $this->fileProductRepo->createItem($params);
        }
        

        return $res;
    }

    protected function setMessage($message){
        // if(session(['message'])){
        //     session(['message', $message]);
        //     dd($message);
        // }else{

            // $s = session('message');
            // session(['alert', $message]);
            Session::flash("alert", $message);
            // dd(session(['message']));
        // }
    }

}
