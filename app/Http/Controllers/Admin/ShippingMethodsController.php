<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\OrderRepository;
use App\Models\Brand;

class ShippingMethodsController extends Controller
{
    public $layout = 'layouts.admin-default';
    public $name = " Заказы";
    
    protected $orderRepo;
 
    public function __construct(
        OrderRepository $orderRepo
    )
    {
        $this->orderRepo = $orderRepo;

    }

    public function index()
    {
        $p_title = "Все" . $this->name;
        $items = $this->orderRepo->getAllItemsWithPagination(50);

        return view('admin-part.orders.index', [
            'p_title' => $p_title,
            'items' => $items
        ]);
    }

    public function create(Request $request)
    {
        $p_title = "Создать" . $this->name;

        if ($request->isMethod('post')) {

            $params = [
                'name'        =>  $request->input('name'),
                'alias'       =>  $request->input('alias'),
                'title'       =>  $request->input('title'),
                'description' =>  $request->input('description'),
                'status'      =>  $request->input('status'),
            ];

            if($this->brandRepo->createItem($params)){
                return redirect()->route('admin-brand-index');
            }
            
        }
        
        return view('admin-part.brand.create', [
            'p_title' => $p_title
        ]);
    }

    public function update($id, Request $request)
    {
        $p_title = "Обновить" . $this->name;
        $item = $this->brandRepo->getItemById($id);

        if ($request->isMethod('post')) {

            $params = [
                'name'        =>  $request->input('name'),
                'alias'       =>  $request->input('alias'),
                'title'       =>  $request->input('title'),
                'description' =>  $request->input('description'),
                'status'      =>  $request->input('status'),
            ];

            if($this->brandRepo->updateItem($item, $params)){
                return redirect()->route('admin-brand-index');
            }

        }

        return view('admin-part.brand.update', [
            'p_title' => $p_title,
            'item' => $item
        ]);
    }

    public function delete($id)
    {
        $this->brandRepo->deleteItem($id);
        return redirect()->route('admin-brand-index');
    }
}
