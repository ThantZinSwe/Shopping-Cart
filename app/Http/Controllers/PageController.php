<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductLike;
use App\Models\ProductOrder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\FlareClient\View;

class PageController extends Controller {
    //home page
    public function home() {
        $category = Category::get();
        return view( 'user.index', compact( 'category' ) );
    }

    //product list render
    public function productList( Request $request ) {
        $products = Product::with( 'category', 'favourite' )
            ->where( 'publish_status', 'yes' );

        if ( $category = $request->category ) {
            $products->whereHas( 'category', function ( $q ) use ( $category ) {
                $q->where( 'slug', 'like', '%' . $category . '%' );
            } );
        }

        if ( isset( $request->startDate ) || isset( $request->endDate ) ) {
            $startDate = $request->startDate;
            $endDate = $request->endDate;
            $products->where( function ( $q ) use ( $startDate, $endDate ) {

                if ( !is_null( $startDate ) && is_null( $endDate ) ) {
                    $q->whereDate( 'created_at', '>=', $startDate );
                } elseif ( is_null( $startDate ) && !is_null( $endDate ) ) {
                    $q->whereDate( 'created_at', '<=', $endDate );
                } else {
                    $q->whereDate( 'created_at', '>=', $startDate )
                        ->whereDate( 'created_at', '<=', $endDate );
                }

            } );
        }

        if ( isset( $request->minPrice ) || isset( $request->maxPrice ) ) {
            $minPrice = $request->minPrice;
            $maxPrice = $request->maxPrice;
            $products->where( function ( $q ) use ( $minPrice, $maxPrice ) {

                if ( !is_null( $minPrice ) && is_null( $maxPrice ) ) {
                    $q->where( 'price', '>=', $minPrice );
                } elseif ( is_null( $minPrice ) && !is_null( $maxPrice ) ) {
                    $q->where( 'price', '<=', $maxPrice );
                } else {
                    $q->where( 'price', '>=', $minPrice )
                        ->where( 'price', '<=', $maxPrice );
                }

            } );

        }

        $products = $products->paginate( 6, array( '*' ), 'product' );

        return view( 'user.components.product', compact( 'products' ) )->render();
    }

    //discount product list render
    public function discountProductList() {
        $discountProducts = Product::with( 'favourite' )
            ->where( 'discount_price', '>', 0 )
            ->where( 'publish_status', 'yes' )
            ->paginate( 3, array( '*' ), 'discountProduct' );
        return view( 'user.components.discount-product', compact( 'discountProducts' ) )->render();
    }

    //product detail page
    public function productDetail( $slug ) {
        $product = Product::with( 'category', 'favourite' )
            ->where( 'slug', $slug );
        $product->update( array(
            'view_count' => DB::raw( "view_count + 1" ),
        ) );

        $product = $product->first();

        return view( 'user.product_detail', compact( 'product' ) );
    }

    //Product favourite
    public function productFavourite( Request $request ) {
        $product = Product::where( 'slug', $request->slug );

        if ( Auth::check() ) {

            if ( $product->exists() ) {
                $product = $product->first();

                if ( ProductLike::where( 'product_id', $product->id )->where( 'user_id', auth()->user()->id )->exists() ) {
                    ProductLike::where( 'product_id', $product->id )
                        ->where( 'user_id', auth()->user()->id )
                        ->delete();
                    $favouriteCount = ProductLike::where( 'product_id', $product->id )->count();
                    return array(
                        'status'  => 'success',
                        'message' => $favouriteCount,
                    );
                } else {
                    ProductLike::create( array(
                        'user_id'    => auth()->user()->id,
                        'product_id' => $product->id,
                    ) );
                    $favouriteCount = ProductLike::where( 'product_id', $product->id )->count();
                    return array(
                        'status'  => 'success',
                        'message' => $favouriteCount,
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
                'message' => 'Please login first.',
            );
        }

    }

    //message
    public function message() {

        if ( Auth::check() ) {
            return view( 'user.message' );
        } else {
            return to_route( 'home' )->with( 'error', 'Sorry something wrong' );
        }

    }

    //user profile
    public function userProfile() {

        if ( Auth::check() ) {
            $user = User::where( 'id', auth()->user()->id )
                ->withCount( 'favourite' )
                ->first();
            $completeOrder = ProductOrder::where( 'user_id', $user->id )
                ->where( 'status', 'complete' )
                ->count();
            $pendingOrder = ProductOrder::where( 'user_id', $user->id )
                ->where( 'status', 'pending' )
                ->count();
            return view( 'user.profile', compact( 'user', 'completeOrder', 'pendingOrder' ) );
        } else {
            return to_route( 'home' )->with( 'error', 'Sorry, please login first' );
        }

    }

    //order history render
    public function orderHistory( Request $request ) {

        $user = User::where( 'id', auth()->user()->id )
            ->with( 'order.product' )
            ->first();
        $order = ProductOrder::where( 'user_id', $user->id )
            ->with( 'product' );

        if ( $request->type == "undefined" || $request->type == "all" ) {
            $order->orderBy( 'id', 'desc' );
        }

        if ( $request->type == "pending" ) {
            $order->where( 'status', 'pending' )
                ->orderBy( 'id', 'desc' );
        }

        if ( $request->type == "complete" ) {
            $order->where( 'status', 'complete' )
                ->orderBy( 'id', 'desc' );
        }

        $order = $order->paginate( 10 );

        return view( 'user.components.order-history', compact( 'user', 'order' ) )->render();
    }

    //change user image
    public function chgUserImg( Request $request ) {
        $validator = Validator::make( $request->all(), array(
            'image' => 'required',
        ), array(
            'image.required' => 'Need to choose you want to change image',
        ) );

        if ( $validator->fails() ) {
            return back()
                ->withErrors( $validator )
                ->withInput();
        }

        $user = User::where( 'id', auth()->user()->id )->first();

        $file = $request->file( 'image' );
        $fileName = uniqid() . $file->getClientOriginalName();

        if ( Storage::exists( 'image/' . $user->image ) ) {
            Storage::disk( 'image' )->delete( $user->image );
        }

        Storage::disk( 'image' )->put( $fileName, file_get_contents( $file ) );

        $user->update( array(
            'image' => $fileName,
        ) );

        return redirect()->back()->with( 'success', 'Image update success' );
    }

}
