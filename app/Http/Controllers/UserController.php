<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\TryCatch;

class UserController extends Controller
{
    public function login(){
        return view('auth.login');
    }

    public function loginInput(Request $request){
        try {
            $data = $request->validate([
                'email' => 'required|exists:users,email',
                'password' => 'required'
            ], [
                'email.exists' => 'This User Doesnt Exists'
            ]);
            

            Auth::attempt($data);
            
            return redirect('/');
        } catch (\Throwable $th) {

            return back()->with('fail', 'Check Your Credential!');
        }
    }
}
