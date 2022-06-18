<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller {
    public function showLogin() {
        return view( 'admin.login' );
    }

    public function postLogin( Request $request ) {
        $validator = Validator::make( $request->all(), array(
            'email'    => 'required',
            'password' => 'required',
        ), array(
            'email.required'    => 'Email field is required.',
            'password.required' => 'Password field is required.',
        ) );

        if ( $validator->fails() ) {
            return back()
                ->withErrors( $validator )
                ->withInput();
        }

        if ( !Auth::attempt( $request->only( 'email', 'password' ) ) ) {
            return redirect()->back()->with( 'error', 'Oops Something Wrong!' );
        } else {
            return to_route( 'dashboard' )->with( 'success', 'Welcome to login as Admin.' );
        }

    }

    public function logout() {
        Auth::logout();
        return redirect( url( 'admin/login-23032001' ) );
    }

    public function error() {
        return view( 'admin.error404' );
    }

}
