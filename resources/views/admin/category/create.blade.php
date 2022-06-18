@extends('layout.master')
@section('style')
<link rel="stylesheet" href="{{asset('main/mdi/css/materialdesignicons.min.css')}}">
@endsection
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <a href="{{route('category.index')}}" class="badge mb-3 badge-primary btn-sm"><i class="mdi mdi-backburger"></i></a>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Create Category</h4>
                        <form class="form-inline" action="{{route('category.store')}}" method="post">
                            @csrf
                            <label class="sr-only" for="inlineFormInputGroupUsername2">Name</label>
                            <div class="input-group mb-2 mr-sm-2">
                              <div class="input-group-prepend">
                                <div class="input-group-text"><i class="mdi mdi-plus-circle"></i></div>
                              </div>
                              <input type="text" name="name" class="form-control" id="inlineFormInputGroupUsername2" placeholder="Category Name">
                            </div>

                            @if ($errors->has('name'))
                                <small class="text-danger">{{$errors->first('name')}}</small>
                            @endif

                            <input type="submit" value="Create" class="btn btn-primary btn-rounded mb-2">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
