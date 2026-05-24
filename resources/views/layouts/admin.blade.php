<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') – Bouquetta Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --pink: #E91E63; --pink-dark: #C2185B; --pink-light: #FCE4EC;
            --sidebar-bg: #1a1a2e; --sidebar-hover: #16213e;
            --bg: #f8f9fa; --white: #fff;
            --text: #333; --muted: #6c757d;
            --border: #e9ecef; --radius: 12px;
            --success: #28a745; --warning: #ffc107; --danger: #dc3545; --info: #17a2b8;
        }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: 'Inter', sans-serif; background: var(--bg); display: flex; min-height: 100vh; }
        a { text-decoration: none; color: inherit; }

        /* SIDEBAR */
        .sidebar { width: 260px; background: var(--sidebar-bg); color: #ccc; display: flex; flex-direction: column; position: fixed; height: 100vh; overflow-y: auto; z-index: 100; transition: transform .3s; }
        .sidebar-brand { padding: 1.5rem; border-bottom: 1px solid #2a2a4a; }
        .sidebar-brand h2 { font-size: 1.4rem; color: #F48FB1; font-weight: 700; }
        .sidebar-brand p { font-size: .75rem; color: #888; margin-top: .25rem; }
        .sidebar-nav { flex: 1; padding: 1rem 0; }
        .nav-section { padding: .5rem 1.5rem; font-size: .7rem; text-transform: uppercase; letter-spacing: 1px; color: #666; margin-top: .5rem; }
        .sidebar-link { display: flex; align-items: center; gap: .75rem; padding: .75rem 1.5rem; color: #aaa; font-size: .9rem; font-weight: 500; transition: all .2s; position: relative; }
        .sidebar-link:hover, .sidebar-link.active { background: var(--sidebar-hover); color: #F48FB1; }
        .sidebar-link.active::left { content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 3px; background: var(--pink); }
        .sidebar-link .icon { width: 1.5rem; height: 1.5rem; text-align: center; display:flex; align-items:center; justify-content:center; }
        .sidebar-link .icon img { width: 20px; height: 20px; object-fit: contain; filter: brightness(0.7) sepia(1) hue-rotate(300deg) saturate(2); }
        .sidebar-link:hover .icon img, .sidebar-link.active .icon img { filter: brightness(0.8) sepia(1) hue-rotate(280deg) saturate(3); }
        .sidebar-footer { padding: 1.5rem; border-top: 1px solid #2a2a4a; }
        .sidebar-user { display: flex; align-items: center; gap: .75rem; }
        .avatar { width: 36px; height: 36px; border-radius: 50%; background: var(--pink); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; font-size: .85rem; }
        .user-info p { font-size: .85rem; color: #fff; font-weight: 600; }
        .user-info span { font-size: .75rem; color: #888; }
        .logout-btn { display: block; width: 100%; margin-top: 1rem; padding: .5rem; background: transparent; border: 1px solid #333; color: #aaa; border-radius: 8px; font-size: .8rem; cursor: pointer; transition: all .2s; }
        .logout-btn:hover { background: var(--danger); border-color: var(--danger); color: #fff; }

        /* MAIN */
        .main-content { margin-left: 260px; flex: 1; display: flex; flex-direction: column; min-height: 100vh; }
        .topbar { background: var(--white); border-bottom: 1px solid var(--border); padding: 1rem 2rem; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 50; }
        .topbar h1 { font-size: 1.2rem; font-weight: 700; color: var(--text); }
        .topbar-actions { display: flex; align-items: center; gap: 1rem; }
        .page-content { padding: 2rem; flex: 1; }

        /* CARDS */
        .card { background: var(--white); border-radius: var(--radius); box-shadow: 0 2px 12px rgba(0,0,0,.06); overflow: hidden; }
        .card-header { padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
        .card-header h3 { font-size: 1rem; font-weight: 700; }
        .card-body { padding: 1.5rem; }
        .stat-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1.5rem; margin-bottom: 2rem; }
        .stat-card { background: var(--white); border-radius: var(--radius); padding: 1.5rem; box-shadow: 0 2px 12px rgba(0,0,0,.06); display: flex; align-items: center; gap: 1rem; }
        .stat-icon { width: 54px; height: 54px; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .stat-icon img { width: 32px; height: 32px; object-fit: contain; }
        .stat-info p { font-size: .8rem; color: var(--muted); margin-bottom: .25rem; }
        .stat-info h3 { font-size: 1.6rem; font-weight: 700; }

        /* TABLE */
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        th { padding: .75rem 1rem; text-align: left; font-size: .8rem; font-weight: 600; color: var(--muted); text-transform: uppercase; letter-spacing: .5px; background: #fafafa; border-bottom: 2px solid var(--border); }
        td { padding: .875rem 1rem; border-bottom: 1px solid var(--border); font-size: .875rem; vertical-align: middle; }
        tr:hover td { background: #fafafa; }
        tr:last-child td { border-bottom: none; }

        /* BADGES */
        .badge { display: inline-flex; align-items: center; padding: .25rem .75rem; border-radius: 50px; font-size: .75rem; font-weight: 600; }
        .badge-success { background: #d4edda; color: #155724; }
        .badge-warning { background: #fff3cd; color: #856404; }
        .badge-danger  { background: #f8d7da; color: #721c24; }
        .badge-info    { background: #cce5ff; color: #004085; }
        .badge-secondary { background: #e9ecef; color: #495057; }
        .badge-purple  { background: #e8e3ff; color: #5b21b6; }

        /* FORMS */
        .form-group { margin-bottom: 1.25rem; }
        label { display: block; font-size: .85rem; font-weight: 600; color: var(--text); margin-bottom: .4rem; }
        input[type=text], input[type=email], input[type=number], input[type=password], input[type=tel], select, textarea {
            width: 100%; padding: .7rem 1rem; border: 1.5px solid var(--border); border-radius: 8px; font-size: .9rem; font-family: inherit; transition: border-color .2s; background: #fff;
        }
        input:focus, select:focus, textarea:focus { outline: none; border-color: var(--pink); box-shadow: 0 0 0 3px rgba(233,30,99,.1); }
        textarea { resize: vertical; min-height: 100px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        .input-error { border-color: var(--danger) !important; }
        .error-msg { color: var(--danger); font-size: .8rem; margin-top: .3rem; }
        .form-check { display: flex; align-items: center; gap: .5rem; }
        .form-check input[type=checkbox] { width: auto; }

        /* BUTTONS */
        .btn { display: inline-flex; align-items: center; gap: .4rem; padding: .6rem 1.4rem; border-radius: 8px; font-size: .85rem; font-weight: 600; cursor: pointer; border: none; transition: all .2s; text-decoration: none; }
        .btn-pink { background: var(--pink); color: #fff; }
        .btn-pink:hover { background: var(--pink-dark); }
        .btn-secondary { background: #6c757d; color: #fff; }
        .btn-secondary:hover { background: #5a6268; }
        .btn-success { background: var(--success); color: #fff; }
        .btn-danger { background: var(--danger); color: #fff; }
        .btn-warning { background: var(--warning); color: #333; }
        .btn-sm { padding: .35rem .75rem; font-size: .8rem; }

        /* ALERTS */
        .alert { padding: .875rem 1.25rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: .875rem; }
        .alert-success { background: #d4edda; color: #155724; }
        .alert-danger   { background: #f8d7da; color: #721c24; }
        .alert-warning  { background: #fff3cd; color: #856404; }

        /* PAGINATION */
        .pagination { display: flex; gap: .5rem; justify-content: center; margin-top: 1.5rem; flex-wrap: wrap; }
        .pagination a, .pagination span { padding: .4rem .85rem; border-radius: 8px; font-size: .85rem; border: 1px solid var(--border); background: #fff; color: var(--text); }
        .pagination .active span { background: var(--pink); color: #fff; border-color: var(--pink); }
        .pagination a:hover { background: var(--pink-light); }

        /* SEARCH BAR */
        .search-bar { display: flex; gap: .75rem; align-items: center; flex-wrap: wrap; }
        .search-bar input { flex: 1; min-width: 200px; }
        .search-bar select { width: 180px; }

        /* MOBILE */
        .sidebar-toggle { display: none; background: none; border: none; font-size: 1.5rem; cursor: pointer; }
        @media (max-width: 900px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .sidebar-toggle { display: block; }
            .form-row { grid-template-columns: 1fr; }
        }
        @media (max-width: 600px) {
            .stat-grid { grid-template-columns: 1fr 1fr; }
            .page-content { padding: 1rem; }
        }
    </style>
    @stack('styles')
</head>
<body>
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <h2><img src="{{ asset('images/icons/icons8-flower-100.png') }}" style="width:22px;height:22px;vertical-align:middle;margin-right:6px;"> Bouquetta</h2>
        <p>Panel Admin</p>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-section">Utama</div>
        <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"> Dashboard
        </a>
        <div class="nav-section">Manajemen</div>
        <a href="{{ route('admin.flowers.index') }}" class="sidebar-link {{ request()->routeIs('admin.flowers*') ? 'active' : '' }}"> Manajemen Bunga
        </a>
        <a href="{{ route('admin.orders.index') }}" class="sidebar-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}"> Manajemen Pesanan
        </a>
        <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}"> Manajemen Pengguna
        </a>
        <div class="nav-section">Toko</div>
        <a href="{{ route('home') }}" class="sidebar-link" target="_blank"> Lihat Toko
        </a>
    </nav>
    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div class="user-info">
                <p>{{ auth()->user()->name }}</p>
                <span>Administrator</span>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn"><img src="{{ asset('images/icons/icons8-logout-100.png') }}" style="width:14px;height:14px;vertical-align:middle;margin-right:4px;"> Logout</button>
        </form>
    </div>
</aside>

<div class="main-content">
    <div class="topbar">
        <div style="display:flex;align-items:center;gap:1rem">
            <button class="sidebar-toggle" onclick="document.getElementById('sidebar').classList.toggle('open')">☰</button>
            <h1>@yield('page-title', 'Dashboard')</h1>
        </div>
        <div class="topbar-actions">
            <a href="{{ route('home') }}" class="btn btn-sm btn-secondary" target="_blank"><img src="{{ asset('images/icons/icons8-store-64.png') }}" style="width:14px;height:14px;"> Toko</a>
        </div>
    </div>

    <div class="page-content">
        @if(session('success'))
            <div class="alert alert-success"><img src="{{ asset('images/icons/icons8-check-64.png') }}" style="width:16px;height:16px;vertical-align:middle;margin-right:6px;"> {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger"><img src="{{ asset('images/icons/icons8-cancel-64.png') }}" style="width:16px;height:16px;vertical-align:middle;margin-right:6px;"> {{ session('error') }}</div>
        @endif
        @yield('content')
    </div>
</div>

<script>
// Close sidebar when clicking outside on mobile
document.addEventListener('click', function(e) {
    const sidebar = document.getElementById('sidebar');
    const toggle = document.querySelector('.sidebar-toggle');
    if (window.innerWidth <= 900 && sidebar.classList.contains('open')) {
        if (!sidebar.contains(e.target) && e.target !== toggle) {
            sidebar.classList.remove('open');
        }
    }
});
</script>
@stack('scripts')
</body>
</html>