<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>කැදැල්ල Distributors - PDMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Poppins', sans-serif; box-sizing: border-box; }
        body { background-color: #f0f4f8; margin: 0; }

        /* ── SIDEBAR ── */
        .sidebar {
            height: 100vh;
            background: linear-gradient(180deg, #0a1628 0%, #0f2744 40%, #1a3c5e 80%, #2d6a9f 100%);
            width: 240px;
            position: fixed;
            top: 0; left: 0;
            z-index: 100;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            overflow-x: hidden;
        }

        /* Brand */
        .sidebar-brand {
            padding: 22px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            display: flex;
            align-items: center;
            gap: 13px;
            flex-shrink: 0;
        }
        .kd-logo-sidebar {
            width: 44px; height: 44px;
            background: rgba(240,192,64,0.15);
            border: 1.5px solid rgba(240,192,64,0.35);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .kd-logo-sidebar span {
            font-size: 16px;
            font-weight: 700;
            color: #f0c040;
            letter-spacing: -1px;
        }
        .brand-text .sinhala {
            color: #f0c040;
            font-size: 14px;
            font-weight: 700;
            display: block;
            line-height: 1.3;
        }
        .brand-text .english {
            color: rgba(255,255,255,0.4);
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        /* Section Labels */
        .sidebar-section-label {
            color: rgba(255,255,255,0.3);
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1.8px;
            padding: 18px 20px 6px;
            flex-shrink: 0;
        }

        /* Nav Links */
        .sidebar a {
            color: rgba(255,255,255,0.65);
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 11px 20px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.2s;
            border-left: 3px solid transparent;
            position: relative;
        }
        .sidebar a:hover {
            background: rgba(255,255,255,0.07);
            color: white;
            border-left-color: rgba(240,192,64,0.4);
        }
        .sidebar a.active {
            background: rgba(255,255,255,0.11);
            color: white;
            border-left-color: #f0c040;
        }
        .sidebar a i {
            width: 18px;
            text-align: center;
            font-size: 13px;
            flex-shrink: 0;
        }

        .sidebar-divider {
            border-top: 1px solid rgba(255,255,255,0.07);
            margin: 5px 15px;
            flex-shrink: 0;
        }

        /* Notification badge in sidebar */
        .sidebar-notif-badge {
            margin-left: auto;
            background: #e74c3c;
            color: white;
            font-size: 10px;
            padding: 2px 7px;
            border-radius: 10px;
            font-weight: 600;
        }

        /* Logout Button at bottom */
        .sidebar-bottom {
            margin-top: auto;
            flex-shrink: 0;
        }

        /* User Card above logout */
        .sidebar-user {
            margin: 12px 12px 0;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px;
            padding: 12px 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .sidebar-user-avatar {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, #f0c040, #e67e22);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 14px;
            font-weight: 700;
            flex-shrink: 0;
        }
        .sidebar-user-name {
            color: white;
            font-size: 12px;
            font-weight: 600;
            line-height: 1.3;
        }
        .sidebar-user-role {
            color: rgba(255,255,255,0.45);
            font-size: 10px;
        }

        /* Logout */
        .sidebar-logout {
            padding: 12px;
        }
        .logout-btn {
            width: 100%;
            background: rgba(231,76,60,0.12);
            border: 1px solid rgba(231,76,60,0.25);
            color: rgba(255,255,255,0.65);
            padding: 11px 15px;
            border-radius: 12px;
            font-size: 13px;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.25s;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .logout-btn:hover {
            background: rgba(231,76,60,0.25);
            border-color: rgba(231,76,60,0.4);
            color: #ff6b6b;
        }
        .logout-btn i { font-size: 14px; }

        /* ── MAIN CONTENT ── */
        .main-content {
            margin-left: 255px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Topbar */
        .topbar {
            background: white;
            padding: 0 28px;
            height: 62px;
            box-shadow: 0 1px 0 #e8edf2, 0 2px 8px rgba(0,0,0,0.04);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 99;
            flex-shrink: 0;
        }

        .topbar-left { display: flex; align-items: center; gap: 12px; }

        .admin-badge {
            background: #eef4fb;
            color: #2d6a9f;
            font-size: 10px;
            padding: 4px 11px;
            border-radius: 20px;
            font-weight: 600;
            border: 1px solid #c8dff0;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .topbar-divider {
            width: 1px;
            height: 20px;
            background: #e2e8f0;
        }

        .topbar-title {
            font-size: 15px;
            font-weight: 700;
            color: #0f2744;
        }

        .topbar-right { display: flex; align-items: center; gap: 10px; }

        /* Icon Buttons in topbar */
        .topbar-icon-btn {
            position: relative;
            width: 38px; height: 38px;
            background: #f8fafc;
            border: 1px solid #e8edf2;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            text-decoration: none;
            transition: all 0.2s;
            cursor: pointer;
        }
        .topbar-icon-btn:hover {
            background: #f1f5f9;
            color: #0f2744;
            border-color: #cbd5e1;
        }
        .topbar-notif-badge {
            position: absolute;
            top: -5px; right: -5px;
            width: 18px; height: 18px;
            background: #e74c3c;
            border-radius: 50%;
            font-size: 10px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            border: 2px solid white;
        }

        /* User dropdown */
        .topbar-user {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 12px 6px 6px;
            background: #f8fafc;
            border: 1px solid #e8edf2;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
        }
        .topbar-user:hover { background: #f1f5f9; border-color: #cbd5e1; }

        .topbar-avatar {
            width: 32px; height: 32px;
            background: linear-gradient(135deg, #0f2744, #2d6a9f);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 13px;
            font-weight: 700;
        }
        .topbar-user-name { font-size: 13px; font-weight: 600; color: #0f2744; }
        .topbar-user-role { font-size: 10px; color: #94a3b8; }

        /* Dropdown menu */
        .user-dropdown {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            width: 200px;
            background: white;
            border: 1px solid #e8edf2;
            border-radius: 14px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.12);
            padding: 8px;
            display: none;
            z-index: 200;
        }
        .user-dropdown.show { display: block; }
        .dropdown-item-custom {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 10px;
            font-size: 13px;
            color: #334155;
            text-decoration: none;
            transition: all 0.2s;
            font-weight: 500;
        }
        .dropdown-item-custom:hover { background: #f8fafc; color: #0f2744; }
        .dropdown-item-custom i { width: 16px; text-align: center; color: #94a3b8; font-size: 13px; }
        .dropdown-item-custom:hover i { color: #2d6a9f; }
        .dropdown-divider-custom { border-top: 1px solid #f1f5f9; margin: 5px 0; }
        .dropdown-item-custom.logout-item { color: #e74c3c; }
        .dropdown-item-custom.logout-item i { color: #e74c3c; }
        .dropdown-item-custom.logout-item:hover { background: #fff5f5; }

        /* Content Area */
        .content-area { padding: 24px 28px; flex: 1; }

        /* Cards */
        .card {
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
            border-radius: 14px;
        }
        .card-header {
            border-radius: 14px 14px 0 0 !important;
            font-weight: 600;
            font-size: 14px;
            padding: 15px 20px;
            border-bottom: 1px solid #f1f5f9;
            background: white;
            color: #0f2744;
        }

        /* Alerts */
        .alert { border-radius: 12px; font-size: 13px; border: none; }
        .alert-success { background: #f0fdf4; color: #166534; }
        .alert-danger { background: #fff5f5; color: #dc2626; }

        /* Table */
        .table th {
            font-size: 11px;
            font-weight: 600;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            border-bottom: 1px solid #f1f5f9;
            padding: 12px 16px;
            background: #fafbfc;
        }
        .table td {
            font-size: 13px;
            vertical-align: middle;
            padding: 12px 16px;
            border-bottom: 1px solid #f8fafc;
            color: #334155;
        }
        .table tbody tr:last-child td { border-bottom: none; }
        .table tbody tr:hover td { background: #fafbfd; }

        /* Buttons */
        .btn-primary { background: #1a3c5e; border-color: #1a3c5e; font-size: 13px; border-radius: 10px; font-family: 'Poppins', sans-serif; }
        .btn-primary:hover { background: #2d6a9f; border-color: #2d6a9f; }
        .btn-secondary { font-size: 13px; border-radius: 10px; font-family: 'Poppins', sans-serif; }
        .btn-warning { font-size: 13px; border-radius: 10px; font-family: 'Poppins', sans-serif; }
        .btn-danger { font-size: 13px; border-radius: 10px; font-family: 'Poppins', sans-serif; }
        .btn-success { font-size: 13px; border-radius: 10px; font-family: 'Poppins', sans-serif; }
        .btn-sm { font-size: 12px; padding: 5px 12px; }

        /* Form controls */
        .form-control, .form-select {
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-size: 13px;
            font-family: 'Poppins', sans-serif;
            padding: 10px 14px;
            color: #334155;
            transition: all 0.2s;
        }
        .form-control:focus, .form-select:focus {
            border-color: #2d6a9f;
            box-shadow: 0 0 0 3px rgba(45,106,159,0.1);
        }
        .form-label {
            font-size: 12px;
            font-weight: 600;
            color: #475569;
            margin-bottom: 6px;
        }

        /* Badge */
        .badge { font-size: 11px; padding: 4px 10px; border-radius: 6px; font-weight: 500; }

        /* Scrollbar */
        .sidebar::-webkit-scrollbar { width: 4px; }
        .sidebar::-webkit-scrollbar-track { background: transparent; }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.15); border-radius: 2px; }
    </style>
</head>
<body>

<!-- ── SIDEBAR ── -->
<div class="sidebar">

    <!-- Brand -->
    <div class="sidebar-brand">
        <div class="kd-logo-sidebar"><span>KD</span></div>
        <div class="brand-text">
            <span class="sinhala">කැදැල්ල</span>
            <span class="english">Admin Panel · PDMS</span>
        </div>
    </div>

    <!-- Main -->
    <div class="sidebar-section-label">Main</div>
    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="fas fa-tachometer-alt"></i> Dashboard
    </a>

    <!-- Inventory -->
    <div class="sidebar-divider"></div>
    <div class="sidebar-section-label">Inventory</div>
    <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">
        <i class="fas fa-box"></i> Products
    </a>

    <!-- Operations -->
    <div class="sidebar-divider"></div>
    <div class="sidebar-section-label">Operations</div>
    <a href="{{ route('shops.index') }}" class="{{ request()->routeIs('shops.*') ? 'active' : '' }}">
        <i class="fas fa-store"></i> Shops
    </a>
    <a href="{{ route('orders.index') }}" class="{{ request()->routeIs('orders.*') ? 'active' : '' }}">
        <i class="fas fa-clipboard-list"></i> Orders
    </a>
    <a href="{{ route('deliveries.index') }}" class="{{ request()->routeIs('deliveries.*') ? 'active' : '' }}">
        <i class="fas fa-truck"></i> Deliveries
    </a>
    <a href="{{ route('invoices.index') }}" class="{{ request()->routeIs('invoices.*') ? 'active' : '' }}">
        <i class="fas fa-file-invoice-dollar"></i> Invoices
    </a>

    <!-- Reports -->
    <div class="sidebar-divider"></div>
    <div class="sidebar-section-label">Reports</div>
    <a href="{{ route('reports.stock') }}" class="{{ request()->routeIs('reports.stock') ? 'active' : '' }}">
        <i class="fas fa-boxes"></i> Stock Report
    </a>
    <a href="{{ route('reports.orders') }}" class="{{ request()->routeIs('reports.orders') ? 'active' : '' }}">
        <i class="fas fa-chart-bar"></i> Orders Report
    </a>
    <a href="{{ route('reports.payments') }}" class="{{ request()->routeIs('reports.payments') ? 'active' : '' }}">
        <i class="fas fa-coins"></i> Payment Report
    </a>
    <a href="{{ route('reports.deliveries') }}" class="{{ request()->routeIs('reports.deliveries') ? 'active' : '' }}">
        <i class="fas fa-shipping-fast"></i> Delivery Report
    </a>
    <a href="{{ route('reports.salesrep') }}" class="{{ request()->routeIs('reports.salesrep') ? 'active' : '' }}">
        <i class="fas fa-user-tie"></i> Sales Rep Report
    </a>

    <!-- System -->
    <div class="sidebar-divider"></div>
    <div class="sidebar-section-label">System</div>
    <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
        <i class="fas fa-users"></i> Sales Reps
    </a>
    <a href="{{ route('notifications.index') }}" class="{{ request()->routeIs('notifications.*') ? 'active' : '' }}">
        <i class="fas fa-bell"></i> Notifications
        @if(isset($notificationCount) && $notificationCount > 0)
            <span class="sidebar-notif-badge">{{ $notificationCount }}</span>
        @endif
    </a>
    <a href="{{ route('activity.log') }}" class="{{ request()->routeIs('activity.log') ? 'active' : '' }}">
        <i class="fas fa-history"></i> Activity Log
    </a>
    <a href="{{ route('profile.index') }}" class="{{ request()->routeIs('profile.*') ? 'active' : '' }}">
        <i class="fas fa-user-cog"></i> My Profile
    </a>

    <!-- Bottom: User Card + Logout -->
    <div class="sidebar-bottom">
        <!-- User Card -->
        <div class="sidebar-user">
            <div class="sidebar-user-avatar">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div>
                <div class="sidebar-user-name">{{ Auth::user()->name }}</div>
                <div class="sidebar-user-role">Administrator</div>
            </div>
        </div>

        <!-- Logout -->
        <div class="sidebar-logout">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>

</div>

<!-- ── MAIN CONTENT ── -->
<div class="main-content">

    <!-- Topbar -->
    <div class="topbar">
        <div class="topbar-left">
            <span class="admin-badge">
                <i class="fas fa-shield-alt"></i> Administrator
            </span>
            <div class="topbar-divider"></div>
            <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
        </div>

        <div class="topbar-right">
            <!-- Notification Bell -->
            <a href="{{ route('notifications.index') }}" class="topbar-icon-btn">
                <i class="fas fa-bell" style="font-size:15px;"></i>
                @if(isset($notificationCount) && $notificationCount > 0)
                    <span class="topbar-notif-badge">{{ $notificationCount }}</span>
                @endif
            </a>

            <!-- User Dropdown -->
            <div class="topbar-user" id="userDropdownToggle">
                <div class="topbar-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <div class="topbar-user-name">{{ Auth::user()->name }}</div>
                    <div class="topbar-user-role">Administrator</div>
                </div>
                <i class="fas fa-chevron-down ms-2" style="font-size:10px; color:#94a3b8;"></i>

                <!-- Dropdown -->
                <div class="user-dropdown" id="userDropdown">
                    <a href="{{ route('profile.index') }}" class="dropdown-item-custom">
                        <i class="fas fa-user-cog"></i> My Profile
                    </a>
                    <a href="{{ route('activity.log') }}" class="dropdown-item-custom">
                        <i class="fas fa-history"></i> Activity Log
                    </a>
                    <div class="dropdown-divider-custom"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item-custom logout-item w-100 border-0 bg-transparent text-start">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="content-area">

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-3">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // User dropdown toggle
    const toggle = document.getElementById('userDropdownToggle');
    const dropdown = document.getElementById('userDropdown');

    toggle.addEventListener('click', function(e) {
        e.stopPropagation();
        dropdown.classList.toggle('show');
    });

    document.addEventListener('click', function() {
        dropdown.classList.remove('show');
    });
</script>

@yield('scripts')
</body>
</html>