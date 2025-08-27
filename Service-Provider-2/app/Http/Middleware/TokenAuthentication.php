<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class TokenAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // temp stop
        return $next($request);

        $authenticated = cache("authenticated");
        if ($authenticated) {
            $token = cache("token");
            $response = Http::accept('application/json')
            ->post(config('app.sso_server_get_user_data_url'),[
                "token" => $token
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $user = null;
                if(User::where('user_id',$data['id'])->exists()){
                    $user = User::where('user_id',$data['id'])->first();
                } else {
                    $user = User::create([
                        'user_id'=> $data['id'],
                        'name'=> $data['name'],
                        'email'=> $data['email'],
                        'password'=> bcrypt('password'),
                    ]);
                }
                $oneMonth = 60 * 24 * 30;
                $cookieOptions = [
                    'minutes' => $oneMonth,
                    'path' => '/',
                    'domain' => null,
                    'secure' => true,       
                    'httponly' => true,     
                    'samesite' => 'lax'     
                ];
                auth()->setUser($user);
                Cookie::queue(Cookie::make('authenticated', true, ...array_values($cookieOptions)));
                Cookie::queue(Cookie::make('token', $token, ...array_values($cookieOptions)));
                Cookie::queue(Cookie::make('user_local_id', $user->id, ...array_values($cookieOptions)));
                Cookie::queue(Cookie::make('user_remote_id', $user->user_id, ...array_values($cookieOptions)));
                return $next($request);
            } else {
                Cookie::queue(Cookie::forget('authenticated'));
                Cookie::queue(Cookie::forget('token'));
                Cookie::queue(Cookie::forget('user_local_id'));
                Cookie::queue(Cookie::forget('user_remote_id'));
            }
        }
        return $next($request);
    }
}
