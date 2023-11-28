<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ApiModel;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use http\Message;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use function Laravel\Prompts\error;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request){
        $credentials=[
            'email'=>$request['email'],
            'password'=>$request['password']
        ];
        $response=Http::post(env('API_URL').'/login',$credentials);
        $token=json_decode($response->body())->success->token ?? null;
        if(!$token){
            return to_route('login');
        }
        else{
            Session::put('apitoken',$token);
            $user=new User($credentials);
            Auth::setUser($user);
            return to_route('home');
        }
    }
}
