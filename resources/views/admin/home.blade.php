@extends('layout.master')
@section('style')
<link rel="stylesheet" href="{{asset('main/mdi/css/materialdesignicons.min.css')}}">
@endsection
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-md-12 grid-margin">
          <div class="row">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
              <h3 class="font-weight-bold">Welcome My Shop</h3>
              <h6 class="font-weight-normal mb-0">All systems are running smoothly!</h6>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 grid-margin transparent">
          <div class="row">
            <div class="col-md-5 col-12 mb-4 stretch-card transparent">
              <div class="card card-tale">
                <div class="card-body">
                  <p class="mb-4">Total Orders</p>
                  <p class="fs-30 mb-2">{{$totalOrder}}</p>
                  <p>Start day to today.</p>
                </div>
              </div>
            </div>
            <div class="col-md-5 col-12 mb-4 stretch-card transparent">
              <div class="card card-dark-blue">
                <div class="card-body">
                  <p class="mb-4">Total Product</p>
                  <p class="fs-30 mb-2">{{$totalProduct}}</p>
                  <p>Start day to today.</p>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-5 col-12 mb-4 mb-lg-0 stretch-card transparent">
              <div class="card card-light-blue">
                <div class="card-body">
                  <p class="mb-4">Total User</p>
                  <p class="fs-30 mb-2">{{$totalUser}}</p>
                  <p>Start day to today.</p>
                </div>
              </div>
            </div>
            <div class="col-md-5 col-12 stretch-card transparent">
              <div class="card card-light-danger">
                <div class="card-body">
                  <p class="mb-4">Number of Orders</p>
                  <p class="fs-30 mb-2">{{$latestOrder->count()}}</p>
                  <p>Today.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

        {{-- Latest Order Table Start --}}
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Latest Order</h4>

                        <div class="row my-3">
                            <div class="col-md-9 col-sm-12"></div>
                            <div class="col-md-3 col-sm-12">
                                <form class="form-inline" action="{{route('dashboard')}}" method="get">
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
                                        <th>Customer</th>
                                        <th>Product</th>
                                        <th>Qty</th>
                                        <th>Total Price</th>
                                        <th>Status</th>
                                        <th>Order Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($latestOrder as $lo)
                                    <tr class="text-center myTable-{{$lo->id}}">
                                        <td>{{$lo->id}}</td>
                                        <td>{{$lo->user->name}}</td>
                                        <td>{{$lo->product->name}}</td>
                                        <td><span class="badge badge-info">{{$lo->qty}}</span></td>
                                        <td>
                                            <span class="text-danger">
                                                <b>{{$lo->qty * ($lo->product->price - $lo->product->discount_price)}} Ks
                                                </b>
                                            </span>
                                        </td>
                                        <td>
                                            @if ($lo->status == 'pending')
                                                <span class="badge badge-primary">{{$lo->status}}</span>
                                            @else
                                                <span class="badge badge-danger">{{$lo->status}}</span>
                                            @endif
                                        </td>
                                        <td>{{$lo->created_at->diffForHumans()}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="mt-3">
                                {{$latestOrder->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Latest Order Table End --}}

        {{-- Order Chart Start --}}
        <div class="row mt-5">
            <div class="col-md-12 col-sm-12 ">
                <canvas id="orderChart" width="400" height="150"></canvas>
            </div>
        </div>
        {{-- Order Chart End --}}
    </div>
  </div>
</div>
@endsection
@section('script')
{{-- Chart js --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
<script>
    $(function($){
        @if(session('success'))
        Toast.fire({
            icon: 'success',
            title: "{{session('success')}}"
        })
        @endif

        const labels = [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December',
        ];

        const data = {
            labels: labels,
            datasets: [{
            label: 'Order dataset',
            backgroundColor: 'rgb(100,110,228)',
            borderColor: "rgb(100,110,228)",
            pointHoverBackgroundColor: "#55bae7",
            pointHoverBorderColor: "#55bae7",
            data: {{json_encode($chartData)}},
            }]
        };

        const config = {
            type: 'line',
            data: data,
            options: {}
        };

        const myChart = new Chart(
            document.getElementById('orderChart'),
            config
        );
    });
</script>
@endsection
