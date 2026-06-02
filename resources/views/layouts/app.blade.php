<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Dashboard') | adminHMD</title>
  <link rel="icon" type="image/jpeg" href="{{ asset('assets/logo/logo.jpg') }}">
  <link rel="apple-touch-icon" href="{{ asset('assets/logo/logo.jpg') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body>
  <div class="admin-shell">
    <div class="sidebar-backdrop" data-sidebar-close></div>
    <aside class="admin-sidebar" id="adminSidebar" aria-label="Main navigation">
      <div class="sidebar-header">
        <a class="brand-mark" href="{{ route('dashboard') }}" aria-label="admin dashboard">
          <span class="brand-icon">
            <img src="{{ asset('assets/logo/logo.jpg') }}" alt="Logo" style="width:32px;height:32px;object-fit:contain;display:block;" />
          </span>
          <span class="brand-copy">
            <span class="brand-title">adminHMD</span>
          </span>
        </a>
      </div>
      <nav class="sidebar-nav">
        <a class="nav-link @if(request()->routeIs('dashboard')) active @endif" href="{{ route('dashboard') }}">
          <span class="nav-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
          <span class="nav-text">Dashboard</span>
        </a>
        <a class="nav-link @if(request()->routeIs('gurus.*')) active @endif" href="{{ route('gurus.index') }}">
          <span class="nav-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
          <span class="nav-text">Mengelola Data Guru</span>
        </a>
        <a class="nav-link @if(request()->routeIs('kelas.*')) active @endif" href="{{ route('kelas.index') }}">
          <span class="nav-icon"><i class="bi bi-building" aria-hidden="true"></i></span>
          <span class="nav-text">Mengelola Data Kelas Diniyah</span>
        </a>
        <a class="nav-link @if(request()->routeIs('santris.*')) active @endif" href="{{ route('santris.index') }}">
          <span class="nav-icon"><i class="bi bi-person-badge" aria-hidden="true"></i></span>
          <span class="nav-text">Mengelola Data Santri</span>
        </a>
        <a class="nav-link @if(request()->routeIs('materis.*')) active @endif" href="{{ route('materis.index') }}">
          <span class="nav-icon"><i class="bi bi-book" aria-hidden="true"></i></span>
          <span class="nav-text">Mengelola Materi Pembelajaran</span>
        </a>
        <a class="nav-link @if(request()->routeIs('jurnal_pembelajarans.*')) active @endif" href="{{ route('jurnal_pembelajarans.index') }}">
          <span class="nav-icon"><i class="bi bi-journal" aria-hidden="true"></i></span>
          <span class="nav-text">Mengelola Jurnal Pembelajaran</span>
        </a>
        @if(auth()->check() && auth()->user()->isAdmin())
          <a class="nav-link @if(request()->routeIs('users.*')) active @endif" href="{{ route('users.index') }}">
            <span class="nav-icon"><i class="bi bi-people-fill" aria-hidden="true"></i></span>
            <span class="nav-text">Mengelola Akun Pengguna</span>
          </a>
        @endif
      </nav>
      <div class="sidebar-footer">
        <span class="status-dot"></span>
        <span class="sidebar-footer-text">System running smoothly</span>
      </div>
    </aside>

    <div class="admin-main">
      <nav class="navbar admin-navbar navbar-expand bg-white">
        <div class="container-fluid px-3 px-lg-4">
          <button class="sidebar-toggle" type="button" data-sidebar-toggle aria-controls="adminSidebar" aria-expanded="true" aria-label="Toggle sidebar">
            <span></span>
            <span></span>
            <span></span>
          </button>
          <form class="d-none d-md-flex ms-3 flex-grow-1" role="search" action="{{ url()->current() }}" method="GET">
            <div class="input-group w-100">
              <input class="form-control search-input" type="search" name="search" value="{{ request('search') }}" placeholder="Cari data..." aria-label="Search">
              @if(request()->routeIs('jurnal_pembelajarans.*'))
                <input class="form-control ms-2" type="date" name="tanggal" value="{{ request('tanggal') }}" aria-label="Cari tanggal">
              @endif
              <button class="btn btn-outline-secondary" type="submit" aria-label="Submit search">
                <i class="bi bi-search"></i>
              </button>
            </div>
          </form>
          <div class="navbar-actions ms-auto">
            <button class="icon-button theme-toggle" type="button" data-theme-toggle aria-label="Switch color theme" title="Switch color theme">
              <i class="bi bi-moon-stars" data-theme-icon aria-hidden="true"></i>
            </button>
            <form method="POST" action="{{ route('logout') }}" class="ms-2">
              @csrf
              <button type="submit" class="btn btn-outline-secondary btn-sm" aria-label="Sign out">Sign out</button>
            </form>
          </div>
        </div>
      </nav>

      <main class="dashboard-content">
        <div class="container-fluid px-3 px-lg-4 py-4">
          @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
          @endif
          @if($errors->any())
            <div class="alert alert-danger">
              <ul class="mb-0">
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
          @yield('content')
        </div>
      </main>

      <footer class="admin-footer">
        <div class="container-fluid px-3 px-lg-4">
        </div>
      </footer>
    </div>
  </div>

  <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/js/main.js') }}"></script>
</body>
</html>
