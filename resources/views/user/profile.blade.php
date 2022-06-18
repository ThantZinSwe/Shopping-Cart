@extends('layout.app')
@section('content')
<div class="profile mt-5 p-4">
    <div class="profile-title mt-5 container">
       <div class="card">
            <div class="row">
                <div class="col-md-3 col-sm-12">
                    <div class="user-img">
                        <div class="img">
                            <img src="{{asset('image/'.$user->image)}}" alt="">
                        </div>
                        <form action="{{route('chgUserImg')}}" method="POST" class="mt-4 form-inline" enctype="multipart/form-data">
                            @csrf
                            <label class="custom-file">
                                Edit Image
                                <input type="file" name="image" id="image">
                            </label>
                            <input type="submit" value="Save" class="ms-3 btn btn-outline-warning">
                        </form>
                        <div class="text-center">
                            @if ($errors->has('image'))
                                <small class="text-danger">{{$errors->first('image')}}</small>
                            @endif
                        </div>
                        <hr>
                        <div class="mt-3 text-center">
                            <h5>{{$user->name}}</h5>
                            <p>{{$user->email}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-9 col-sm-12 user-info">
                    <div class="row">
                        <div class="col-md-4 col-sm-12 my-3">
                            <div class="d-flex justify-content-around align-items-center bg-white p-3 rounded-3 shadow card-hover">
                                <div class="user-text">
                                    <p class="text-muted mb-2">Pending Order</p>
                                    <span>{{$pendingOrder}}</span>
                                </div>
                                <i class="fa-solid fa-tags  border rounded-full p-3 bg-blue text-white"></i>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-12 my-3">
                            <div class="d-flex justify-content-around align-items-center bg-white p-3 rounded-3 shadow card-hover">
                                <div class="user-text">
                                    <p class="text-muted mb-2">Complete Order</p>
                                    <span>{{$completeOrder}}</span>
                                </div>
                                <i class="fa-solid fa-tags  border rounded-full p-3 bg-yellow text-white"></i>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-12 my-3">
                            <div class="d-flex justify-content-around align-items-center bg-white p-3 rounded-3 shadow card-hover">
                                <div class="user-text">
                                    <p class="text-muted mb-2">Liked Product</p>
                                    <span>{{$user->favourite_count}}</span>
                                </div>
                                <i class="fas fa-heart  border rounded-full p-3 bg-red text-white"></i>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5">
                        <h5 class="text-muted">Order History</h5>

                        <div class="my-4 status-state">
                            <select name="" id="" class="status form-select">
                                <option value="all">All Order</option>
                                <option value="pending">Pending Order</option>
                                <option value="complete">Complete Order</option>
                            </select>
                        </div>
                        <div class="order-history-table">

                        </div>
                    </div>
                </div>
            </div>
       </div>
    </div>
</div>
@endsection
@section('script')
    <script>
        $(function($){
            userHistory();

            $('#image').on('change',function(){
                var file_length = document.getElementById("image").files.length;

                for(var i=0; i<file_length; i++){
                $('.user-img .img').html(`<img src="${URL.createObjectURL(event.target.files[i])}" class="img-thumbnail" alt=""/>`)
            }
            })

            $(document).on('click','.order-history-link .pagination a',function(event){
                event.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                userHistory(page);
            });

            function userHistory(page){
                var type = $('.status').val();
                $.ajax({
                    url: `user-order-history?type=${type}&page=${page}`,
                    type: 'GET',
                    success: function(res){
                        $('.order-history-table').html(res);
                    }
                });

                $('.status').on('change', function(){
                    userHistory();
                });

                @if(session('success')){
                    Toast.fire({
                    icon: 'success',
                    title: "{{session('success')}}"
                    })
                }
                @endif
            }
        });
    </script>
@endsection
