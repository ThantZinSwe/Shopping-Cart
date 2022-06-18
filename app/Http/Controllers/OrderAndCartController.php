<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCart;
use App\Models\ProductOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderAndCartController extends Controller {

    //Product add cart
    public function addToCart( Request $request ) {
        $product = Product::where( 'id', $request->id );

        if ( Auth::check() ) {

            if ( $product->exists() ) {
                $product = $product->first();

                if ( $product->publish_status == 'yes' ) {

                    if ( ProductCart::where( 'product_id', $product->id )->where( 'user_id', auth()->user()->id )->exists() ) {
                        return array(
                            'status'  => 'error',
                            'message' => $product->name . ' already added to cart.',
                        );
                    } else {
                        ProductCart::create( array(
                            'user_id'    => auth()->user()->id,
                            'product_id' => $product->id,
                            'qty'        => $request->qty,
                        ) );

                        return array(
                            'status'  => 'success',
                            'message' => $product->name . ' add to cart complete.',
                        );
                    }

                } else {
                    return array(
                        'status'  => 'error',
                        'message' => 'Sorry this product is not avaliable.',
                    );
                }

            } else {
                return array(
                    'status'  => 'error',
                    'message' => 'Sorry something wrong.',
                );
            }

        } else {
            return array(
                'status'  => 'error',
                'message' => 'Please Login first',
            );
        }

    }

    //Show cart-list
    public function cartList() {

        if ( Auth::check() ) {
            $productCart = ProductCart::with( 'product.category', 'user.cart' )
                ->where( 'user_id', auth()->user()->id )
                ->get();
            return view( 'user.cart', compact( 'productCart' ) );
        } else {
            return to_route( 'home' )->with( 'error', 'Please login first!' );
        }

    }

    //Update Cart
    public function updateCart( Request $request ) {

        if ( Auth::check() ) {
            $cart = ProductCart::where( 'product_id', $request->product_id )->where( 'user_id', auth()->user()->id );
            $product = Product::where( 'id', $request->product_id );

            if ( $cart->exists() ) {
                $product = $product->first();
                $cart = $cart->first();

                if ( $product->publish_status == 'yes' ) {
                    $cart->update( array(
                        'qty' => $request->qty,
                    ) );
                    $updateQty = $cart->qty;
                    $totalPrice = ( $product->price - $product->discount_price ) * $updateQty;
                    return array(
                        'status'           => 'success',
                        'updateQty'        => $updateQty,
                        'updateTotalPrice' => $totalPrice,
                    );
                } else {
                    $cart->delete();
                    return array(
                        'status'  => 'error',
                        'message' => 'Sorry,' . $product->name . ' isnt avaliable now.',
                    );
                }

            } else {
                return array(
                    'status'  => 'error',
                    'message' => 'Sorry something wrong',
                );
            }

        } else {
            return array(
                'status'  => 'error',
                'message' => 'Please Login first',
            );
        }

    }

    //Delete Cart
    public function deleteCart( Request $request ) {

        if ( Auth::check() ) {
            $cart = ProductCart::where( 'product_id', $request->product_id )->where( 'user_id', auth()->user()->id );
            $product = Product::where( 'id', $request->product_id )->where( 'publish_status', 'yes' );

            if ( $cart->exists() && $product->exists() ) {
                $cart->delete();
                return array(
                    'status'  => 'success',
                    'message' => 'Remove success.',
                );
            } else {
                return array(
                    'status'  => 'error',
                    'message' => 'Sorry something wrong',
                );
            }

        } else {
            return array(
                'status'  => 'error',
                'message' => 'Please Login first',
            );
        }

    }

    //Make Order
    public function makeOrder( Request $request ) {
        $validator = Validator::make( $request->all(), array(
            'phone'   => 'required',
            'address' => 'required',
        ), array(
            'phone.required'   => 'Phone field is required!',
            'address.required' => 'Address field is required!',
        ) );

        if ( $validator->fails() ) {
            return response()->json( array( 'errors' => $validator->errors() ) );
        }

        if ( Auth::check() ) {
            $product = Product::where( 'id', $request->id )->where( 'publish_status', 'yes' );

            if ( $product->exists() ) {
                $product = $product->first();
                ProductOrder::create( array(
                    'user_id'    => auth()->user()->id,
                    'product_id' => $product->id,
                    'qty'        => $request->qty,
                    'status'     => 'pending',
                    'phone'      => $request->phone,
                    'address'    => $request->address,
                ) );
                $cart = ProductCart::where( 'product_id', $product->id )->where( 'user_id', auth()->user()->id );

                if ( $cart->exists() ) {
                    $cart->delete();
                }

                $product->update( array(
                    'qty' => $product->qty - $request->qty,
                ) );
                return array(
                    'status' => 'success',
                );
            } else {
                return array(
                    'status'  => 'error',
                    'message' => 'Sorry, this product isnt avaliable now.',
                );
            }

        } else {
            return array(
                'status'  => 'error',
                'message' => 'Please Login first',
            );
        }

    }

    //Make all Order
    public function makeAllOrder( Request $request ) {
        $validator = Validator::make( $request->all(), array(
            'phone'   => 'required',
            'address' => 'required',
        ), array(
            'phone.required'   => 'Phone field is required!',
            'address.required' => 'Address field is required!',
        ) );

        if ( $validator->fails() ) {
            return response()->json( array( 'errors' => $validator->errors() ) );
        }

        if ( Auth::check() ) {
            $array_qty = explode( ',', $request->qty );
            $array_id = explode( ',', $request->id );

            foreach ( $array_id as $k => $productId ) {
                $product = Product::where( 'id', $productId );
                $productStatus = Product::where( 'id', $productId )->where( 'publish_status', 'yes' );
                $qty = $array_qty[$k];

                if ( $product->exists() && $productStatus->exists() ) {
                    $product = $product->first();
                    ProductOrder::create( array(
                        'user_id'    => auth()->user()->id,
                        'product_id' => $productId,
                        'qty'        => $qty,
                        'status'     => 'pending',
                        'phone'      => $request->phone,
                        'address'    => $request->address,
                    ) );

                    $cart = ProductCart::where( 'product_id', $product->id )->where( 'user_id', auth()->user()->id );

                    if ( $cart->exists() ) {
                        $cart->delete();
                    }

                    $product->update( array(
                        'qty' => $product->qty - $qty,
                    ) );
                } else {
                    return array(
                        'status'  => 'error',
                        'message' => 'Sorry,' . $product->first()->name . ' isnt avaliable now.',
                    );
                }

            }

            return array(
                'status' => 'success',
            );

        } else {
            return array(
                'status'  => 'error',
                'message' => 'Please Login first',
            );
        }

    }

}
