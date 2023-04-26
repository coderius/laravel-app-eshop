<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\ContactRepository;
use App\Models\Contact;

class ContactsController extends Controller
{
    public $layout = 'layouts.admin-default';
    public $nameHelper = " Контакты";
    public $idHelper = "contacts";
    
    protected $contactsRepo;
 
    public function __construct(
        ContactRepository $contactsRepo
    )
    {
        $this->contactsRepo = $contactsRepo;
    }

    public function index()
    {
        $p_title = "Все" . $this->nameHelper;
        $items = $this->contactsRepo->getAllItems();

        $items = Contact::paginate(12);

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
                'link'       =>  $request->input('link'),
                'type'       =>  (int) $request->input('type'),
                'status'      =>  (int) $request->input('status'),
            ];

            if($this->contactsRepo->createItem($params)){
                return redirect()->route('admin-' . $this->idHelper . '-index');
            }
            
        }
        
        return view('admin-part.contacts.create', [
            'p_title' => $p_title,
            'idHelper' => $this->idHelper,
            'nameHelper' => $this->nameHelper,
        ]);
    }

    public function update($id, Request $request)
    {
        $p_title = "Обновить" . $this->nameHelper;
        $item = $this->contactsRepo->getItemById($id);

        if ($request->isMethod('post')) {

            $params = [
                'text'        =>  $request->input('text'),
                'link'       =>  $request->input('link'),
                'type'       =>  $request->input('type'),
                'status'      =>  $request->input('status'),
            ];

            if($this->contactsRepo->updateItem($item, $params)){
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
        $this->contactsRepo->deleteItem($id);
        return redirect()->route('admin-' . $this->idHelper . '-index');
    }
}
