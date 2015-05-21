<?php namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class StoreController extends Controller {

    public function __construct()
    {
        parent::__construct();
        $this->beforeFilter('csrf', array('on'=>'post'));
    }
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		return view('store.index')
            ->with('products', Product::take(4)->orderBy('created_at', 'DESC')->get());
	}

	public function getView($id)
    {
        return view('store.view')->with('product', Product::find($id));
    }

    public function getCategory($cat_id)
    {
        return view('store.category')
            ->with('products', Product::where('category_id', '=', $cat_id)->paginate(6))
            ->with('category', Category::find($cat_id));
    }

    public function getSearch()
    {
        $keyword = Input::get('keyword');

        return view('store.search')
            ->with('products', Product::where('title', 'Like', '%'.$keyword.'%')->get())
            ->with('keyword', $keyword);
    }

}
