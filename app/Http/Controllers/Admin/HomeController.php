<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public $layout = 'layouts.admin-default';
    
    public function index()
    {
        

        return view('admin-part.home.index', [
            
        ]);
    }
}
