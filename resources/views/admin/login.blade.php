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
              <h4 class="mb-2 font-weight-bold">Hello! let's get started</h4>
              <h6 class="text-muted">Sign in to continue.</h6>
              @if (Session::has('error'))
                <small class="text-danger font-weight-bold">{{Session::get('error')}}</small>
              @endif
              <form class="pt-3" action="{{route('admin.login')}}" method="post">
                @csrf
                <div class="form-group">
                  <input type="email" name="email" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Email">
                  @if ($errors->has('email'))
                    <small class="text-danger">{{$errors->first('email')}}</small>
                  @endif
                </div>
                <div class="form-group">
                  <input type="password" name="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password">
                  @if ($errors->has('password'))
                    <small class="text-danger">{{$errors->first('password')}}</small>
                  @endif
                </div>
                <div class="mt-3">
                  <input type="submit" value="Sign In" class="btn btn-block btn-primary">
                </div>
                <div class="my-2 d-flex justify-content-between align-items-center">
                  <div class="form-check">
                    <label class="form-check-label text-muted">
                      <input type="checkbox" class="form-check-input">
                      Keep me signed in
                    </label>
                  </div>
                  <a href="#" class="auth-link text-black">Forgot password?</a>
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


