@extends('layout.extra_master')
@section('content')
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo">
                <img src="{{asset('image/shop-logo.svg')}}" alt="logo">
              </div>
              <h4>New here?</h4>
              <h6 class="font-weight-light">Signing up is easy. It only takes a few steps</h6>
              <form class="pt-3" method="post" action="{{route('register')}}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                  <input type="text" name="name" class="form-control form-control-lg" id="exampleInputUsername1" placeholder="Username">
                  @if ($errors->has('name'))
                      <small class="text-danger">{{$errors->first('name')}}</small>
                  @endif
                </div>
                <div class="form-group">
                  <input type="email" name="email" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Email">
                  @if ($errors->has('email'))
                      <small class="text-danger">{{$errors->first('email')}}</small>
                  @endif
                </div>
                <div class="form-group">
                    <input type="file" name="image" class="file-upload-default" id="image">
                    <div class="input-group col-xs-12 d-flex">
                        <input type="text" class="form-control file-upload-info" placeholder="Upload Image">
                        <span class="input-group-append">
                            <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                    </div>
                    <div class="preview-img mt-3">

                    </div>
                </div>
                <div class="form-group">
                  <input type="password" name="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password">
                  @if ($errors->has('password'))
                      <small class="text-danger">{{$errors->first('password')}}</small>
                  @endif
                </div>
                <div class="mb-4">
                  <div class="form-check">
                    <label class="form-check-label text-muted">
                      <input type="checkbox" class="form-check-input">
                      I agree to all Terms & Conditions
                    </label>
                  </div>
                </div>
                <div class="mt-3">
                    <input type="submit" value="Sign Up" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">
                </div>
                <div class="text-center mt-4 font-weight-light">
                  Already have an account? <a href="{{route('showLogin')}}" class="text-primary">Login</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
@endsection
@section('script')
<script src="{{asset('js/file-upload.js')}}"></script>
<script>
    $(function($){
        $('#image').on('change',function(){
            var file_length = document.getElementById("image").files.length;
            $('.preview-img').html("");
            for(var i=0; i<file_length; i++){
                $('.preview-img').append(`<img src="${URL.createObjectURL(event.target.files[i])}" class="img-thumbnail" alt="" width="100px"/>`);
            }
        })
    });
</script>
@endsection

