<?php

namespace App\Http\Middleware;

use App\Models\ProductCart;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class CartCount {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle( Request $request, Closure $next ) {

        if ( Auth::check() ) {
            $cartCount = ProductCart::where( 'user_id', Auth::user()->id )->count();
        } else {
            $cartCount = "login";
        }

        View::share( 'cartCount', $cartCount );
        return $next( $request );
    }

}
