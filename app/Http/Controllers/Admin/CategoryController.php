<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CategoryRepository;
use App\Models\Category;

class CategoryController extends Controller
{
    public $layout = 'layouts.admin-default';
    public $name = " Категории";

    protected $categoryRepo;
 
    public function __construct(
        CategoryRepository $categoryRepo
    )
    {
        $this->categoryRepo = $categoryRepo;

    }

    public function index()
    {
        $p_title = "Все" . $this->name;
        $items = $this->categoryRepo->getAllItems();

        $items = Category::paginate(12);

        return view('admin-part.category.index', [
            'p_title' => $p_title,
            'items' => $items
        ]);
    }

    public function create(Request $request)
    {
        $p_title = "Создать" . $this->name;
        $categories = $this->categoryRepo->getAllItems(1);

        if ($request->isMethod('post')) {

            $params = [
                'name'        =>  $request->input('name'),
                'alias'       =>  $request->input('alias'),
                'parent_id'   =>  $request->input('parent_id'),
                'title'       =>  $request->input('title'),
                'description' =>  $request->input('description'),
                'src' =>  $request->input('src'),
                'status'      =>  $request->input('status'),
            ];

            if($this->categoryRepo->createItem($params)){
                return redirect()->route('admin-category-index');
            }
            
        }
        
        return view('admin-part.category.create', [
            'p_title' => $p_title,
            'categories' => $categories
        ]);
    }

    public function update($id, Request $request)
    {
        $p_title = "Обновить" . $this->name;
        $cat = $this->categoryRepo->getItemById($id);
        $categories = $this->categoryRepo->getAllItems(1);

        if ($request->isMethod('post')) {

            $params = [
                'name'        =>  $request->input('name'),
                'alias'       =>  $request->input('alias'),
                'parent_id'   =>  (int) $request->input('parent_id'),
                'title'       =>  $request->input('title'),
                'description' =>  $request->input('description'),
                'src' =>  $request->input('src'),
                'status'      =>  (int) $request->input('status'),
            ];

            if($this->categoryRepo->updateItem($cat, $params)){
                return redirect()->route('admin-category-index');
            }

        }

        return view('admin-part.category.update', [
            'p_title' => $p_title,
            'cat' => $cat,
            'categories' => $categories
        ]);
    }

    public function delete($id)
    {
        $this->categoryRepo->deleteItem($id);
        return redirect()->route('admin-category-index');
    }

}
