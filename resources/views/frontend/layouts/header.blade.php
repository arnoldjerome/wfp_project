<header class="fp__header" style="background-color: #8b0000; color: white;">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light d-flex align-items-center" style="padding: 8px 0;">
            <a class="navbar-brand" href="{{ route('customer.home') }}">
                <img src="{{ asset('frontend/images/logo.png') }}" alt="Velocity Logo" style="max-height: 110px; width: auto; display: block;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item">
                        <a href="{{ route('customer.home') }}" class="nav-link" style="color: white; font-weight: bold; transition: color 0.3s;">
                            Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('menu') }}" class="nav-link" style="color: white; font-weight: bold; transition: color 0.3s;">
                            Menu
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" style="color: white; font-weight: bold; transition: color 0.3s;">
                            Contact
                        </a>
                    </li>
                    {{-- Guest links --}}
                    @guest
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="nav-link" style="color: white; font-weight: bold; transition: color 0.3s;">
                                Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('register') }}" class="nav-link" style="color: white; font-weight: bold; transition: color 0.3s;">
                                Register
                            </a>
                        </li>
                    @endguest

                    {{-- Authenticated user: Logout --}}
                    @auth
                        <li class="nav-item">
                            <a href="#"
                              class="nav-link"
                              onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                              style="color: white; font-weight: bold; transition: color 0.3s;">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    @endauth
                </ul>
            </div>
        </nav>
    </div>
</header>

<style>
    .nav-link:hover {
        color: #e63946;
        text-decoration: underline;
    }

    .fp__header {
        position: fixed;
        width: 100%;
        top: 0;
        z-index: 999;
        background-color: #8b0000;
    }

    body {
        padding-top: 130px; /* disesuaikan dengan tinggi logo + padding navbar */
    }

    @media (max-width: 768px) {
        body {
            padding-top: 90px;
        }

        .navbar-brand img {
            max-height: 70px;
            width: auto;
        }

        .fp__header .navbar {
            padding: 6px 0;
        }
    }

    @media (min-width: 769px) {
        .navbar-brand img {
            max-height: 110px;
            width: auto;
        }
    }
</style>
