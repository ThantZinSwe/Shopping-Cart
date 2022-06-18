<div class="row my-5">
    @foreach ($discountProducts as $dp)
    <div class="col-lg-4 col-md-4 col-sm-12 mb-3 mt-3" data-aos="fade-in" data-aos-duration="1500"
        data-aos-once="false">
        <a href="{{route('productDetail',$dp->slug)}}">
            <div class="discount-box text-center position-relative">
                <div class="discount-inner">
                    <div class="discount-image positive-relative overflow-hidden">
                        <img src="{{asset('image/'.$dp->image)}}" alt="" class="img-fluid">
                        <div class="discount-overlay"></div>
                    </div>
                    <div class="discount-info">
                        <div class="discount-info-inner">
                            <p class="heading text-capitalize">{{$dp->name}}
                            </p>
                            <div class="">
                                <span class="me-2 price">{{$dp->price - $dp->discount_price}}<small>mmk</small></span>
                                <span
                                    class="text-decoration-line-through original-price text-muted">{{$dp->price}}mmk
                                </span>
                            </div>
                            <p class="discount-title">Dont miss this
                                chance.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        <div class="d-flex justify-content-center mt-3 discount-footer">
            <span class="me-4 heart-btn "><i class="fa-solid fa-heart"></i>
                <span>{{$dp->favourite->count()}}</span>
            </span>
            <a href="{{route('productDetail',$dp->slug)}}" class="btn btn-blue text-uppercase">
                <i class="fas fa-eye"></i> View Detail
            </a>
        </div>
    </div>
    @endforeach
    <div class="mt-3">
        {{$discountProducts->links()}}
    </div>
</div>
