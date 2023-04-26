<?php
 
namespace App\Http\View\Composers;
 
use App\Interfaces\HeaderMenuRepositoryInterface;
use App\Interfaces\FooterMenuRepositoryInterface;
use Illuminate\View\View;
 
class HeaderComposer
{
    protected $hr;
    protected $fr;
 
    public function __construct(HeaderMenuRepositoryInterface $hr, FooterMenuRepositoryInterface $fr)
    {
        $this->hr = $hr;
        $this->fr = $fr;
    }
 
    public function compose(View $view)
    {
        $view->with('items', $this->hr->getAllItems());
        $view->with('fItems', $this->fr->getAllItems());
    }
}