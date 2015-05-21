<?php namespace App\Http\Controllers;


use App\Category;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;


class ProductsController extends Controller {


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
        $categories = array();

        foreach (Category::all() as $category) {
            $categories[$category->id] = $category->name;
        }

        return view('products.index')
            ->with('products', Product::all())
            ->with('categories', $categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function postCreate()
    {
        $validator = Validator::make(Input::all(), Product::$rules);

        if($validator->passes()){
            $product = new Product;
            $product->category_id = Input::get('category_id');
            $product->title = Input::get('title');
            $product->description = Input::get('description');
            $product->price = Input::get('price');
            //proccess image first redimension image before save in server
            //we create the variable with file
            $image = Input::file('image');
            //new variable with the name
            $filename = date('Y-m-d-H:i:s')."-".$image->getClientOriginalName();
            //now call to method image for resize the image and save it
            Image::make($image->getRealPath())->resize(468, 249)->save('img/products/'.$filename);
            //save the route in database
            $product->image = 'img/products/'.$filename;
            //we save all
            $product->save();

            return redirect('admin/products/index')
                ->with('message', 'Product Created');
        }

        return redirect('admin/products/index')
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
        $product = Product::find(Input::get('id'));

        if($product) {
            File::delete('public/'.$product->image);
            $product->delete();
            return redirect('admin/products/index')
                ->with('message', 'Product Deleted');
        }

        return redirect('admin/products/index')
            ->with('message', 'Something went Wrong, please try again');
    }

    public function postToggleAvailability(){
        $product = Product::find(Input::get('id'));

        if($product) {
            $product->availability = Input::get('availability');
            $product->save();
            return redirect('admin/products/index')->with('message', 'Product Updated');
        }

        return redirect('admin/products/index')->with('message', 'invalid Product');
    }

}
