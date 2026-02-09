<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') | PhysioCare</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap");

        :root {
            --primary: #6387c2;
            --primary-light: #8aabdf;
            --primary-dark: #4a6aa8;
            --secondary: #ffa726;
            --secondary-light: #ffd95b;
            --success: #66bb6a;
            --success-light: #9be7a1;
            --warning: #ffb74d;
            --danger: #ef5350;
            --info: #42a5f5;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
            --sidebar-bg: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            --sidebar-shadow: 5px 0 25px rgba(99, 135, 194, 0.08);
            --card-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --blue-hover: #72a0c140;
            --dark-blue: #26599f;
            --grey-bg: #54545429;
            --grey-txt: #545454;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #f6f9ff 0%, #edf2f7 100%);
            display: flex;
            min-height: 100vh;
            color: var(--gray-800);
            overflow-x: hidden;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: var(--sidebar-bg);
            border-right: 1px solid var(--gray-200);
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            left: 0;
            top: 0;
            overflow-y: auto;
            overflow-x: hidden;
            box-shadow: var(--sidebar-shadow);
            z-index: 1000;
            transition: var(--transition);
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: var(--gray-100);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: var(--primary-light);
            border-radius: 3px;
        }

        .logo-section {
            padding: 35px 25px;
            position: relative;
            overflow: hidden;
        }

        .logo-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 10px;
            height: 100%;
        }

        .logo {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
        }

        .logo img {
            max-width: 250px;
            height: auto;
            filter: drop-shadow(0 4px 12px rgba(99, 135, 194, 0.15));
            transition: var(--transition);
        }

        .logo:hover img {
            transform: scale(1.03);
        }

        .logo-text {
            font-family: 'Poppins', sans-serif;
            font-size: 1.8rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.5px;
        }

        .tagline {
            font-size: 0.85rem;
            color: var(--gray-500);
            font-weight: 500;
            text-align: center;
            margin-top: -5px;
        }

        .sidebar nav {
            flex: 1;
            padding: 25px 0;
        }

        .sidebar ul {
            list-style: none;
            padding: 0 15px;
        }

        .sidebar nav > ul > li {
            margin-bottom: 8px;
            position: relative;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px 20px;
            color: var(--gray-700);
            text-decoration: none;
            border-radius: 12px;
            transition: var(--transition);
            font-size: 0.95rem;
            font-weight: 500;
            position: relative;
            overflow: hidden;
            border: 1px solid transparent;
        }

        .sidebar a::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 0;
            background: linear-gradient(90deg, rgba(99, 135, 194, 0.1) 0%, rgba(255, 255, 255, 0) 100%);
            transition: var(--transition);
        }

        .sidebar a:hover {
            background: linear-gradient(90deg, rgba(99, 135, 194, 0.05) 0%, rgba(255, 255, 255, 0) 100%);
            color: var(--primary-dark);
            transform: translateX(5px);
            border-color: var(--gray-200);
        }

        .sidebar a:hover::before {
            width: 100%;
        }

        .sidebar a.active {
            background: linear-gradient(135deg, rgba(99, 135, 194, 0.12) 0%, rgba(99, 135, 194, 0.05) 100%);
            border: 1px solid var(--primary-light);
            color: var(--primary-dark);
            box-shadow: 0 5px 15px rgba(99, 135, 194, 0.1);
            transform: translateX(5px);
        }

        .sidebar a.active::after {
            content: '';
            position: absolute;
            right: -1px;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 60%;
            background: linear-gradient(180deg, var(--primary), var(--primary-dark));
            border-radius: 4px 0 0 4px;
        }

        .sidebar a i {
            font-size: 1.25rem;
            width: 24px;
            text-align: center;
            color: var(--gray-600);
            transition: var(--transition);
        }

        .sidebar a:hover i,
        .sidebar a.active i {
            color: var(--primary);
            transform: scale(1.1);
        }

        .sidebar a span {
            flex: 1;
            transition: var(--transition);
        }

        .badge {
            background: var(--primary);
            color: white;
            font-size: 0.7rem;
            padding: 3px 8px;
            border-radius: 12px;
            margin-left: auto;
            font-weight: 600;
        }

        .bottom-menu {
            border-top: 1px solid var(--gray-200);
            padding: 20px 15px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.9) 0%, rgba(248, 250, 252, 0.9) 100%);
            backdrop-filter: blur(10px);
        }

        .bottom-menu li {
            margin-bottom: 8px;
        }

        .bottom-menu a {
            color: var(--gray-600);
        }

        .bottom-menu a:hover {
            background: rgba(239, 83, 80, 0.05);
            color: var(--danger);
        }

        .bottom-menu a.logout:hover {
            background: linear-gradient(90deg, rgba(239, 83, 80, 0.1) 0%, rgba(255, 255, 255, 0) 100%);
            border-color: rgba(239, 83, 80, 0.2);
        }

        .main-content {
            flex: 1;
            margin-left: 280px;
            width: calc(100% - 280px);
            min-height: 100vh;
            transition: var(--transition);
            background: var(--grey-bg);
            padding-top: 120px;
        }

        .header-title {
            display: flex;
            justify-content: flex-end;
            background: white;
            padding: 25px 50px;
            border-bottom: 2px solid var(--gray-200);
            position: fixed;
            top: 0;
            left: 280px;
            right: 0;
            height: 100px;
            z-index: 999;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: var(--transition);
        }

        .header-group {
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .admin-text {
            font-family: "Great Vibes", cursive;
            font-size: 40px;
            font-weight: 600;
            color: var(--dark-blue);
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .admin-text i {
            font-size: 24px;
            color: var(--gray-500);
            transition: var(--transition);
        }

        .admin-text:hover i {
            color: var(--dark-blue);
            transform: rotate(180deg);
        }

        .notification-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .header-icon {
            width: 55px;
            height: 55px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid var(--gray-200);
            cursor: pointer;
            transition: var(--transition);
            position: relative;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            text-decoration: none;
        }

        .header-icon:hover {
            background: var(--primary-light);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(99, 135, 194, 0.2);
            border-color: var(--primary);
        }

        .header-icon:hover i {
            color: white;
        }

        .header-icon i {
            font-size: 26px;
            color: var(--grey-txt);
            transition: var(--transition);
        }

        #notificationCount {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: var(--danger);
            color: white;
            border-radius: 50%;
            padding: 4px 8px;
            font-size: 12px;
            font-weight: 600;
            min-width: 22px;
            height: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid white;
        }

        .notification-dropdown {
            position: absolute;
            top: 65px;
            right: 0;
            width: 350px;
            background: white;
            border: 1px solid var(--gray-200);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            display: none;
        }

        .notification-dropdown h4 {
            font-family: 'Poppins', sans-serif;
            font-size: 18px;
            margin-bottom: 15px;
            color: var(--gray-800);
            border-bottom: 1px solid var(--gray-200);
            padding-bottom: 10px;
        }

        .notification-dropdown ul {
            list-style: none;
            margin: 0;
            padding: 0;
            max-height: 300px;
            overflow-y: auto;
        }

        .notification-dropdown li {
            padding: 12px 15px;
            border-bottom: 1px solid var(--gray-100);
            font-size: 14px;
            color: var(--gray-700);
            transition: var(--transition);
            cursor: pointer;
        }

        .notification-dropdown li:hover {
            background: var(--gray-50);
            border-radius: 6px;
        }

        .notification-dropdown li:last-child {
            border-bottom: none;
        }

        .content-wrapper {
            padding: 0 50px 40px 50px;
            overflow-y: auto;
            max-height: calc(100vh - 120px);
        }

        .page-content {
            background: white;
            padding: 40px;
            border-radius: 25px;
            box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
            min-height: calc(100vh - 220px);
        }

        .alert {
            padding: 20px 25px;
            border-radius: 15px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 15px;
            backdrop-filter: blur(10px);
            border: 1px solid transparent;
            animation: slideIn 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success {
            background: linear-gradient(135deg, rgba(102, 187, 106, 0.1) 0%, rgba(255, 255, 255, 0.9) 100%);
            border-color: rgba(102, 187, 106, 0.3);
            color: var(--gray-800);
        }

        .alert-error {
            background: linear-gradient(135deg, rgba(239, 83, 80, 0.1) 0%, rgba(255, 255, 255, 0.9) 100%);
            border-color: rgba(239, 83, 80, 0.3);
            color: var(--gray-800);
        }

        .alert i {
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .alert-success i {
            color: var(--success);
        }

        .alert-error i {
            color: var(--danger);
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .sidebar {
                width: 80px;
                transition: var(--transition);
            }

            .sidebar:hover {
                width: 280px;
            }

            .sidebar:hover .logo-text,
            .sidebar:hover .tagline,
            .sidebar:hover a span,
            .sidebar:hover .badge {
                display: block;
                opacity: 1;
            }

            .logo-text,
            .tagline,
            .sidebar a span,
            .badge {
                display: none;
                opacity: 0;
                transition: opacity 0.3s ease;
            }

            .logo img {
                max-width: 50px;
            }

            .main-content {
                margin-left: 80px;
                width: calc(100% - 80px);
                padding-top: 100px;
            }

            .header-title {
                left: 80px;
                height: 80px;
                padding: 20px 30px;
            }

            .sidebar:hover ~ .main-content {
                margin-left: 280px;
                width: calc(100% - 280px);
            }

            .sidebar:hover ~ .main-content .header-title {
                left: 280px;
            }

            .admin-text {
                font-size: 32px;
            }

            .header-icon {
                width: 45px;
                height: 45px;
            }

            .header-icon i {
                font-size: 22px;
            }

            .content-wrapper {
                padding: 0 30px 30px 30px;
            }

            .page-content {
                padding: 30px;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: 280px;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                width: 100%;
                padding-top: 90px;
            }

            .header-title {
                left: 0;
                padding: 15px 20px;
                height: 70px;
            }

            .menu-toggle {
                display: block;
                position: fixed;
                top: 20px;
                left: 20px;
                z-index: 1001;
            }

            .header-group {
                gap: 15px;
                width: 100%;
                justify-content: flex-end;
            }

            .admin-text {
                font-size: 28px;
                display: none;
            }

            .header-icon {
                width: 40px;
                height: 40px;
            }

            .header-icon i {
                font-size: 20px;
            }

            .content-wrapper {
                padding: 0 20px 20px 20px;
            }

            .page-content {
                padding: 25px;
                min-height: calc(100vh - 160px);
            }

            .notification-dropdown {
                width: 300px;
                right: -50px;
            }
        }

        .menu-toggle {
            display: none;
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            box-shadow: 0 5px 15px rgba(99, 135, 194, 0.3);
            transition: var(--transition);
            z-index: 1002;
        }

        .menu-toggle:hover {
            transform: scale(1.05);
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .pulse {
            animation: pulse 2s infinite;
        }

        .blue-button {
            background-color: #26599F;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            font-weight: 500;
            transition: var(--transition);
        }

        .blue-button:hover {
            background-color: #1a4070;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(38, 89, 159, 0.3);
        }

        .content-wrapper::-webkit-scrollbar {
            width: 8px;
        }

        .content-wrapper::-webkit-scrollbar-track {
            background: var(--gray-100);
            border-radius: 4px;
        }

        .content-wrapper::-webkit-scrollbar-thumb {
            background: var(--gray-300);
            border-radius: 4px;
        }

        .content-wrapper::-webkit-scrollbar-thumb:hover {
            background: var(--gray-400);
        }

        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        .modal-overlay.hidden {
            display: none;
        }

        .delete-modal {
            background: #f3e1e1;
            padding: 40px;
            border-radius: 20px;
            width: 420px;
            text-align: center;
            position: relative;
            animation: pop .25s ease;
        }

        @keyframes pop {
            from { transform: scale(.95); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        .icon-circle {
            width: 70px;
            height: 70px;
            background: #b42318;
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .icon-circle i {
            color: white;
            font-size: 32px;
        }

        .modal-title {
            font-size: 22px;
            font-weight: 800;
            margin-bottom: 10px;
            color: #333;
            font-family: "Segoe UI", sans-serif;
        }

        .modal-text {
            color: #444;
            margin-bottom: 20px;
        }

        .confirm-check {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-bottom: 25px;
            font-size: 14px;
        }

        .modal-actions {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .btn-cancel {
            background: white;
            border: none;
            padding: 10px 22px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            color: #333;
        }

        .btn-delete {
            background: #d92d20;
            color: white;
            border: none;
            padding: 10px 22px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            opacity: .5;
        }

        .btn-delete:enabled {
            opacity: 1;
        }

        .close-btn {
            position: absolute;
            top: 15px;
            right: 18px;
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #888;
        }

        .modal-box {
            background: #ffffff;
            padding: 40px;
            border-radius: 20px;
            width: 420px;
            text-align: center;
            position: relative;
        }

        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .modal-icon {
            font-size: 60px;
            color: #ffc107;
            margin-bottom: 15px;
        }

        .modal-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }

        .modal-buttons .btn {
            padding: 10px 25px;
            border-radius: 10px;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            border: none;
        }

        .modal-buttons .cancel {
            background: #f0f0f0;
            color: #333;
        }

        .modal-buttons .submit {
            background: #4caf50;
            color: white;
        }
    </style>
    @stack('styles')
</head>
<body>
    <button class="menu-toggle" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>

    <div class="sidebar" id="sidebar">
        <div>
            <div class="logo-section">
                <div class="logo">
                    <img src="{{ asset('images/physiocare-logo.png') }}" alt="PhysioCare Logo" 
                         onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 200 60%22%3E%3Ctext x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-family=%22Poppins%22 font-size=%2224%22 font-weight=%22bold%22 fill=%22%236387c2%22%3EPhysioCare%3C/text%3E%3C/svg%3E';" />
                </div>
            </div>
            <nav>
                <ul>
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="bi bi-clipboard2-data-fill"></i> <span>Dashboard</span> 
                            <span class="badge pulse" id="dashboardMenuBadge" style="display: none;">0</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.inventory.dashboard') }}" class="{{ request()->routeIs('admin.inventory.dashboard') ? 'active' : '' }}">
                            <i class="bi bi-archive"></i> <span>Manage Items</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.maintenance.index') }}" 
                           class="{{ in_array(request()->route()->getName(), ['admin.maintenance.index','admin.maintenance.view','admin.maintenance.edit']) ? 'active' : '' }}">
                            <i class="bi bi-journal-check"></i> <span>Maintenance</span>
                            <span class="badge" id="sidebarMaintenanceBadge" style="display: none;">0</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.manage.user') }}" class="{{ request()->routeIs('admin.manage.user') ? 'active' : '' }}">
                            <i class="bi bi-person-gear"></i> <span>Users</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.usage.dashboard') }}"                           
                            class="{{ in_array(request()->route()->getName(), 
                            ['admin.usage.dashboard','admin.usage.details']) ? 'active' : '' }}">

                            <i class="bi bi-bar-chart-line"></i><span>Monitor Usage</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.reports.dashboard') }}"                            
                            class="{{ in_array(request()->route()->getName(), ['admin.reports.dashboard','admin.reports.create','admin.reports.show']) ? 'active' : '' }}">
                            <i class="bi bi-graph-up-arrow"></i> <span>Reports</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        <ul class="bottom-menu">
            <li>
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" style="width: 100%; background: none; border: none; font-family: inherit; cursor: pointer; text-align: left; padding: 0;">
                        <a href="#" onclick="event.preventDefault(); this.closest('form').submit();" class="logout">
                            <i class="bi bi-box-arrow-left"></i> <span>Logout</span>
                        </a>
                    </button>
                </form>
            </li>
        </ul>
    </div>

    <div class="main-content">
        <header class="header-title">
            <div class="header-group">
                <span class="admin-text">
                    <span>Admin</span> <i class="fas fa-chevron-down"></i>
                </span>
                <div class="notification-wrapper">
                    <div class="header-icon" id="notificationBell">
                        <i class="far fa-bell"></i>
                        <span id="notificationCount" style="display: none;">0</span>
                    </div>
                    
                    <div class="notification-dropdown" id="notificationDropdown">
                        <h4>Notifications</h4>
                        <ul id="notificationList">
                            <li style="padding:15px; text-align:center; color:#666;">Loading...</li>
                        </ul>
                    </div>
                </div>
                <a href="{{ route('admin.manage.user') }}" class="header-icon">
                    <i class="far fa-user-circle"></i>
                </a>
            </div>
        </header>

        <div class="content-wrapper">
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> <div>{{ session('success') }}</div>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i> <div>{{ session('error') }}</div>
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i> 
                    <div>
                        @foreach($errors->all() as $error)
                            {{ $error }}<br>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="page-content">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
            updateHeaderPosition();
        }

        function updateHeaderPosition() {
            const sidebar = document.getElementById('sidebar');
            const header = document.querySelector('.header-title');
            const mainContent = document.querySelector('.main-content');
            
            if (window.innerWidth <= 768) {
                if (sidebar.classList.contains('active')) {
                    header.style.left = '280px';
                    mainContent.style.marginLeft = '280px';
                    mainContent.style.width = 'calc(100% - 280px)';
                } else {
                    header.style.left = '0';
                    mainContent.style.marginLeft = '0';
                    mainContent.style.width = '100%';
                }
            }
        }

        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.querySelector('.menu-toggle');
            if (window.innerWidth <= 768 && !sidebar.contains(event.target) && !toggleBtn.contains(event.target) && sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
                updateHeaderPosition();
            }
        });

        window.addEventListener('resize', updateHeaderPosition);

        // --- NOTIFICATION LOGIC ---
        document.addEventListener("DOMContentLoaded", function () {
            const notifBell = document.getElementById("notificationBell");
            const notifBadge = document.getElementById("notificationCount");
            const notifDropdown = document.getElementById("notificationDropdown");
            const notifList = document.getElementById("notificationList");
            const sidebarBadge = document.getElementById("sidebarMaintenanceBadge");
            const dashboardMenuBadge = document.getElementById("dashboardMenuBadge"); // New Element
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            if (!notifBell || !notifBadge || !notifList) return;

            function fetchNotifications() {
                fetch("/admin/api/maintenance/count")
                    .then(res => {
                        if (!res.ok) throw new Error("Network response was not ok");
                        return res.json();
                    })
                    .then(data => {
                        const count = data.newCount;
                        if (count > 0) {
                            notifBadge.textContent = count;
                            notifBadge.style.display = "flex";
                            
                            if(sidebarBadge) {
                                sidebarBadge.textContent = count;
                                sidebarBadge.style.display = "inline-block";
                            }

                            if(dashboardMenuBadge) {
                                dashboardMenuBadge.textContent = count;
                                dashboardMenuBadge.style.display = "inline-block";
                            }
                        } else {
                            notifBadge.style.display = "none";
                            if(sidebarBadge) sidebarBadge.style.display = "none";
                            if(dashboardMenuBadge) dashboardMenuBadge.style.display = "none";
                        }
                    })
                    .catch(err => console.log("Error fetching count:", err));

                fetch("/admin/api/maintenance/notifications")
                    .then(res => res.json())
                    .then(data => {
                        notifList.innerHTML = ""; 
                        if (data.length === 0) {
                            notifList.innerHTML = "<li style='padding:15px; text-align:center; color:#666;'>No new notifications</li>";
                        } else {
                            data.forEach(item => {
                                const li = document.createElement("li");
                                li.innerHTML = `
                                    <div style="font-weight:600; font-size:14px; color:#374151;">${item.submittedBy}</div>
                                    <div style="font-size:12px; color:#6b7280;">Request for ${item.itemName}</div>
                                    <div style="font-size:11px; color:#9ca3af; margin-top:2px;">${item.date}</div>
                                `;
                                li.onclick = function() {
                                    window.location.href = "/admin/maintenance/view/" + item.id;
                                };
                                notifList.appendChild(li);
                            });
                        }
                    })
                    .catch(err => console.log("Error fetching list:", err));
            }

            notifBell.addEventListener("click", function (e) {
                e.stopPropagation();
                const isHidden = window.getComputedStyle(notifDropdown).display === "none";
                
                if (isHidden) {
                    notifDropdown.style.display = "block";
                    fetch("/admin/api/maintenance/mark-read", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": csrfToken,
                            "Content-Type": "application/json"
                        }
                    }).then(() => {
                        notifBadge.style.display = "none";
                        if(sidebarBadge) sidebarBadge.style.display = "none";
                        if(dashboardMenuBadge) dashboardMenuBadge.style.display = "none"; // Hide dashboard badge too
                    });
                } else {
                    notifDropdown.style.display = "none";
                }
            });

            window.addEventListener("click", function (e) {
                if (!notifBell.contains(e.target) && !notifDropdown.contains(e.target)) {
                    notifDropdown.style.display = "none";
                }
            });

            fetchNotifications();
            setInterval(fetchNotifications, 30000);
        });
    </script>
</body>
</html>