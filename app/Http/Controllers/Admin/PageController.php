<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductOrder;
use App\Models\User;
use Illuminate\Http\Request;

class PageController extends Controller {
    public function home( Request $request ) {
        $totalOrder = ProductOrder::count();
        $totalProduct = Product::count();
        $totalUser = User::where( 'role', 'user' )->count();

        $today = date( 'Y-m-d' );
        $latestOrder = ProductOrder::with( 'user', 'product' )
            ->whereDate( 'created_at', $today );

        if ( $request->search ) {
            $search = $request->search;
            $latestOrder->where( function ( $q ) use ( $search ) {
                $q->orWhereHas( 'user', function ( $q1 ) use ( $search ) {
                    $q1->where( 'name', 'like', '%' . $search . '%' );
                } )->orWhereHas( 'product', function ( $q1 ) use ( $search ) {
                    $q1->where( 'name', 'like', '%' . $search . '%' );
                } )->orWhere( 'status', 'like', '%' . $search . '%' );
            } );
        }

        $latestOrder = $latestOrder->orderBy( 'id', 'desc' )->paginate( 10 );

        $chartData = array();

        for ( $i = 1; $i <= 12; $i++ ) {
            $chartData[] = ProductOrder::whereMonth( 'created_at', $i )
                ->whereYear( 'created_at', now()->format( 'Y' ) )
                ->count();
        }

        return view( 'admin.home', compact( 'latestOrder', 'totalOrder', 'totalProduct', 'totalUser', 'chartData' ) );
    }

}
