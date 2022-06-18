@extends('layout.master')
@section('style')
<link rel="stylesheet" href="{{asset('main/mdi/css/materialdesignicons.min.css')}}">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Order Table</h4>

                        <div class="row my-3">
                            <div class="col-md-9 col-sm-12">
                                <form action="{{route('order.pending')}}" class="form-inline" method="get">
                                    <div class="form-group col-md-3 col-sm-12">
                                        <input type="text" class="date form-control" placeholder="Start Date" name="start_date" value="{{request('start_date')}}">
                                    </div>
                                    <div class="form-group col-md-3 col-sm-12">
                                        <input type="text" class="date form-control" placeholder="End Date" name="end_date" value="{{request('end_date')}}">
                                    </div>
                                    <div class="form-group col-md-3 col-sm-12">
                                        <input type="text" class="form-control" placeholder="Search" name="search" value="{{request('search')}}">
                                    </div>
                                    <div class="form-group col-md-3 col-sm-12">
                                        <input type="submit" name="filter" id="" value="filter" class="btn btn-inverse-primary">
                                    </div>
                                </form>
                                @if (request()->start_date)
                                    <h5 class="mt-3 ">Between <span class="badge badge-info">{{request()->start_date}}</span> to <span class="badge badge-info">{{request()->end_date}}</span></h5>
                                @endif
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <th>Id</th>
                                        <th>Customer</th>
                                        <th>Product</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Qty</th>
                                        <th>Total Price</th>
                                        <th>Status</th>
                                        <th>Options</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order as $o)
                                    <tr class="text-center myTable-{{$o->id}}">
                                        <td>{{$o->id}}</td>
                                        <td>{{$o->user->name}}</td>
                                        <td>{{$o->product->name}}</td>
                                        <td>{{$o->phone}}</td>
                                        <td>{{$o->address}}</td>
                                        <td>{{$o->qty}}</td>
                                        <td>
                                            <span class="text-danger">
                                                <b>{{$o->qty * ($o->product->price - $o->product->discount_price)}} Ks
                                                </b>
                                            </span>
                                        </td>
                                        <td><span class="badge badge-primary">{{$o->status}}</span></td>
                                        <td>
                                            <a href="{{route('order.makeComplete',$o->id)}}" class="btn btn-primary btn-sm text-white"><i class="mdi mdi-checkbox-marked-circle-outline"></i> Make Complete</a>
                                            <a href="" class="btn btn-danger btn-sm cancel_btn" data-id="{{$o->id}}"><i class="mdi mdi-delete"></i> Cancel</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="mt-3">
                                {{$order->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        $(function($){
            $('.date').daterangepicker({
                "singleDatePicker": true,
                "autoApply": true,
                "showDropdowns": true,
                "locale":{
                    "format" : "YYYY-MM-DD",
                }
            });

            $('.date').val('');

            @if (session('update'))
            Toast.fire({
                icon: 'success',
                title: "{{session('update')}}"
            })
            @endif

            $(document).on('click','.cancel_btn',function(e){
                e.preventDefault();
                var id = $(this).data('id');

                swal({
                    text: "Are you sure to want to cancel this order...?",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            method: "get",
                            url: `/admin/order/${id}`,
                        })
                        .done(function(res){
                            $(".myTable-"+id).remove();
                        });
                    } else {
                        swal("Order is safe!");
                    }
                });
            })
        });
    </script>
@endsection

