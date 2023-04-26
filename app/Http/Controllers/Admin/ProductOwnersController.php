<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\ProductOwnerRepository;
use App\Models\ProductOwner;

class ProductOwnersController extends Controller
{
    public $layout = 'layouts.admin-default';
    public $nameHelper = " Поставщики";
    public $idHelper = "product-owner";
    
    protected $ownerRepo;
 
    public function __construct(
        ProductOwnerRepository $ownerRepo
    )
    {
        $this->ownerRepo = $ownerRepo;
    }

    public function index()
    {
        $p_title = "Все" . $this->nameHelper;
        $items = $this->ownerRepo->getAllItems();

        $items = ProductOwner::paginate(12);

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

        if ($request->isMethod('post')) {

            $params = [
                'name'        =>  $request->input('name'),
                'type'       =>  $request->input('type'),
                'phones'       =>  $request->input('phones'),
                'telegram'       =>  $request->input('telegram'),
                'viber'       =>  $request->input('viber'),
                'noties'       =>  $request->input('noties'),
                'status'      =>  (int) $request->input('status'),
            ];

            if($this->ownerRepo->createItem($params)){
                return redirect()->route('admin-' . $this->idHelper . '-index');
            }
            
        }
        
        return view('admin-part.' . $this->idHelper . '.create', [
            'p_title' => $p_title,
            'idHelper' => $this->idHelper,
            'nameHelper' => $this->nameHelper,
        ]);
    }

    public function update($id, Request $request)
    {
        $p_title = "Обновить" . $this->nameHelper;
        $item = $this->ownerRepo->getItemById($id);

        if ($request->isMethod('post')) {

            $params = [
                'name'        =>  $request->input('name'),
                'type'       =>  $request->input('type'),
                'phones'       =>  $request->input('phones'),
                'telegram'       =>  $request->input('telegram'),
                'viber'       =>  $request->input('viber'),
                'noties'       =>  $request->input('noties'),
                'status'      =>  (int) $request->input('status'),
            ];

            if($this->ownerRepo->updateItem($item, $params)){
                return redirect()->route('admin-' . $this->idHelper . '-index');
            }

        }

        return view('admin-part.' . $this->idHelper . '.update', [
            'p_title' => $p_title,
            'item' => $item,
            'idHelper' => $this->idHelper,
            'nameHelper' => $this->nameHelper,
        ]);
    }

    public function delete($id)
    {
        $this->ownerRepo->deleteItem($id);
        return redirect()->route('admin-' . $this->idHelper . '-index');
    }
}
