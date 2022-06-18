@extends('layout.master')
@section('style')
<link rel="stylesheet" href="{{asset('main/mdi/css/materialdesignicons.min.css')}}">
@endsection
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-8 col-sm-8 offset-2">
                <a href="{{route('product.index')}}" class="badge mb-3 badge-primary btn-sm"><i class="mdi mdi-backburger"></i></a>
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Product id-{{$product->id}} details </div>
                        <div class="row">
                            <div class="col-md-5 col-sm-12 text-center">
                                <img src="{{asset('image/'.$product->image)}}" alt="" width="120px"
                                style="border-radius: 50%; border:1px solid #eee; padding:5px">
                                <div class="mt-4">
                                    <span class="mr-2">Publish Status : <span class="badge badge-primary">{{$product->publish_status}}</span></span>
                                    <span class="mr-2">Qty : <span class="badge badge-info">{{$product->qty}}</span></span><br>
                                    <span class="mr-2">View Count : <span class="badge badge-warning">{{$product->view_count}}</span></span>
                                </div>
                            </div>
                            <div class="col-md-7 col-sm-12 text-center">
                                <div class="my-2">
                                    <span>Product Name : <b>{{$product->name}}</b></span>
                                </div>
                                <div class="my-2"><span>Category : <b>{{$product->category->name}}</b></span></div>
                                <div class="my-2"><span>Price : <b>{{$product->price}} kyats</b></span></div>
                                <div class="my-2"><span>Discount Price : <b>{{$product->discount_price}} kyats</b></span></div>
                                <div class="my-2"><span>Description : <b>{{$product->description}}</b></span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
