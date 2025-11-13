<!DOCTYPE html>
<html lang="id" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'Menu Lezatku') }}</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <style>
        body {
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        
        [data-bs-theme="light"] body {
            background-color: #f8f9fa;
        }
        
        [data-bs-theme="dark"] body {
            background-color: #212529;
        }
        
        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
        }
        
        .theme-toggle {
            cursor: pointer;
            font-size: 1.2rem;
            padding: 0.5rem;
            border-radius: 50%;
            transition: background-color 0.3s ease;
        }
        
        .theme-toggle:hover {
            background-color: rgba(255,255,255,0.1);
        }
        
        .card {
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }
        
        [data-bs-theme="dark"] .table {
            --bs-table-bg: transparent;
        }

        [data-bs-theme="dark"] .form-control,
        [data-bs-theme="dark"] .form-select {
            background-color: #2b3035;
            border-color: #495057;
            color: #fff;
        }
        
        [data-bs-theme="dark"] .form-control:focus,
        [data-bs-theme="dark"] .form-select:focus {
            background-color: #2b3035;
            border-color: #86b7fe;
            color: #fff;
        }

        [data-bs-theme="light"] .table thead.table-light th {
            background-color: #e9ecef;
            color: #212529;
            border-color: #dee2e6;
            font-weight: 600;
        }

        [data-bs-theme="dark"] .table thead.table-light th {
            background-color: #2b3035;
            color: #fff;
            border-color: #495057;
        }

        .pagination {
            gap: 0.5rem;
            margin-top: 2rem;
        }

        .pagination .page-link {
            padding: 0.6rem 0.85rem;
            border-radius: 8px;
            border: 2px solid #dee2e6;
            font-weight: 500;
            transition: all 0.3s ease;
            color: #495057;
            background-color: transparent;
        }

        .pagination .page-link:hover:not(.disabled) {
            border-color: #0d6efd;
            color: #0d6efd;
            background-color: rgba(13, 110, 253, 0.1);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(13, 110, 253, 0.2);
        }

        .pagination .page-item.active .page-link {
            background-color: #0d6efd;
            border-color: #0d6efd;
            color: #fff;
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.4);
        }

        .pagination .page-item.disabled .page-link {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .pagination .page-link i {
            font-size: 0.9rem;
            margin-left: 8px;
            margin-right: 8px;
        }

        [data-bs-theme="dark"] .pagination .page-link {
            border-color: #495057;
            color: #adb5bd;
            background-color: transparent;
        }

        [data-bs-theme="dark"] .pagination .page-link:hover:not(.disabled) {
            border-color: #0d6efd;
            color: #0d6efd;
            background-color: rgba(13, 110, 253, 0.15);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ route('menus.index') }}">
                <i class="fa-solid fa-store"></i> Menu Lezatku
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('menus.index') ? 'active' : '' }}" 
                           href="{{ route('menus.index') }}">
                            <i class="fa-solid fa-list-ul"></i> Daftar Menu
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('menus.create') ? 'active' : '' }}" 
                           href="{{ route('menus.create') }}">
                            <i class="fa-solid fa-plus-circle"></i> Tambah Menu
                        </a>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link theme-toggle" id="themeToggle" title="Toggle Dark Mode">
                            <i class="fa-solid fa-moon" id="themeIcon"></i>
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-4">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-light text-center py-3 mt-5">
        <div class="container">
            <p class="text-muted mb-0">
                &copy; {{ date('Y') }} Menu Lezatku. All rights reserved.
            </p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Dark Mode Script -->
    <script>
        const htmlElement = document.documentElement;
        const themeToggle = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('themeIcon');
        const footer = document.querySelector('footer');

        const currentTheme = localStorage.getItem('theme') || 'light';
        setTheme(currentTheme);

        themeToggle.addEventListener('click', function() {
            const newTheme = htmlElement.getAttribute('data-bs-theme') === 'light' ? 'dark' : 'light';
            setTheme(newTheme);
            localStorage.setItem('theme', newTheme);
        });

        function setTheme(theme) {
            htmlElement.setAttribute('data-bs-theme', theme);
            
            if (theme === 'dark') {
                themeIcon.className = 'fa-solid fa-sun';
                themeToggle.title = 'Switch to Light Mode';
                footer.classList.remove('bg-light', 'text-muted');
                footer.classList.add('bg-dark', 'text-light');
                footer.querySelector('p').classList.remove('text-muted');
                footer.querySelector('p').classList.add('text-light');
            } else {
                themeIcon.className = 'fa-solid fa-moon';
                themeToggle.title = 'Switch to Dark Mode';
                footer.classList.remove('bg-dark', 'text-light');
                footer.classList.add('bg-light');
                footer.querySelector('p').classList.remove('text-light');
                footer.querySelector('p').classList.add('text-muted');
            }
        }
    </script>
</body>
</html>