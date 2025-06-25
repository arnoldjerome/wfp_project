<header class="fp__header" style="background-color: #8b0000; color: white;">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" height="40">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link" style="color: white; font-weight: bold; transition: color 0.3s;">
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
                </ul>
            </div>
        </nav>
    </div>
</header>

<style>
    /* Hover effect for navbar links */
    .nav-link:hover {
        color: #e63946;  /* Bright red color for hover */
        text-decoration: underline;
    }

    /* Navbar background color */
    .fp__header {
        position: fixed;
        width: 100%;
        top: 0;
        z-index: 999;
        background-color: #1c1c1c; /* Dark gray for the header */
    }

    .fp__header .navbar {
        padding: 15px 0;
    }
</style>
