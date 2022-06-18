<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $category = Category::latest()->paginate( 10 );
        return view( 'admin.category.index', compact( 'category' ) );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view( 'admin.category.create' );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request ) {
        $validator = Validator::make( $request->all(), array(
            'name' => 'required',
        ), array(
            'name.required' => 'Category name field is required.',
        ) );

        if ( $validator->fails() ) {
            return back()
                ->withErrors( $validator )
                ->withInput();
        }

        $data = $this->categoryData( $request );
        Category::create( $data );

        return to_route( 'category.index' )->with( 'create', 'Category create success.' );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show( $id ) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit( $id ) {
        $category = Category::findOrFail( $id );
        return view( 'admin.category.edit', compact( 'category' ) );
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
            'name' => 'required',
        ), array(
            'name.required' => 'Category name field is required.',
        ) );

        if ( $validator->fails() ) {
            return back()
                ->withErrors( $validator )
                ->withInput();
        }

        $data = $this->categoryData( $request );
        Category::findOrFail( $id )->update( $data );

        return to_route( 'category.index' )->with( 'update', 'Category update success.' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id ) {
        Category::findOrFail( $id )->delete();
        return 'success';
    }

    public function search( Request $request ) {
        $searchData = $request->search;
        $category = Category::where( 'name', 'like', '%' . $searchData . '%' )
            ->latest()
            ->paginate( 10 );
        $category->appends( $request->all() );

        return view( 'admin.category.index', compact( 'category' ) );
    }

    private function categoryData( $request ) {
        return array(
            'slug' => uniqid() . str()->slug( $request->name ),
            'name' => $request->name,
        );
    }

}
