<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $product = Product::with( 'category' )->latest()->paginate( 10 );
        return view( 'admin.product.index', compact( 'product' ) );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $category = Category::get();
        return view( 'admin.product.create', compact( 'category' ) );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request ) {
        $validator = Validator::make( $request->all(), array(
            'name'          => 'required',
            'category'      => 'required',
            'image'         => 'required',
            'publishStatus' => 'required',
            'price'         => 'required',
            'description'   => 'required',
            'qty'           => 'required',
        ), array(
            'name.required'          => 'Product name field is required.',
            'category.required'      => 'Category field is required.',
            'image.required'         => 'Image field is required.',
            'publishStatus.required' => 'Publish Status field is required.',
            'price.required'         => 'Price field is required.',
            'description.required'   => 'Description field is required.',
            'qty.required'           => 'Qty field is required.',
        ) );

        if ( $validator->fails() ) {
            return back()
                ->withErrors( $validator )
                ->withInput();
        }

        $file = $request->file( 'image' );
        $fileName = uniqid() . $file->getClientOriginalName();
        Storage::disk( 'image' )->put( $fileName, file_get_contents( $file ) );

        if ( isset( $request->discountPrice ) ) {
            $discount = $request->discountPrice;
        } else {
            $discount = 0;
        }

        $data = $this->productData( $request, $fileName, $discount );
        Product::create( $data );

        return to_route( 'product.index' )->with( 'create', 'Product create success' );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show( $id ) {
        $product = Product::findOrFail( $id );
        return view( 'admin.product.show', compact( 'product' ) );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit( $id ) {
        $product = Product::findOrFail( $id );
        $category = Category::get();
        return view( 'admin.product.edit', compact( 'product', 'category' ) );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, $id ) {
        $validator = Validator::make( $request->all(), array(
            'name'          => 'required',
            'category'      => 'required',
            'publishStatus' => 'required',
            'price'         => 'required',
            'description'   => 'required',
            'qty'           => 'required',
        ), array(
            'name.required'          => 'Product name field is required.',
            'category.required'      => 'Category field is required.',
            'image.required'         => 'Image field is required.',
            'publishStatus.required' => 'Publish Status field is required.',
            'price.required'         => 'Price field is required.',
            'description.required'   => 'Description field is required.',
            'qty.required'           => 'Qty field is required.',
        ) );

        if ( $validator->fails() ) {
            return back()
                ->withErrors( $validator )
                ->withInput();
        }

        $product = Product::findOrFail( $id );

        if ( isset( $request->image ) ) {
            $file = $request->file( 'image' );
            $fileName = uniqid() . $file->getClientOriginalName();
            Storage::disk( 'image' )->delete( $product->image );
            Storage::disk( 'image' )->put( $fileName, file_get_contents( $file ) );
        } else {
            $fileName = $product->image;
        }

        if ( isset( $request->discountPrice ) ) {
            $discount = $request->discountPrice;
        } else {
            $discount = 0;
        }

        $data = $this->productData( $request, $fileName, $discount );
        $product = $product->update( $data );

        return to_route( 'product.index' )->with( 'update', 'Product update success.' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id ) {
        $product = Product::findOrFail( $id );
        Storage::disk( 'image' )->delete( $product->image );
        $product->delete();

        return 'success';
    }

    public function search( Request $request ) {
        $searchData = $request->search;
        $product = Product::with( 'category' )
            ->orWhereHas( 'category', function ( $q ) use ( $searchData ) {
                $q->where( 'name', 'like', '%' . $searchData . '%' );
            } )
            ->orwhere( 'name', 'like', '%' . $searchData . '%' )
            ->orwhere( 'publish_status', 'like', '%' . $searchData . '%' )
            ->orwhere( 'price', 'like', '%' . $searchData . '%' )
            ->orwhere( 'discount_price', 'like', '%' . $searchData . '%' )
            ->orwhere( 'qty', 'like', '%' . $searchData . '%' )
            ->latest()
            ->paginate( 10 );

        $product->appends( $request->all() );

        return view( 'admin.product.index', compact( 'product' ) );
    }

    private function productData( $request, $fileName, $discount ) {
        return array(
            'name'           => $request->name,
            'category_id'    => $request->category,
            'image'          => $fileName,
            'slug'           => uniqid() . str()->slug( $request->name ),
            'publish_status' => $request->publishStatus,
            'price'          => $request->price,
            'discount_price' => $discount,
            'description'    => $request->description,
            'qty'            => $request->qty,
        );
    }

}
