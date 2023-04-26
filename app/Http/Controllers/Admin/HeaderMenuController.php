<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\HeaderMenuRepository;
use App\Models\HeaderMenu;

class HeaderMenuController extends Controller
{
    public $layout = 'layouts.admin-default';
    public $nameHelper = " Меню в хедере";
    public $idHelper = "header-menu";
    
    protected $headerMenuRepo;
 
    public function __construct(
        HeaderMenuRepository $headerMenuRepo
    )
    {
        $this->headerMenuRepo = $headerMenuRepo;
    }

    public function index()
    {
        $p_title = "Все" . $this->nameHelper;
        $items = $this->headerMenuRepo->getAllItems();

        $items = HeaderMenu::paginate(12);

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
                'text'        =>  $request->input('text'),
                'url'       =>  $request->input('url'),
                'status'      =>  (int) $request->input('status'),
            ];

            if($this->headerMenuRepo->createItem($params)){
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
        $item = $this->headerMenuRepo->getItemById($id);

        if ($request->isMethod('post')) {

            $params = [
                'text'        =>  $request->input('text'),
                'url'       =>  $request->input('url'),
                'status'      =>  $request->input('status'),
            ];

            if($this->headerMenuRepo->updateItem($item, $params)){
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
        $this->headerMenuRepo->deleteItem($id);
        return redirect()->route('admin-' . $this->idHelper . '-index');
    }
}
