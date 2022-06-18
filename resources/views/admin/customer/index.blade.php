@extends('layout.master')
@section('style')
<link rel="stylesheet" href="{{asset('main/mdi/css/materialdesignicons.min.css')}}">
@endsection
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Customer Table</h4>

                        <div class="row my-3">
                            <div class="col-md-9 col-sm-12"></div>
                            <div class="col-md-3 col-sm-12">
                                <form class="form-inline" action="{{route('customer.search')}}" method="get">
                                    @csrf
                                    <div class="input-group">
                                        <button type="submit" class="input-group-text text-white bg-primary"><span><i class="mdi mdi-account-search"></i></span></button>
                                        <input type="text" name="search" value="{{request('search')}}" class="form-control" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
                                    </div>
                                </form>
                            </div>

                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Image</th>
                                        <th>Total Order</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customer as $c)
                                    <tr class="text-center myTable-{{$c->id}}">
                                        <td>{{$c->id}}</td>
                                        <td>{{$c->name}}</td>
                                        <td>{{$c->email}}</td>
                                        <td>
                                            <img src="{{asset('image/'.$c->image)}}" alt="">
                                        </td>
                                        <td><span class="badge badge-warning">{{$c->order_count}}</span></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="mt-3">
                                {{$customer->links()}}
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
    <script>

    </script>
@endsection

