<?php
namespace App\Http\Controllers; 
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    //login
    public function login()
    {
        return view("auth.login");
    }

    public function loginPost(Request $request)
    {
        $request->validate([
            "email"=>"required",
            "password"=>"required",
        ]);

        $credentials = $request->only("email", "password");

        $remember = $request->has('remember');

        if(Auth::attempt($credentials, $request)){
            return redirect()->intended(route("home"));
        }
        else{
            return redirect(route("login"))
            ->with("error", "Failed to login");
        }
    }

    //register
    public function register()
    {
        return view("auth.register");
    }

    public function registerPost(Request $request)
    {
        $request->validate([
            "name"=>"required",
            "email"=>"required|unique:users,email",
            "password"=>"required",
        ],
        [
            "email.required" => "Email is required",
            "email.unique" => "Email has been used"
        ]
        );     

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        if($user->save()){
            return redirect(route("login"))
            ->with("success", "Account created successfully");
        }
        return redirect(route("register"))
        ->with("error", "Failed to create account");
    }

    //logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        return redirect(route("login"));
    }
}