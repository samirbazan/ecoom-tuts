<?php namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests;
use App\Http\Controllers\Controller;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;


class CategoriesController extends Controller {


    public function __construct(){
        parent::__construct();
        $this->beforeFilter('csrf', array('on' => 'post'));
        $this->beforeFilter('admin');
    }
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
        return view('categories.index')
            ->with('categories', Category::all());
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function postCreate()
	{
		$validator = Validator::make(Input::all(), Category::$rules);

        if($validator->passes()){
            $category = new Category;
            $category->name = Input::get('name');
            $category->save();

            return redirect('admin/categories/index')
                ->with('message', 'Category Created');
        }

        return redirect('admin/categories/index')
            ->with('message', 'Something went wrong')
            ->withErrors($validator)
            ->withInput();
	}

    /**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
     * aqui quite el $id de la funcion postDestroy
	 */
	public function postDestroy()
	{
		$category = Category::find(Input::get('id'));

        if($category) {
            $category->delete();
            return redirect('admin/categories/index')
                ->with('message', 'Category Deleted');
        }

        return redirect('admin/categories/index')
            ->with('message', 'Something went Wrong, please try again');
	}

}
