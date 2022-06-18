@extends('layout.app')
@section('content')
<div class="container product-detail mt-5 p-4">
    <a href="{{route('home').'#product'}}" class="mt-3 btn btn-blue">All Product</a>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="product-detail-img">
                <div class="card ">
                    <div class="d-flex justify-content-end card-inner">
                        <button class="me-5 heart-btn"><i class="fas fa-heart"></i> <small
                                class="ms-3">{{$product->favourite->count()}}</small></button>
                    </div>
                    <img src="{{asset('image/'.$product->image)}}" alt="" class="img-fluid">
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="product-detail-inner p-5">
                <h4>{{$product->name}}</h4>
                @if ($product->qty >= 10)
                <span class="badge alert-danger">Quantatity High</span>
                @else
                <span class="badge alert-warning">Quantatity Low</span>
                @endif
                @if ($product->discount_price > 0)
                <p class="price">{{$product->price - $product->discount_price}}<small>mmk</small> <small
                    class="text-decoration-line-through text-muted">{{$product->price}}mmk</small></p>
                @else
                <p class="price">{{$product->price - $product->discount_price}}<small>mmk</small>
                @endif
                <p class="category">Category : {{$product->category->name}}</p>
                <span class="view">View count : <span class="badge alert-info rounded-circle">{{$product->view_count}}</span></span>
                <p class="description">Description : {{$product->description}}</p>

                <div class="inc-dec-btn d-flex mt-3">
                    <button class="btn btn-blue minus">-</button>
                    <input type="number" name="" id="root" value="1">
                    <button class="btn btn-blue plus">+</button>
                </div>

                <div class="cart-btn">
                    @auth
                    <button class="btn btn-blue text-uppercase me-3" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fas fa-shopping-bag"></i>
                        Order</button>
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Order Requirement</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  <form method="POST">
                                    <div class="fw-bold">
                                        <span>Total-Price :
                                            <span class="grand-total-price-{{$product->id}}">{{($product->price - $product->discount_price)}}</span>
                                        </span>
                                        <span class="ms-3">Qty:
                                            <span class="grand-qty-{{$product->id}}">1</span>
                                        </span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone" class="col-form-label">Phone:</label>
                                        <input type="text" class="form-control" id="phone" name="phone">
                                        <small class="text-danger d-none" id="phoneError">something</small>
                                      </div>
                                    <div class="mb-3">
                                      <label for="address" class="col-form-label">Address:</label>
                                      <textarea class="form-control" id="address" name="address"></textarea>
                                      <small class="text-danger d-none" id="addressError">something</small>
                                    </div>

                                    {{-- <input type="submit" value="Confirm" class="btn btn-blue"> --}}
                                  </form>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                  <button type="button" class="btn btn-blue order-confirm">Confirm</button>
                                </div>
                              </div>
                            </div>
                        </div>
                    <button class="btn btn-blue text-uppercase add-cart-btn"><i class="fas fa-shopping-cart"></i> Add to
                        Cart</button>
                    @endauth
                    @guest
                    <button class="btn btn-blue text-uppercase me-3 disabled"><i class="fas fa-lock"></i>
                        Sign in first!</button>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(function ($) {
        var data = 0;
        var id = "{{$product->id}}";
        var qty = "{{$product->qty}}";
        var slug = "{{$product->slug}}";

        function chgQtyPrice(){
            var qty_count = $("#root").val();
            var total_price ="{{$product->price - $product->discount_price}}"*qty_count;
            $('.grand-total-price-'+id).text(total_price);
            $('.grand-qty-'+id).text(qty_count);
        }

        $('.plus').on('click', function () {
            data = parseInt($("#root").val());
            data = data + 1;
            if (data > qty) {
                data = 1;
            }
            $("#root").val(data);
            chgQtyPrice();
        });

        $('.minus').on('click', function () {
            data = parseInt($("#root").val());
            data = data - 1;
            if (data <= 1) {
                data = 1;
            }
            $("#root").val(data);
            chgQtyPrice();
        });

        $('.add-cart-btn').on('click',function(){
            var product_count = $('#root').val();
            $.ajax({
                url: `/product-add-cart?id=${id}&qty=${product_count}`,
                type: 'GET',
                success: function(res){
                    if(res.status == 'success'){
                    Toast.fire({
                        icon: 'success',
                        title: res.message,
                        });
                    }else{
                        Toast.fire({
                            icon: 'error',
                            title: res.message,
                        });
                    }
                }
            })
        })

        $('.heart-btn').on('click',function(){
            $.ajax({
                url: `/product-favourite?slug=${slug}`,
                type: 'GET',
                success: function(res){
                    if(res.status == 'success'){
                        $('.heart-btn small').text(res.message);
                    }else{
                        Toast.fire({
                            icon: 'error',
                            title: res.message,
                        })
                    }
                }
            });
        });

        $('.order-confirm').on('click',function(){
            var phone_number = $('#phone').val();
            var address_text = $('#address').val();
            var product_count = $('#root').val();
            $.ajax({
                url: `/make-order?phone=${phone_number}&address=${address_text}&qty=${product_count}&id=${id}`,
                type: 'GET',
                // data: {
                //     phone: phone_number,
                //     address: address_text,
                //     qty : product_count,
                //     id: id,
                // },
                success: function(res){
                    if(res.errors){
                        if(res.errors.phone){
                            $('#phoneError').removeClass("d-none");
                            $('#phoneError').text(res.errors.phone[0]);
                        }else{
                            $('#phoneError').addClass("d-none");
                        }
                        if(res.errors.address){
                            $('#addressError').removeClass("d-none");
                            $('#addressError').text(res.errors.address[0]);
                        }else{
                            $('#addressError').addClass("d-none");
                        }
                    }else{
                        $('#phoneError').addClass("d-none");
                        $('#addressError').addClass("d-none");
                    }

                    if(res.status == 'success'){
                        window.location.href = "{{route('message')}}";
                    }

                    if(res.status == 'error'){
                        Toast.fire({
                            icon: 'error',
                            title: res.message,
                        });
                    }
                }
            })
        });
    });
</script>
@endsection
