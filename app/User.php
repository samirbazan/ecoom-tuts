<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Auth;


class User extends Model implements AuthenticatableContract {
    use Authenticatable;

	protected $table = 'users';

    protected $hidden = array('password', 'remember_token');

    protected $fillable = array('firstname', 'lastname', 'email', 'telephone');

    public static $rules = array(
        'firstname'             => 'required|min:2|alpha',
        'lastname'              => 'required|min:2|alpha',
        'email'                 => 'required|email|unique:users',
        'password'              => 'required|alpha_num|between:8,12|confirmed',
        'password_confirmation' => 'required|alpha_num|between:8,12',
        'telephone'             => 'required|between:10,12',
        'admin'                 => 'integer',
    );



    public function getAuthIdentifier()
    {
        return $this->getKey();
    }
}
