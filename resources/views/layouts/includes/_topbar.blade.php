<nav class="topnav navbar navbar-expand justify-content-between justify-content-sm-start navbar-light bg-white shadow"
    id="sidenavAccordion">
    <!-- Sidenav Toggle Button-->
    <button class="btn btn-icon btn-transparent-dark order-lg-0 ms-lg-2 me-lg-0 order-1 me-2" id="sidebarToggle"><i
            data-feather="menu"></i></button>
    <!-- Navbar Brand-->
    <!-- * * Tip * * You can use text or an image for your navbar brand.-->
    <!-- * * * * * * When using an image, we recommend the SVG format.-->
    <!-- * * * * * * Dimensions: Maximum height: 32px, maximum width: 240px-->
    <div class="preloader flex-column justify-content-center align-items-center ms-2">
        <a id="navbarDropdownUserImage" href="##"><img class="animation__shake"
                src="{{ asset('assets/img/topbar.png') }}" alt="MKM Logo" height="40%" width="40%"> </a>
    </div>
    <h1 style="margin-left: -160px">
        <title>ITFAMS | Digital IT & Facility Asset Management System</title>
    </h1>

    <!-- Navbar Items-->
    <ul class="navbar-nav align-items-center ms-auto">
        <!-- Navbar Search Dropdown-->
        <!-- User Dropdown-->
        <li class="nav-item dropdown no-caret dropdown-user me-lg-4 me-3">
            <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownUserImage"
                href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false"><img class="img-fluid"
                    src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('assets/img/illustrations/profiles/profile-1.png') }}" /></a>
            <div class="dropdown-menu dropdown-menu-end animated--fade-in-up border-0 shadow"
                aria-labelledby="navbarDropdownUserImage">
                <h6 class="dropdown-header d-flex align-items-center">
                    <img class="dropdown-user-img"
                        src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('assets/img/illustrations/profiles/profile-1.png') }}" />
                    <div class="dropdown-user-details">
                        <div class="dropdown-user-details-name">{{ auth()->user()->name }} {{auth()->user()->avatar}}</div>
                        <div class="dropdown-user-details-email">{{ auth()->user()->email }}</div>
                    </div>
                </h6>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                    data-bs-target="#changePasswordModal">
                    <div class="dropdown-item-icon"><i data-feather="key"></i></div>
                    Change Password
                </a>
                <a class="dropdown-item" href="{{ url('/logout') }}">
                    <div class="dropdown-item-icon"><i data-feather="log-out"></i></div>
                    Logout
                </a>
            </div>
        </li>
    </ul>
</nav>
