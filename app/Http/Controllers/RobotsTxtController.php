<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RobotsTxtController extends Controller
{
    
    public function index() {

        $manager = [
            'Sitemap: '.route('sitemap', []),
            'User-agent: *',
            'Disallow: /making-checkout/*',
            'Disallow: /login*',
            'Disallow: /register',
            'Disallow: /wishlist',
        ];
        $robots = implode(PHP_EOL, $manager);
        
        // output the entire robots.txt
        return response($robots, 200)
            ->header('Content-Type', 'text/plain; charset=UTF-8');
    }
  
}
