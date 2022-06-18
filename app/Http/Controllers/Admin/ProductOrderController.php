<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductOrder;
use Illuminate\Http\Request;

class ProductOrderController extends Controller {
    public function pending( Request $request ) {

        $order = ProductOrder::where( 'status', 'pending' )
            ->with( 'user', 'product' )
            ->orderBy( 'id', 'desc' );

        if ( isset( $request->start_date ) ) {
            $order->whereBetween( 'created_at', array( $request->start_date, $request->end_date ) );
        }

        if ( isset( $request->search ) ) {
            $search = $request->search;
            $order->where( function ( $q ) use ( $search ) {
                $q->orWhereHas( 'user', function ( $q1 ) use ( $search ) {
                    $q1->where( 'name', 'like', '%' . $search . '%' );
                } )->orWhereHas( 'product', function ( $q1 ) use ( $search ) {
                    $q1->where( 'name', 'like', '%' . $search . '%' );
                } )->orWhere( 'phone', 'like', '%' . $search . '%' )
                    ->orWhere( 'address', 'like', '%' . $search . '%' )
                    ->orWhere( 'qty', 'like', '%' . $search . '%' );
            } );
        }

        $order = $order->paginate( 10 );
        $order->appends( $request->all() );
        return view( 'admin.order.order_pending', compact( 'order' ) );
    }

    public function orderCancel( $id ) {
        $order = ProductOrder::findOrFail( $id );
        $product = Product::where( 'id', $order->product_id )->first();
        $product->update( array(
            'qty' => $order->qty + $product->qty,
        ) );
        $order->delete();
        return 'success';
    }

    public function makeComplete( $id ) {
        ProductOrder::findOrFail( $id )->update( array(
            'status' => 'complete',
        ) );

        return to_route( 'order.pending' )->with( 'update', 'Change to complete success.' );
    }

    public function complete( Request $request ) {
        $order = ProductOrder::where( 'status', 'complete' )
            ->with( 'user', 'product' )
            ->orderBy( 'id', 'desc' );

        if ( isset( $request->start_date ) ) {
            $order->whereBetween( 'created_at', array( $request->start_date, $request->end_date ) );
        }

        if ( isset( $request->search ) ) {
            $search = $request->search;
            $order->where( function ( $q ) use ( $search ) {
                $q->orWhereHas( 'user', function ( $q1 ) use ( $search ) {
                    $q1->where( 'name', 'like', '%' . $search . '%' );
                } )->orWhereHas( 'product', function ( $q1 ) use ( $search ) {
                    $q1->where( 'name', 'like', '%' . $search . '%' );
                } )->orWhere( 'phone', 'like', '%' . $search . '%' )
                    ->orWhere( 'address', 'like', '%' . $search . '%' )
                    ->orWhere( 'qty', 'like', '%' . $search . '%' );
            } );
        }

        $order = $order->paginate( 10 );
        $order->appends( $request->all() );
        return view( 'admin.order.order_complete', compact( 'order' ) );

    }

}
