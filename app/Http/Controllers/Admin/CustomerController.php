<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller {
    public function customerList() {
        $customer = User::withCount( 'order' )
            ->where( 'role', 'user' )
            ->latest()
            ->paginate( 10 );
        return view( 'admin.customer.index', compact( 'customer' ) );
    }

    public function search( Request $request ) {
        $search = $request->search;
        $customer = User::withCount( 'order' )
            ->where( 'role', 'user' )
            ->where( function ( $q ) use ( $search ) {
                $q->orWhere( 'name', 'like', '%' . $search . '%' )
                    ->orWhere( 'email', 'like', '' . $search . '%' );
            } )
            ->orderBy( 'id', 'desc' )
            ->paginate( 10 );
        $customer->appends( $request->all() );
        return view( 'admin.customer.index', compact( 'customer' ) );
    }
}
