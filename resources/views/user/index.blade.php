@extends('layout.app')
@section('content')
    <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active" data-bs-interval="10000">
                <div class="home-banner home-banner-1">
                    <div class="home-banner-text">
                        <h1>Lady Clothes</h1>
                        <h2>Are Available Now Here!</h2>
                        <a href="#product" class="btn btn-danger">Our Product</a>
                    </div>
                </div>
            </div>
            <div class="carousel-item" data-bs-interval="2000">
                <div class="home-banner home-banner-2">
                    <div class="home-banner-text">
                        <h1>Men Clothes</h1>
                        <h2>Are Available Now Here!</h2>
                        <a href="#product" class="btn btn-danger">Our Product</a>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="home-banner home-banner-3">
                    <div class="home-banner-text">
                        <h1>Watches</h1>
                        <h2>Are Available Now Here!</h2>
                        <a href="#product" class="btn btn-danger">Our Product</a>
                    </div>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
     <!-- Discount Product start -->
     <div class="container discount mt-4">
        <div class="d-flex justify-content-center shop-title">
            <h2>Discount Product</h2>
        </div>

        <div class="discountProductList">

        </div>
    </div>
    <!-- Discount Product end -->

    <!-- Shop start -->
    <div class="container shop mt-4" id="product">
        <div class="d-flex justify-content-center shop-title">
            <h2>Shop</h2>
        </div>

        <div class="row my-5">
            <div class="col-lg-4 col-md-4 col-sm-12 filter left slide-in">
                <form action="">
                    <div class="category-select">
                        <select name="" id="" class="form-select select-picker category">
                            <option value="" class="text-muted">Choose Category
                            </option>
                            @foreach ($category as $c)
                                <option value="{{$c->slug}}">{{$c->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="text-center m-4 p-2">
                        <h3 class="mb-3">Start Date - End Date</h3>
                        <input type="text" name="" id="" class="form-control date start-date" placeholder="YYYY-MM-DD"
                            onfocus="(this.type='date')" onblur="(this.type='text')">-
                        <input type="text" name="" id="" class="form-control date end-date" placeholder="YYYY-MM-DD"
                            onfocus="(this.type='date')" onblur="(this.type='text')">
                    </div>
                    <hr>
                    <div class="text-center m-4 p-2">
                        <h3 class="mb-3">Min - Max Amount</h3>
                        <input type="number" name="miniPrice" id="" class="form-control min-price"
                            placeholder="minimum price"> -
                        <input type="number" name="maxPrice" id="" class="form-control max-price" placeholder="maximun price">
                    </div>

                    <input type="submit" value="Search" class="btn btn-block btn-blue search-btn">
                </form>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-12 right slide-in">
                <div class="productList">

                </div>
            </div>
        </div>
    </div>
    <!-- Shop end -->

    <!-- About start -->
    <div class="container my-5 about" id="about">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 left slide-in">
                <div class="about-img">
                    <img src="images/2609.jpg" alt="" class="img-fluid shadow">
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 mt-5 right slide-in">
                <div class="d-flex justify-content-center shop-title">
                    <h2>About Us</h2>
                </div>
                <p class="mt-4 lh-lg">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo, saepe? Sapiente
                    natus
                    modi
                    asperiores id, illo sint praesentium ipsam consequuntur iste vitae minus aut aperiam, illum,
                    reprehenderit atque qui rem?</p>
            </div>
        </div>
    </div>
    <!-- About end -->
    <!-- Footer Start-->
    <section class="footer mt-5">
        <div class="footer-inner">
            <h3>E-commerce</h3>

            <h5>Contact me <b>thantzinswe01@gamil.com</b></h5>
            <h5><i class="fa-brands fa-facebook"></i> : <a href="https://www.facebook.com/thantzin.swe.393">Thant
                    Zin Swe</a>
            </h5>

            <div class="d-flex justify-content-center">
                <span>Design by <i class="fas fa-heart"></i> Thant Zin Swe.</span>
            </div>
        </div>
    </section>
    <!-- Footer End -->
@endsection
@section('script')
    <script>
        $(function($){
            discountProductList();
            productList();

            $(document).on('click','.productList .pagination a',function(event){
                event.preventDefault();
                var page = $(this).attr('href').split('product=')[1];
                console.log($(this).attr('href').split('product='));
                productList(page);
            });

            $(document).on('click','.discountProductList .pagination a',function(event){
                event.preventDefault();
                var page = $(this).attr('href').split('discountProduct=')[1];
                discountProductList(page);
            })

            function productList(page){
                var categroy = $('.category').val();
                var startDate = $('.start-date').val();
                var endDate = $('.end-date').val();
                var minPrice = $('.min-price').val();
                var maxPrice = $('.max-price').val();
                $.ajax({
                    url: `/product-list?category=${categroy}&startDate=${startDate}&
                        endDate=${endDate}&minPrice=${minPrice}&maxPrice=${maxPrice}&product=${page}`,
                    type: 'GET',
                    success: function(res){
                        $('.productList').html(res);
                    }
                });

                $('.search-btn').on('click',function(event){
                    event.preventDefault();
                    productList();
                })
            }

            function discountProductList(page){
                $.ajax({
                    url:`/discount-product-list?discountProduct=${page}`,
                    type:'GET',
                    success: function(res){
                        $('.discountProductList').html(res);
                    }
                })
            }
        });
    </script>
@endsection




