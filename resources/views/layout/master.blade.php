<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Shopping-cart Admin</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{asset('main/feather/feather.css')}}">
  <link rel="stylesheet" href="{{asset('main/ti-icons/css/themify-icons.css')}}">
  <link rel="stylesheet" href="{{asset('main/css/vendor.bundle.base.css')}}">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="{{asset('main/ti-icons/css/themify-icons.css')}}">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="{{asset('css/vertical-layout-light/style.css')}}">
  <!-- endinject -->
  {{-- icon --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="shortcut icon" href="{{asset('image/shopping-logo.jpg')}}" />
  {{-- font-family --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
@yield('style')
</head>

<body>
<div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo mr-5" href="{{route('dashboard')}}"><img src="{{asset('image/shop-logo.svg')}}" class="mr-2"
            alt="logo" /></a>
        <a class="navbar-brand brand-logo-mini" href="{{route('dashboard')}}"><img src="{{asset('image/shop-logo.svg')}}" alt="logo" /></a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="icon-menu"></span>
        </button>
        <ul class="navbar-nav navbar-nav-right ">
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
              <img src="{{asset('image/profile.png')}}" alt="profile" />
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
              <a class="dropdown-item">
                <i class="ti-settings text-primary"></i>
                Settings
              </a>
              <a class="dropdown-item" href="{{route('admin.logout')}}">
                <i class="ti-power-off text-primary"></i>
                Logout
              </a>
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
          data-toggle="offcanvas">
          <span class="icon-menu"></span>
        </button>
      </div>
    </nav>

    <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_settings-panel.html -->
        <!-- partial -->
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item">
              <a class="nav-link" href="{{route('dashboard')}}">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
              </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('category.index')}}">
                    <i class="fas fa-th-list menu-icon"></i>
                    <span class="menu-title">Category</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('product.index')}}">
                    <i class="fas fa-shopping-bag menu-icon"></i>
                    <span class="menu-title">Product</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('order.pending')}}">
                    <i class="fas fa-clipboard-list menu-icon"></i>
                    <span class="menu-title">Pending Order
                        @if ($order_pending)
                            <span class="badge badge-info">{{$order_pending}}</span>
                        @endif
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('order.complete')}}">
                    <i class="fas fa-clipboard-check menu-icon"></i>
                    <span class="menu-title">Complete Order</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('customer.list')}}">
                    <i class="fas fa-users menu-icon"></i>
                    <span class="menu-title">Customer</span>
                </a>
            </li>
          </ul>
        </nav>
        <!-- partial -->
        @yield('content')
        <!-- main-panel ends -->
    </nav>
      <!-- partial -->
</div>
<!-- container-scroller -->

<!-- plugins:js -->
<script src="{{asset('main/js/vendor.bundle.base.js')}}"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="{{asset('js/off-canvas.js')}}"></script>
<script src="{{asset('js/template.js')}}"></script>
<script src="{{asset('js/hoverable-collapse.js')}}"></script>
<!-- endinject -->
{{-- Sweet Alert2 --}}
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{-- Sweet Alert1 --}}
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- JQuery -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</body>
<script>
    const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
        });

        $(function($){
            let token = document.head.querySelector('meta[name="csrf-token"]');
            if(token){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN':token.content
                    }
                });
            }else{
                console.error('csrf token not found');
            }
        });
</script>
@yield('script')
</html>
