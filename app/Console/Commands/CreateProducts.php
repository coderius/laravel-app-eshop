<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
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
use Illuminate\Support\Str;

class CreateProducts extends Command
{
    const BEZBREND = "bezbrand";
    const AMYBABY = "amybaby";

    protected $productRepo;
    protected $productOwnerRepo;
    protected $imageRepo;
    protected $categoryRepo;
    protected $brandRepo;
    
    /**
     * The name and signature of the console command.
     *
     * php artisan create:products C:\xampp\htdocs\kupitut\app\Console\Commands\amybaby\1673307807-amybabyToSql-0.json amybaby 13 1 7
     * @var string
     */
    protected $signature = 'create:products {fileJson} {ownerType} {category_id} {brand_id} {owner_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
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
        parent::__construct();
    }

    /**
     * Execute the console command.
     * 
     * php artisan create:products gfdg.json amybaby 
     * 
     * 
     * @return int
     */
    public function handle()
    {
        $file = $this->arguments()['fileJson'];
        $ownerType = $this->arguments()['ownerType'];

        // echo $ownerType;

        if($ownerType == self::AMYBABY){
            $array = $this->decodedJson($file);
            // var_dump($array[0]['title']); exit;
            foreach($array as $item){
                $this->saveAmmyToDb($item);
                // var_dump($item['title']);
            }
            
        }

    }

    public function decodedJson($file){
        $json = file_get_contents($file);
        return json_decode($json, true);
    }

    private function saveAmmyToDb($array){
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
            'category_id'        =>  (int) $this->arguments()['category_id'],
            'brand_id'       =>  (int) $this->arguments()['brand_id'],
            'owner_id'       =>  (int) $this->arguments()['owner_id'],
            'alias'       =>  $alias,//
            'price'       =>  ((int) isset($array['price']) ? $array['price'] : 0) + 200,
            'short_title'       =>  $short_title,//
            'title'      =>  $title,//
            'description'      =>  $description,//
            'tags'      =>  "женская одежда",
            'header'      =>  $header,//
            'content'      =>  $array['content'],
            'owner_article'      =>  $array['owner_article'],
            'in_stock'      =>  (int) Product::STOCK_HAVE,
            'product_state'      =>  (int) Product::PRODUCT_STATE_NEW,
            'my_noties'      =>  $array['content'] . "Модель" . $array['owner_article'],
            'status'      =>  (int) Product::STATUS_DESIBLED,
            "created_at" => new \DateTime(),
            "updated_at" => new \DateTime()
        ];

        // var_dump($params['status']);
        // var_dump(mb_strtolower($array['title'])) ;
        // return $params;
        
        $res = $this->productRepo->createItem($params);

    }
}
