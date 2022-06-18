<?php

namespace App\Http\Middleware;

use App\Models\Product;
use Closure;
use Illuminate\Http\Request;

class PublishStatusCheck {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle( Request $request, Closure $next ) {
        $product = Product::get();

        foreach ( $product as $p ) {

            if ( $p->qty <= 0 ) {
                $p->update( array(
                    'publish_status' => 'no',
                ) );
            } else {
                $p->update( array(
                    'publish_status' => 'yes',
                ) );
            }

        }

        return $next( $request );
    }

}
