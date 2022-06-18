<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller {
    public function showLogin() {
        return view( 'user.login' );
    }

    public function postLogin( Request $request ) {
        $validator = Validator::make( $request->all(), array(
            'email'    => 'required|email',
            'password' => 'required',
        ), array(
            'email.required'    => 'Email field is required',
            'password.required' => 'Password field is required',
        ) );

        if ( $validator->fails() ) {
            return back()
                ->withErrors( $validator )
                ->withInput();
        }

        $user = User::where( 'email', $request->email )->first();

        if ( !$user ) {
            return redirect()->back()->with( 'error', 'Oops email is wrong!' );
        }

        if ( !Auth::attempt( $request->only( 'email', 'password' ) ) ) {
            return redirect()->back()->with( 'error', 'Oops password is wrong!' );
        } else {
            return to_route( 'home' )->with( 'success', 'Welcome back ' . $user->name );
        }

    }

    public function showRegister() {
        return view( 'user.register' );
    }

    public function postRegister( Request $request ) {
        $validator = Validator::make( $request->all(), array(
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required',
        ), array(
            'name.required'     => 'Username field is required.',
            'email.required'    => 'Email field is required.',
            'email.unique'      => 'This email is already exists.',
            'password.required' => 'Password field is required.',
        ) );

        if ( $validator->fails() ) {
            return back()
                ->withErrors( $validator )
                ->withInput();
        }

        if ( isset( $request->image ) ) {
            $file = $request->file( 'image' );
            $fileName = uniqid() . $file->getClientOriginalName();
            Storage::disk( 'image' )->put( $fileName, file_get_contents( $file ) );
        } else {
            $fileName = null;
        }

        $user = User::create( array(
            'name'     => $request->name,
            'email'    => $request->email,
            'image'    => $fileName,
            'password' => Hash::make( $request->password ),
            'role'     => 'user',
        ) );
        auth()->login( $user );
        return to_route( 'home' )->with( 'success', 'Welcome ' . $user->name );
    }

    public function logout() {
        auth()->logout();
        return to_route( 'home' )->with( 'success', 'Logout success' );
    }

}
