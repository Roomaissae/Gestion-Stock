<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\UserVerify;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function index()
    {
        return view('auth.login');
    }  

    /**
     * Show registration form
     */
    public function registration()
    {
        return view('auth.registration');
    }

    /**
     * Handle login request
     */
    public function postLogin(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard')
                ->withSuccess('You have successfully logged in.');
        }

        return redirect("login")->withErrors('Oops! Invalid credentials.');
    }

    /**
     * Handle registration request
     */
    public function postRegistration(Request $request)
    {  
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $this->create($request->all());

        return redirect("dashboard")->withSuccess('Great! You have successfully registered and logged in.');
    }

    /**
     * Show dashboard if user is authenticated
     */
    public function dashboard()
    {
        if (Auth::check()) {
            return view('dashboard');
        }

        return redirect("login")->withErrors('Oops! You do not have access.');
    }

    /**
     * Create new user
     */
    public function create(array $data)
    {
        return User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * Logout user and flush session
     */
    public function logout()
    {
        Session::flush();
        Auth::logout();

        return redirect('login');
    }
    
}
