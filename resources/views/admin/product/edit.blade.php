@extends('layout.master')
@section('style')
<link rel="stylesheet" href="{{asset('main/mdi/css/materialdesignicons.min.css')}}">
@endsection
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <a href="{{route('product.index')}}" class="badge mb-3 badge-primary btn-sm"><i class="mdi mdi-backburger"></i></a>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Edit Product</h4>
                        <form class="form-sample" action="{{route('product.update',$product->id)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Product Name</label>
                                        <div class="col-sm-9">
                                          <input type="text" class="form-control" name="name" value="{{old('name',$product->name)}}" />

                                        @if ($errors->has('name'))
                                          <small class="text-danger">{{$errors->first('name')}}</small>
                                        @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Category</label>
                                    <div class="col-sm-9">
                                      <select class="form-control" name="category">
                                          <option value="">Choose category</option>
                                        @foreach ($category as $c)
                                            <option value="{{$c->id}}" {{old('category',$product->category_id)==$c->id ? 'selected':''}}>{{$c->name}}</option>
                                        @endforeach
                                      </select>

                                        @if ($errors->has('category'))
                                          <small class="text-danger">{{$errors->first('category')}}</small>
                                        @endif
                                    </div>
                                  </div>
                                </div>
                              </div>
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Image</label>
                                        <div class="col-sm-9">
                                            <input type="file" name="image" class="file-upload-default" id="image">
                                            <div class="input-group col-xs-12">
                                                <input type="text" class="form-control file-upload-info" placeholder="Upload Image">
                                                <span class="input-group-append">
                                                    <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                                                </span>
                                            </div>

                                            <div class="preview-img mt-3">
                                                <img src="{{asset('image/'.$product->image)}}" alt="" width="100px" class="img-thumbnail">
                                            </div>
                                        </div>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Publish Status</label>
                                    <div class="col-sm-4">
                                      <div class="form-check">
                                        <label class="form-check-label">
                                          <input type="radio" class="form-check-input" name="publishStatus" id="publishStatus1" value="yes" {{old('publishStatus',$product->publish_status) == 'yes' ? 'checked' : '' }}>
                                          Yes
                                        </label>
                                      </div>
                                      @if ($errors->has('publishStatus'))
                                          <small class="text-danger">{{$errors->first('publishStatus')}}</small>
                                    @endif
                                    </div>
                                    <div class="col-sm-5">
                                      <div class="form-check">
                                        <label class="form-check-label">
                                          <input type="radio" class="form-check-input" name="publishStatus" id="publishStatus2" value="no"  {{old('publishStatus',$product->publish_status) == 'no' ? 'checked' : '' }}>
                                          No
                                        </label>
                                      </div>
                                    </div>
                                  </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Price</label>
                                    <div class="col-sm-9">
                                      <input type="number" class="form-control" name="price" value="{{old('price',$product->price)}}" />

                                        @if ($errors->has('price'))
                                            <small class="text-danger">{{$errors->first('price')}}</small>
                                        @endif
                                    </div>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Discount Price</label>
                                    <div class="col-sm-9">
                                      <input type="text" class="form-control" name="discountPrice" value="{{old('discountPrice',$product->discount_price)}}" />
                                    </div>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                  <div class="form-group row">
                                      <label class="col-sm-3 col-form-label">Qty</label>
                                      <div class="col-sm-9">
                                        <input type="number" class="form-control" name="qty" value="{{old('qty',$product->qty)}}"/>

                                        @if ($errors->has('qty'))
                                          <small class="text-danger">{{$errors->first('qty')}}</small>
                                        @endif
                                      </div>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Description</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" name="description" id="exampleTextarea1" rows="4">{{old('description',$product->description)}}</textarea>

                                        @if ($errors->has('description'))
                                          <small class="text-danger">{{$errors->first('description')}}</small>
                                        @endif
                                    </div>
                                  </div>
                                </div>

                                <div class="float-left">
                                    <input type="submit" value="Update" class="btn btn-rounded btn-primary mb-2">
                                </div>
                              </div>
                          </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{asset('js/file-upload.js')}}"></script>
<script>
    $(function($){
        $('#image').on('change',function(){
            var file_length = document.getElementById("image").files.length;
            $('.preview-img').html('');

            for(var i=0; i<file_length; i++){
                $('.preview-img').append(`<img src="${URL.createObjectURL(event.target.files[i])}" class="img-thumbnail" alt="" width="100px"/>`)
            }
        });
    });
</script>
@endsection
