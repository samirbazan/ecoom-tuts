<?php namespace App\Http\Controllers;

use App\Category;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\View;

abstract class Controller extends BaseController {
    //if not work here need to move to BaseController
    public function __construct()
    {
        $this->beforeFilter(function(){
           View::share('catnav', Category::all());
        });
    }
	use DispatchesCommands, ValidatesRequests;

}
