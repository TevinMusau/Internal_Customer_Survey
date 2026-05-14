<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    {{-- AJAX --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    
    <!-- Connecting bootstrap -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
    <!-- Adding specific page titles -->
    <title>@yield('title')</title>

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            background: linear-gradient(135deg, #f0f4f4 0%, #e8f0f1 100%);
            min-height: 100vh;
            flex-direction: column;
            display: flex;
        }

        #loginLink {
            color: #FFE4E1;
            cursor: pointer;
        }

        #loginLink:hover {
            color: #BC8F8F
        }

        #loginLink:active {
            text-decoration: underline;
        }

        #survey:hover {
            opacity: 0.7
        }

        main {
            padding: 1.5rem 2rem;
            flex: 1;
        }

        /* Footer */
        footer {
            background: rgb(0, 57, 61);
            color: rgba(255, 255, 255, 0.6);
            text-align: center;
            padding: 1rem;
            font-size: 12px;
            margin-top: 2rem;
        }

    </style>
</head>

    <body>
        <header class="w-100 sticky-top" style="background-color: rgb(0, 57, 61); box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);">
            <div class="container-fluid">
                <div class="row">
                    <div class="row d-flex ps-3">
                        <div class="navbar px-4" style="height: 70px;">
                            <div class="col-2 d-flex align-items-center justify-content-center">
                                @if (auth()->user())
                                    <a href="{{ route('dashboard', ['id' => auth()->user()->id])}}"> 
                                        <img src="{{ asset('Logo/MMAN_Logo_White.png') }}" class="img-fluid mx-auto" alt="MMAN Advocates Logo" style="width: 110px">
                                    </a>
                                    @else
                                    <a href="{{ route('home')}}"> 
                                        <img src="{{ asset('Logo/MMAN_Logo_White.png') }}" class="img-fluid mx-auto" alt="MMAN Advocates Logo" style="width: 110px">
                                    </a>
                                @endif                                
                            </div>
                            <div class="col-4 p-2 text-start" style="color: white; font-size: 24px; font-weight: 500;">
                                @yield('title')
                            </div>
                            <div class="col-6 p-2 text-end h2">
                                @if (auth()->user())
                                    <div class="dropdown">
                                        <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="background: rgb(232,104,40); color: #fff; font-size: 13px;">
                                            Hello, {{ auth()->user()->first_name }} ({{ auth()->user()->initials }})
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <button class="dropdown-item" type="button">Settings</button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item" type="button">Logout</button>
                                            </li>
                                        </ul>
                                    </div>
                                    @else
                                    <div class="fw-bold">
                                        <button class="btn btn-outline-light" type="button" style="background: rgb(232,104,40); color: #fff; font-size: 13px;">
                                            Login
                                        </button>
                                    </div>
                                @endif
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main>
            {{-- Display page body --}}
            @yield('content')
        </main>

        <footer class="w-100">
            <div class="container-fluid">
                <div class="row">
                    <div class="text-center">
                        Internal Customer Survey!
                    </div>
                    <div class="text-center">
                        Dev: Tevin Mutua!
                        Dev Message: Reveletion 3:20 | Romans 8:38 - 39
                    </div>
                </div>
            </div>
        </footer>

    </body>
</html>