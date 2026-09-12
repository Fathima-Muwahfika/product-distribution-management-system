<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>කැදැල්ල Distributors - Sales Rep</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Poppins', sans-serif; }
        body { background-color: #f0f4f8; }

        .sidebar {
        height: 100vh;
        background: linear-gradient(180deg, #0a1628 0%, #0f2744 50%, #1a3c5e 100%);
        width: 240px;
        position: fixed;
        top: 0; left: 0;
        z-index: 100;
        display: flex;
        flex-direction: column;
        overflow-y: auto;
        overflow-x: hidden;
        scrollbar-width: none;
        }
        .sidebar::-webkit-scrollbar { display: none; }
        .sidebar-brand {
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.15);
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .kd-logo-sidebar {
            width: 42px; height: 42px;
            background: rgba(240,192,64,0.15);
            border: 1.5px solid rgba(240,192,64,0.35);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .kd-logo-sidebar span { font-size: 15px; font-weight: 700; color: #f0c040; letter-spacing: -1px; }
        .brand-text .sinhala { color: white; font-size: 14px; font-weight: 700; display: block; }
        .brand-text .english { color: rgba(255,255,255,0.6); font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; }

        .sidebar-section-label {
            color: rgba(255,255,255,0.5);
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            padding: 16px 20px 5px;
        }
        .sidebar a {
            color: rgba(255,255,255,0.8);
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 11px 20px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }
        .sidebar a:hover { background: rgba(255,255,255,0.12); color: white; border-left-color: rgba(255,255,255,0.5); }
        .sidebar a.active { background: rgba(255,255,255,0.18); color: white; border-left-color: white; }
        .sidebar a i { width: 18px; text-align: center; font-size: 13px; }
        .sidebar-divider { border-top: 1px solid rgba(255,255,255,0.12); margin: 6px 15px; }

        .sidebar-logout { margin-top: auto; padding: 15px; border-top: 1px solid rgba(255,255,255,0.12); }
        .sidebar-logout form button {
            width: 100%;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            color: rgba(255,255,255,0.8);
            padding: 10px 15px;
            border-radius: 10px;
            font-size: 13px;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .sidebar-logout form button:hover { background: rgba(255,255,255,0.2); color: white; }

        .main-content { margin-left: 240px; min-height: 100vh; }
        .topbar {
            background: white;
            padding: 13px 28px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 99;
        }
        .topbar-left { display: flex; align-items: center; gap: 10px; }
        .topbar-title { font-size: 15px; font-weight: 700; color: #1a4a1a; }
        .topbar-right { display: flex; align-items: center; gap: 12px; }

        .rep-badge {
            background: rgba(45,106,159,0.1);
            color: #2d6a9f;
            font-size: 10px;
            padding: 3px 10px;
            border-radius: 20px;
            font-weight: 600;
            border: 1px solid rgba(45,106,159,0.2);
        }
        .user-avatar {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, #0f2744, #2d6a9f);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 14px;
            font-weight: 700;
        }
        .user-info .user-name { font-size: 13px; font-weight: 600; color: #0f2744; line-height: 1.2; }
        .user-info .user-role { font-size: 11px; color: #94a3b8; }

        .content-area { padding: 22px 28px; }
        .card { border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.07); border-radius: 14px; }
        .card-header { border-radius: 14px 14px 0 0 !important; font-weight: 600; font-size: 14px; padding: 15px 20px; border-bottom: 1px solid #f1f5f9; background: white; }
        .btn-primary { background: #1a3c5e; border-color: #1a3c5e; }
        .btn-primary:hover { background: #2d6a9f; border-color: #2d6a9f; }
        .alert { border-radius: 10px; font-size: 13px; }
        .table th { font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; }
        .table td { font-size: 13px; vertical-align: middle; }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <div class="sidebar-brand">
        <div class="kd-logo-sidebar"><span>KD</span></div>
        <div class="brand-text">
            <span class="sinhala">කැදැල්ල</span>
            <span class="english">Sales Rep Panel</span>
        </div>
    </div>

    <div class="sidebar-section-label">Main</div>
    <a href="{{ route('salesrep.dashboard') }}" class="{{ request()->routeIs('salesrep.dashboard') ? 'active' : '' }}">
        <i class="fas fa-tachometer-alt"></i> Dashboard
    </a>

    <div class="sidebar-divider"></div>
    <div class="sidebar-section-label">My Work</div>
    <a href="{{ route('salesrep.orders.create') }}" class="{{ request()->routeIs('salesrep.orders.create') ? 'active' : '' }}">
        <i class="fas fa-plus-circle"></i> New Order
    </a>
    <a href="{{ route('salesrep.orders') }}" class="{{ request()->routeIs('salesrep.orders') ? 'active' : '' }}">
        <i class="fas fa-clipboard-list"></i> My Orders
    </a>
    <a href="{{ route('salesrep.deliveries') }}" class="{{ request()->routeIs('salesrep.deliveries') ? 'active' : '' }}">
        <i class="fas fa-truck"></i> Deliveries
    </a>

    <div class="sidebar-divider"></div>
    <div class="sidebar-section-label">Reference</div>
    <a href="{{ route('salesrep.products') }}" class="{{ request()->routeIs('salesrep.products') ? 'active' : '' }}">
        <i class="fas fa-box"></i> Products
    </a>
    <a href="{{ route('salesrep.shops') }}" class="{{ request()->routeIs('salesrep.shops') ? 'active' : '' }}">
    <i class="fas fa-store"></i> Shops
    </a>
    <a href="{{ route('salesrep.shops.create') }}" class="{{ request()->routeIs('salesrep.shops.create') ? 'active' : '' }}">
        <i class="fas fa-plus-circle"></i> Add Shop
    </a>

    <div class="sidebar-divider"></div>
    <div class="sidebar-section-label">Account</div>
    <a href="{{ route('salesrep.profile') }}" class="{{ request()->routeIs('salesrep.profile') ? 'active' : '' }}">
        <i class="fas fa-user-cog"></i> My Profile
    </a>

    <div class="sidebar-logout">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </form>
    </div>
</div>

<!-- MAIN CONTENT -->
<div class="main-content">
    <div class="topbar">
        <div class="topbar-left">
            <span class="rep-badge"><i class="fas fa-user-tie me-1"></i>Sales Rep</span>
            <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
        </div>
        <div class="topbar-right">
            <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
            <div class="user-info">
                <div class="user-name">{{ Auth::user()->name }}</div>
                <div class="user-role">Sales Representative</div>
            </div>
        </div>
    </div>

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
@yield('scripts')
</body>
</html>