<div class="row">
    @foreach ($products as $p)
    <div class="col-lg-4 col-md-4 col-sm-12 mt-3" >
        <div class="card">
            <a href="{{route('productDetail',$p->slug)}}">
                <div class="product-card">
                    <div class="inner">
                        <img src="{{asset('image/'.$p->image)}}" class="card-img-top product-img" alt="...">
                    </div>
                    <div class="card-body">
                        <div class="text-center product-info">
                            <p class="product-name">{{$p->name}}
                            </p>
                            @if ($p->discount_price > 0)
                            <span class="product-price">{{$p->price - $p->discount_price}}<small>mmk</small>
                                <small
                                    class="ms-3 text-muted text-decoration-line-through">{{$p->price}}mmk</small>
                            </span>
                            @else
                            <span class="product-price">{{$p->price}}<small>mmk</small>
                            @endif
                        </div>
                    </div>
                </div>
            </a>
            <div class="card-footer product-footer d-flex justify-content-between">
                <span class="me-4 heart-btn"><i class="fa-solid fa-heart"></i>
                    <span>{{$p->favourite->count()}}</span>
                </span>
                    <a href="{{route('productDetail',$p->slug)}}" class="btn btn-blue text-uppercase"><i
                        class="fas fa-eye"></i>
                   View Detail</a>
            </div>
        </div>
    </div>
    @endforeach
    <div class="mt-3">
        {{$products->links()}}
    </div>
</div>

