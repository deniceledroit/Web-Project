<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\ApiModel;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

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

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // Override the showLoginForm() coming from trait AuthenticateUsers
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Override the login() coming from trait AuthenticateUsers
    public function login(Request $request)
    {
        // Being sure we've got valid credentials
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        // Call the API REST /login route for authentication
        $response = ApiModel::post('login', [
            'email' => $credentials['email'],
            'password' => $credentials['password']
        ]);

        // Get the token if success
        if (isset($response->success->token)) {
            $token = $response->success->token;
            // Keep the token in the session
            Session::put('api_token', $token);
            $request->session()->put('api_token', $token);

            // Call the user
            $response = ApiModel::getWithToken('user');
            //dd($response);
            if (isset($response->id)) {
                $user = new User(['id' => $response->id, 'name' => $response->name, 'email' => $response->email, 'role_id'=>$response->role_id]);
                Auth::setUser($user);
                return to_route('home');
            }
        }

        return throw ValidationException::withMessages(['email'=> [trans('auth.failed')]]);
        //return redirect('login');
    }

    // Override the logout() coming from trait AuthenticateUsers
    public function logout(Request $request)
    {
        // Disconnect from the API
        // TODO

        // Disconnect from the APPLICATION
        Session::forget('api_token');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }
}
