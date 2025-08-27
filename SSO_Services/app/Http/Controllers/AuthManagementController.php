<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\DTO\UserLoginDTO;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Services\AuthManagementService;

class AuthManagementController extends Controller
{
    private $authManagementService;
    public string $checkTokenUrl;
    public function __construct(AuthManagementService $authManagementService){
        $this->authManagementService = $authManagementService;
        $this->checkTokenUrl = config('app.auth_server_url') . "/api/user";
    }
    public function show_login(Request $request){
        return view('login');
    }
    public function login(LoginRequest $request){
        $next = $request->query('next');
        $dto = UserLoginDTO::fromRequest($request);
        $tokenArray = $this->authManagementService->getToken($dto);
        if($tokenArray['success']){
            $user = User::where('email', $tokenArray["responseData"]["email"])->first();
            Auth::login($user);
            if($next){
                return redirect($next);
            }
            return redirect()->route('dashboard');
        }
        return redirect()->back()->withInput()->withErrors(['login'=> 'Invalid Credential']);
    }
    public function checkAuth(){
        if(auth()->check()){
            $authenticate = true;
            $token = auth()->user()?->token?->token;
            return ["authenticated" => $authenticate, "token" => $token];
        }
        return ["authenticated" => false, "token" => null];
    }
    public function get_user_data(Request $request){
        $request->validate([
            "token" => "required",
        ]);
        $token = $request->token;
        logger($token);
        $response = Http::withToken($token)->accept('application/json')
        ->get($this->checkTokenUrl);
        return $response->json();
    }
    public function logout(Request $request){
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
    public function token_logout(Request $request){
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->back();
    }
}
