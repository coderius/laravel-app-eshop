<?php
namespace App\Widgets\Frontend;

use App\Widgets\BaseWidget;

// \App\Widgets\Frontend\AdminPanel
class AdminPanel extends BaseWidget
{
    public $title;
    
    protected function init(){
        if($this->title === null){
            $this->title = 44444444;
        }
    }

    public function run(){

        echo view('widgets.frontend.admin-panel.index', [
            'title'=> $this->title,
        ]);
    }
    
    
}  