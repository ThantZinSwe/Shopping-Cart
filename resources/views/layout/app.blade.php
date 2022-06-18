<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-commerce</title>

    <!-- Bootstrap 5 Css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- Fontawsome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Fade-in animation -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    {{-- Logo --}}
    <link rel="shortcut icon" href="{{asset('image/shopping-logo.jpg')}}" />
    <!-- css -->
    <link rel="stylesheet" href="{{asset('css/user/style.css')}}">
</head>

<body>
    <!-- Loader Start -->
    <div class="loader d-flex justify-content-center align-items-center" style="min-height: 100vh;" id="pre-loader">
        <div class="circle" id="pre-loader1">
        </div>
        <div class="circle" id="pre-loader2">
        </div>
    </div>
    <!-- Loader End -->
    <!-- Navbar start -->
    <section id="header">
        <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
            <div class="container">
                <a class="navbar-brand" href="{{route('home')}}"><img src="{{asset('images/shop-logo.svg')}}" alt=""></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{route('home')}}">Home</a>
                        </li>
                        @auth()
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('cartList')}}">
                                Cart <span class="badge bg-blue rounded-circle" style="font-size: .7rem;">{{$cartCount}}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{route('userProfile')}}">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{route('logout')}}">Logout</a>
                        </li>
                        @endauth
                        @guest()
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{route('showLogin')}}">Sign in</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{route('showRegister')}}">Register</a>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
    </section>

    <!-- Navbar end -->

    <!-- Home start -->

    <section id="home" class="home mt-5">
        @yield('content')
    </section>

<!-- Home end -->

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
    crossorigin="anonymous"></script>
<!-- Fade-in animation -->
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
{{-- Sweet Alert2 --}}
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{-- Sweet Alert1 --}}
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- JQuery -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- script -->
<script src="{{asset('main/js/script.js')}}"></script>
</body>
<script>
    AOS.init();
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
                headers:{
                    'X-CSRF-TOKEN':token.content
                }
            });
        }else{
            console.log('csrf token is not found');
        }

        @if(session('success')){
                Toast.fire({
                icon: 'success',
                title: "{{session('success')}}"
                })
            }
        @endif

        @if(session('error')){
                Toast.fire({
                icon: 'error',
                title: "{{session('error')}}"
                })
            }
        @endif
    });
</script>
@yield('script')
</html>
