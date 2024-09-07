<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ApiRestCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Call the user
        $response = Http::withToken($request->session()->get('api_token'))->get(config('api.url').'/user');
        $response=json_decode($response->body());
        if(isset($response->id)) {
            $user = new User(['id' => $response->id, 'name' => $response->name, 'email' => $response->email]);
            Auth::setUser($user);
            return $next($request);
        }
        return redirect('login');
    }
}
