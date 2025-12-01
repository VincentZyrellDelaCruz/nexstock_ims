<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'NexStack - Inventory Management System')</title>

    <!-- Montserrat Font -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <!-- Custom CSS -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    @yield('styles')
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <nav class="sidebar">
                <div class="sidebar-header">
                    @if(Auth::check())
                        <a href="{{ route('dashboard') }}">
                            <img src="{{ asset('images/Logo.png') }}" alt="NexStock" class="site-logo">
                        </a>
                    @else
                        <a href="{{ url('/') }}">
                            <img src="{{ asset('images/Logo.png') }}" alt="NexStock" class="site-logo">
                        </a>
                    @endif
                </div>
            <ul class="nav-menu">
                <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('inventory.*') ? 'active' : '' }}">
                    <a href="{{ route('inventory.index') }}" class="nav-link">
                        <i class="bi bi-box-seam"></i>
                        <span>Inventory</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('products.*') ? 'active' : '' }}">
                    <a href="{{ route('products.index') }}" class="nav-link">
                        <i class="bi bi-box"></i>
                        <span>Products</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                    <a href="{{ route('categories.index') }}" class="nav-link">
                        <i class="bi bi-tags"></i>
                        <span>Category</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('suppliers.*') ? 'active' : '' }}">
                    <a href="{{ route('suppliers.index') }}" class="nav-link">
                        <i class="bi bi-people"></i>
                        <span>Suppliers</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('transactions.*') ? 'active' : '' }}">
                    <a href="{{ route('transactions.index') }}" class="nav-link">
                        <i class="bi bi-arrow-left-right"></i>
                        <span>Transactions</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                    <a href="{{ route('reports.index') }}" class="nav-link">
                        <i class="bi bi-file-earmark-text"></i>
                        <span>Reports</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('admin.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.index') }}" class="nav-link">
                        <i class="bi bi-gear"></i>
                        <span>Admin Settings</span>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <header class="header">
                <div class="header-left">
                    <h2 class="page-title">@yield('page-title', 'DASHBOARD')</h2>
                </div>
                <div class="header-right">
                    <i class="bi bi-search search-icon"></i>
                    <i class="bi bi-bell notification-icon"></i>
                    <div class="user-profile">
                        <i class="bi bi-person-circle"></i>
                        <span>{{ Auth::check() ? Auth::user()->name : 'Guest' }}</span>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-link text-white logout-btn">Logout</button>
                    </form>
                </div>
            </header>

            <!-- Page Content -->
            <main class="content-area">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(isset($errors) && $errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>

