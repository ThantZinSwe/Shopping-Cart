@extends('layout.app')
@section('content')
<div class=" main-message mt-5 p-4">
    <div class="message-title mt-3 mb-3">
        <div class="row">
            <div class="col-sm-12">
                <div class="col-sm-10 offset-1 text-center">
                    <div class="message-bg">
                        <p class="text-center">Our Thank you page.</p>
                        <h2>Thank you for your order at our website!</h2>
                    </div>
                    <div class="message-content">
                        <h5>We got your order message and our team will confirm soon.</h5>
                        <h5>If you want to know , we confirm or not. You can check your profile.</h5>
                        <h5>Please wait and thank you <i class="fas fa-heart"></i> ! </h5>
                        <a href="{{route('home')}}" class="text-decoration-underline me-3">Back To Home</a>
                        <a href="{{route('cartList')}}" class="text-decoration-underline">Back To cart</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
