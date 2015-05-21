<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller {


    public function __construct()
    {
        parent::__construct();
        $this->beforeFilter('csrf', array('on'=>'post'));
    }

    public function getNewaccount()
    {
        return view('users.newaccount');
    }
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function postCreate()
	{
		$validator =  Validator::make(Input::all(), User::$rules);

        if($validator->passes()){
            $user = New User;
            $user->firstname = Input::get('firstname');
            $user->lastname = Input::get('lastname');
            $user->email = Input::get('email');
            $user->password = bcrypt(Input::get('password'));
            $user->telephone = Input::get('telephone');
            $user->save();

            return redirect('users/signin')
                ->with('message', 'Thank you for create a new account, please sign in');
        }

        return redirect('users/newaccount')
            ->with('mmesage', 'Something went wrong')
            ->withErrors($validator)
            ->withInput();
	}

    public function getSignin()
    {
        return view('users.signin');
    }

    public function postSignin()
    {
        if(\Auth::attempt(array('email'=>Input::get('email'), 'password'=>Input::get('password'))))
        {
            return redirect('/')->with('message', 'Thanks for Sign In');
        }

        return redirect('users/signin')->withErrors('message', 'Your Email/Password combo was incorrect');
    }

    public function getSignout()
    {
        Auth::logout();
        return redirect('users/signin')->with('message', 'You have been signed out');
    }
}
