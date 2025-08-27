<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Facades\SharedEncrypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class TokenController extends Controller
{
    public function check_and_cache_token(string $token){
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
                    'user_id' => $data['id'],
                    'email' => $data['email'],
                    'user_data' => json_encode($data),
                ]);
            }
            auth()->login($user); 
            return true;
        } else {
            return false;
        }
    }
    public function identify(Request $request){
        $token = SharedEncrypt::decrypt($request->get("token"));
        $response = Http::withToken($token)
                ->accept('application/json')
                ->get(config('app.auth_server_get_user_data_url'));
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
            auth()->login($user);
            return redirect(route('home'));
        } else {
            logger()->error('Token Invalid');
        }
    }
    public function check_token(Request $request){
        $request->validate([
            'token' => "required" 
        ]);
        $token = $request->token;
        if($this->check_and_cache_token($token)){
            return ["status" => "success", "message" => "Token Verification Successful"];
        }
        return ["status" => "error", "message" => "Error! Something Went Wrong"];
    }
    public function logout_by_frontend(Request $request){
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return ["status" => "success", "message" => "Logout Successful"];
    }
}
