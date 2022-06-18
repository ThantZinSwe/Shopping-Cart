
<table class="table table-striped table-responsive my-3 text-center">
    <thead>
        <tr class="text-center">
          <th scope="col">Product</th>
          <th scope="col">Image</th>
          <th scope="col">Qty</th>
          <th scope="col">Order Time</th>
          <th scope="col">Status</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($order as $o)
        <tr class="text-center">
            <td class="align-middle">{{$o->product->name}}</td>
            <td>
                <img src="{{asset('image/'.$o->product->image)}}" alt="" width="90px" class="img-thumbnail">
            </td>
            <td class="align-middle">
                <span class="badge bg-blue rounded-circle">{{$o->qty}}</span>
            </td>
            <td class="align-middle">
                {{$o->created_at->diffForHumans()}}
            </td>
            <td class="align-middle">
                <span class="badge bg-blue">{{$o->status}}</span>
            </td>
          </tr>
        @endforeach
      </tbody>
</table>
<div class="mt-3 order-history-link">
    {{$order->links()}}
</div>
