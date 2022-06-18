@extends('layout.app')
@section('content')
<div class="container main-cart mt-5 p-4">
    {{-- <div class="d-flex justify-content-center cart-title mt-3 mb-3">
        <h4>Cart List</h4>
    </div> --}}
    <div class="row">
        @php
            $total = 0;
        @endphp
        {{-- Start Total Price Calculation --}}
        @foreach ($productCart as $pc)
        @if ($pc->product->publish_status == 'yes')
        @php
            $total += ($pc->product->price - $pc->product->discount_price) * $pc->qty;
        @endphp
        @endif
        @endforeach
        {{-- End Total Price Calculation --}}
        <div class="col-lg-3 col-md-3 col-sm-12 mt-4 " id="total-price">
            <div class="card price-card shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-around">
                        <h5 class="card-title"><i class="fas fa-shopping-cart"></i> <small
                                class="badge bg-light-blue rounded-circle">{{$cartCount}}</small></h5>
                        <span class="card-text">Total <span class="counter">{{$total}}</span><small>mmk</small></span>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-blue mt-3" data-bs-toggle="modal" data-bs-target="#all-order">Make all Order</button>
                    </div>
                    <div class="modal fade" id="all-order" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">first Order Requirement</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST">
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
                                    </form>
                                </div>
                                <div class="modal-footer all-order">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-blue all-order-confirm">Confirm</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @foreach ($productCart as $k=>$pc)
        @if ($pc->product->publish_status == 'yes')
            <div class="col-lg-9 col-md-9 col-sm-12 mt-4 cart-data cart-id-{{$pc->id}}">
                <input type="hidden" class="cartId" value="{{$pc->id}}">
                <div class="card cart-card shadow">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-12">
                            <div class="p-4 d-flex">
                                <a href="{{route('productDetail',$pc->product->slug)}}">
                                    <img src="{{asset('image/'.$pc->product->image)}}" alt="" width="100px">
                                </a>
                                <div class="cart-card-info ms-4">
                                    <h4>{{$pc->product->name}}</h4>
                                    <p>Category : <span>{{$pc->product->category->name}}</span></p>
                                    @if ($pc->product->discount_price > 0)
                                    <p>Price : <span>
                                            {{$pc->product->price - $pc->product->discount_price}}<small>mmk</small>
                                        </span>
                                        <small class="text-decoration-line-through">{{$pc->product->price}}mmk</small>
                                    </p>
                                    @else
                                    <p>Price : <span>
                                        {{$pc->product->price - $pc->product->discount_price}}<small>mmk</small>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="d-flex justify-content-center fw-bold grand-price">
                                <span class="mt-2" >Total Price :
                                    <span id="grand-total-price-{{$pc->product_id}}">{{($pc->product->price - $pc->product->discount_price)*$pc->qty}}</span>
                                </span>
                            </div>
                            <div class="inc-dec-btn d-flex justify-content-center mt-3 p-3">
                                <input type="hidden" class="product-qty" value="{{$pc->product->qty}}">
                                <input type="hidden" class="product-id" value="{{$pc->product_id}}">
                                <button class="btn btn-blue minus change-qty">-</button>
                                <input type="number" name="" id="root" value="{{$pc->qty}}">
                                <button class="btn btn-blue plus change-qty">+</button>
                            </div>

                            <div class="d-flex justify-content-around mb-3">
                                <button class="btn btn-blue" data-bs-toggle="modal" data-bs-target="#order"><i class="fas fa-shopping-bag"></i> Order</button>
                                <div class="modal fade" id="order" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Order Requirement</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                            <form method="POST">
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
                                <button class="btn btn-danger cancle-btn"><i class="fas fa-trash"></i> Cancle</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 mt-4"></div>
        @endif
        @endforeach
    </div>
</div>
@endsection
@section('script')
    <script>
        $(function ($) {
            counter();
            function counter(){
                $('.counter').each(function () {
                    $(this).prop('Counter', 0).animate({
                        Counter: $(this).text(),
                    }, {
                        duration: 1500,
                        easing: 'swing',
                        step: function (now) {
                            $(this).text(Math.ceil(now) + '')
                        }
                    });
                });
            }

            var data = 1;
            $('.plus').on('click', function () {
                var inc_value = $(this).closest('.cart-data').find('#root').val();
                var limit_qty = $(this).closest('.cart-data').find('.product-qty').val();
                data = parseInt(inc_value);
                data = data + 1;
                if (data > limit_qty) {
                    data = 1;
                }
                $(this).closest('.cart-data').find('#root').val(data);
            });

            $('.minus').on('click', function () {
                var dec_value = $(this).closest('.cart-data').find('#root').val();
                data = parseInt(dec_value);
                data = data - 1;
                if (data <= 1) {
                    data = 1;
                }
                $(this).closest('.cart-data').find('#root').val(data);
            });

            $('.change-qty').on('click',function(){
                var product_id = $(this).closest('.cart-data').find('.product-id').val();
                var qty = $(this).closest('.cart-data').find('#root').val();
                $.ajax({
                    url: `/product-update-cart?product_id=${product_id}&qty=${qty}`,
                    type: 'GET',
                    success: function(res){
                        if(res.status == 'success'){
                            $('#grand-total-price-'+product_id).text(res.updateTotalPrice);
                            counter();
                            $('#total-price').load(location.href + ' .price-card');
                            // window.location.reload();
                        }else{
                            Toast.fire({
                            icon: 'error',
                            title: res.message,
                            })
                        }
                    }
                })
            });

            $('.cancle-btn').on('click',function(){
                var product_id = $(this).closest('.cart-data').find('.product-id').val();
                var cart_id = $(this).closest('.cart-data').find('.cartId').val();
                swal({
                    text: "Are you sure to want to cancel this product from your cart list...?",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: `/product-delete-cart?product_id=${product_id}`,
                            type:'GET',
                            success: function(res){
                                if(res.status == 'success'){
                                    $('.cart-id-'+cart_id).remove();
                                    counter();
                                    $('#total-price').load(location.href + ' .price-card');
                                    Toast.fire({
                                    icon: 'success',
                                    title: res.message,
                                    })
                                }else{
                                    Toast.fire({
                                    icon: 'error',
                                    title: res.message,
                                    })
                                }
                            }
                        });
                    } else {
                        swal("Your data is safe!");
                    }
                });
            })

            $('#order .order-confirm').on('click',function(){
                var phone_number = $('#order #phone').val();
                var address_text = $('#order #address').val();
                var product_count = $('#root').val();
                var product_id = $(this).closest('.cart-data').find('.product-id').val();
                $.ajax({
                    url: `/make-order?phone=${phone_number}&address=${address_text}&qty=${product_count}&id=${product_id}`,
                    type: 'GET',
                    // data: {
                    //     phone: phone_number,
                    //     address: address_text,
                    //     qty : product_count,
                    //     id: product_id,
                    // },
                    success: function(res){
                        if(res.errors){
                            if(res.errors.phone){
                                $('#order #phoneError').removeClass("d-none");
                                $('#order #phoneError').text(res.errors.phone[0]);
                            }else{
                                $('#order #phoneError').addClass("d-none");
                            }
                            if(res.errors.address){
                                $('#order #addressError').removeClass("d-none");
                                $('#order #addressError').text(res.errors.address[0]);
                            }else{
                                $('#order #addressError').addClass("d-none");
                            }
                        }else{
                            $('#order #phoneError').addClass("d-none");
                            $('#order #addressError').addClass("d-none");
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

            $(document).on('click','#all-order .all-order-confirm',function(e){
                e.preventDefault();
                var product_id = [];
                var product_count = [];
                var phone_number = $('#all-order #phone').val();
                var address_text = $('#all-order #address').val();
                $('.cart-data').each(function(){
                    var p_id = $(this).closest('.cart-data').find('.product-id').val();
                    var p_count = $(this).closest('.cart-data').find('#root').val();
                    product_id.push(p_id);
                    product_count.push(p_count);
                });
                $.ajax({
                    url: `/make-all-order?phone=${phone_number}&address=${address_text}&qty=${product_count}&id=${product_id}`,
                    type: 'GET',
                    // data: {
                    //     phone: phone_number,
                    //     address: address_text,
                    //     qty : product_count,
                    //     id: product_id,
                    // },
                    success: function(res){
                        if(res.errors){
                            if(res.errors.phone){
                                $('#all-order #phoneError').removeClass("d-none");
                                $('#all-order #phoneError').text(res.errors.phone[0]);
                            }else{
                                $('#all-order #phoneError').addClass("d-none");
                            }
                            if(res.errors.address){
                                $('#all-order #addressError').removeClass("d-none");
                                $('#all-order #addressError').text(res.errors.address[0]);
                            }else{
                                $('#all-order #addressError').addClass("d-none");
                            }
                        }else{
                            $('#all-order #phoneError').addClass("d-none");
                            $('#all-order #addressError').addClass("d-none");
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
                });
            })
        });
    </script>
@endsection
