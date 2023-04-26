<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\FooterMenuRepository;
use App\Models\FooterMenu;

class FooterMenuController extends Controller
{
    public $layout = 'layouts.admin-default';
    public $nameHelper = " Меню в футере";
    public $idHelper = "footer-menu";
    
    protected $footerMenuRepo;
 
    public function __construct(
        FooterMenuRepository $footerMenuRepo
    )
    {
        $this->footerMenuRepo = $footerMenuRepo;
    }

    public function index()
    {
        $p_title = "Все" . $this->nameHelper;
        $items = $this->footerMenuRepo->getAllItems();

        $items = FooterMenu::paginate(12);

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
                'type'       =>  (int) $request->input('type'),
                'status'      =>  (int) $request->input('status'),
            ];

            if($this->footerMenuRepo->createItem($params)){
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
        $item = $this->footerMenuRepo->getItemById($id);

        if ($request->isMethod('post')) {

            $params = [
                'text'        =>  $request->input('text'),
                'url'       =>  $request->input('url'),
                'type'       =>  $request->input('type'),
                'status'      =>  $request->input('status'),
            ];

            if($this->footerMenuRepo->updateItem($item, $params)){
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
        $this->footerMenuRepo->deleteItem($id);
        return redirect()->route('admin-' . $this->idHelper . '-index');
    }
}
