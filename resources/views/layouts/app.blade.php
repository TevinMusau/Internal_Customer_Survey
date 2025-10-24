<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    
    <!-- Connecting bootstrap -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
    <!-- Adding specific page titles -->
    <title>@yield('title')</title>

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<style>
    body{
        background-color: #F5F5F5;
    }
    #aboutLink{
        color: #FFE4E1;
        cursor: pointer;
    }
    #aboutLink:hover{
        color: #BC8F8F;
    }
    #aboutLink:active{
        text-decoration: underline;
    }
    #contactLink{
        color: #FFE4E1;
        cursor: pointer;
    }
    #contactLink:hover{
        color: #BC8F8F;
    }
    #contactLink:active{
        text-decoration: underline;
    }
    #loginLink{
        color: #FFE4E1;
        cursor: pointer;
    }
    #loginLink:hover{
        color: #BC8F8F
    }
    #loginLink:active{
        text-decoration: underline;
    }
    #registerLink{
        color: #FFE4E1;
        cursor: pointer;
    }
    #registerLink:hover{
        color: #BC8F8F;
    }
    #registerLink:active{
        text-decoration: underline;
    }
    #related1{
        color: #FFE4E1;
        cursor: pointer;
    }
    #related1:hover{
        color: #BC8F8F;
    }
    #related1:active{
        text-decoration: underline;
    }
    #related2{
        color: #FFE4E1;
        cursor: pointer;
    }
    #related2:hover{
        color: #BC8F8F;
    }
    #related2:active{
        text-decoration: underline;
    }
    #related3{
        color: #FFE4E1;
        cursor: pointer;
    }
    #related3:hover{
        color: #BC8F8F;
    }
    #related3:active{
        text-decoration: underline;
    }

    #survey:hover{
        opacity: 0.7
    }

    .fa {
        padding: 10px;
        font-size: 30px;
        width: 50px;
        text-align: center;
        text-decoration: none;
        border-radius: 10%;
    }

    /* Facebook */
    .fa-facebook {
        background: #3B5998;
        color: white;
    }

    /* Twitter */
    .fa-twitter {
        background: #55ACEE;
        color: white;
    }

    /* Instagram */
    .fa-instagram {
        background: #125688;
        color: white;
    }

    /* Pinterest */
    .fa-pinterest {
        background: #cb2027;
        color: white;
    }

</style>
    <header class="col-12">
        <div class="mb-5">
            <div class="row" style="background-color: black">
                <div class="col-4 mt-2 mb-3 text-center">
                    <a href="{{ route('home')}}"> <img src="{{ asset('Logo/MMAN_Logo.png') }}"  class="img-fluid w-50 text-center " alt="MMAN Advocates Logo"></a>
                </div>
                <div class="col-8 mt-5">
                    <div class="navbar justify-content-end">
                        <ul class="nav justify-content-center">
                            {{-- <li class="nav-item">
                                <a id="aboutLink" class="nav-link fs-5" href="/home">About</a>
                            </li>
                            <li class="nav-item">
                                <a id="contactLink" class="nav-link fs-5" href="/home">Contact</a>
                            </li> --}}
                            {{-- Check if there is a currently logged in user --}}
                            @if(auth()->user())
                                {{-- Check if user is a super admin --}}
                                @if (auth()->user()->level == 'superAdmin')
                                    <li class="nav-item">
                                        <a id="contactLink" class="nav-link fs-5" href="{{ url('dashboard/'.auth()->user()->id) }}">Hello IT Admin, {{auth()->user()->first_name}}</a>
                                    </li>

                                @else
                                    <li class="nav-item">
                                        <a id="contactLink" class="nav-link fs-5" href="{{ url('dashboard/'.auth()->user()->id) }}">Hello {{auth()->user()->first_name}}</a>
                                    </li>
                                    
                                @endif

                                <li class="nav-item">
                                    <a id="contactLink" class="nav-link fs-5" href="{{ route('logout') }}">Logout</a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a id="loginLink" class="nav-link fs-5" href="{{ route('login') }}">Login</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>  
        
        <main>
            {{-- Display page body --}}
            @yield('content')
        </main>
    </header>

    <footer class="mt-4 p-3" style="background-color: #1B1B1B">
        <div class="container-fluid">
            <div class="row text-center">
                <div class="col-md-4">
                    <a href="{{ '/home' }}"><img class="w-75" src="{{ asset('/Logo/MMAN_Logo.png') }}"/></a>

                    <hr style="color: white">
                    <h5 style="color: #FFE4E1"> Our Social Media </h5>
                    <hr style="color: white">
                    <div class="social" style="margin-top: 20px">
                        <a href="#" class="fa fa-facebook"></a>
                        <a href="#" class="fa fa-twitter"></a>
                        <a href="#" class="fa fa-instagram"></a>
                        <a href="#" class="fa fa-pinterest"></a>
                    </div>
                </div>
                <div class="col-md-4">
                    <hr style="color: white">
                    <h5 id="footer_sub" style="color: #FFE4E1"> Contact Us </h5>
                    <hr style="color: white">
                    
                    <p style="color: #FFE4E1"> Tel:
                    (+254) (0)208697960/+254-202596994</p>
                    <p style="color: #FFE4E1"> Mobile: (+254) (0) 718 268 683 </p>
                    <p style="color: #FFE4E1"> Email: 
                    <a href="mailto:info@nataliekendi.co.ke" id="link_email">mman@mman.co.ke</a></p>

                    <hr style="color: white">
                    <h5 id="footer_sub" style="color: #FFE4E1"> Address </h5>
                    <hr style="color: white">

                    <p style="color: #FFE4E1"> 4th Floor, Wing B, Capitol Hill Square, Off Chyulu Road, Upper Hill, Nairobi, Kenya </p>
                </div>
                <div class="col-md-4">
                    <hr style="color: white">
                    <h5 style="color: #FFE4E1"> Related Links </h5>
                    <hr style="color: white">

                    <a id="related1" class="text-decoration-none" href="https://mmankenya.sharepoint.com/sites/mmanintranet/" id="link" target="_blank"> <p> The Bar </p> </a>
                    <a id="related2" class="text-decoration-none" href="https://portal.office.com" id="link" target="_blank"> <p> Microsoft 365 </p> </a>
                    <a id="related3" class="text-decoration-none" href="https://dashboard.myworkpay.com/" id="link" target="_blank"> <p> WorkPay </p> </a>
                </div>
            </div>
        </div>
    </footer>
</html>