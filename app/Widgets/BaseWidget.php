<?php

namespace App\Widgets;


// App\Widgets\BaseWidget
abstract class BaseWidget
{
    
    protected $view;

    public function __construct($params = [])
    {
        $this->setParams($params);
        $this->init();
        $this->run();
    }

    protected function init(){}

    abstract protected function run();

    protected function setParams($params){
        foreach($params as $param => $value){
            $this->$param = $value;
        }
    }


    
    
}    