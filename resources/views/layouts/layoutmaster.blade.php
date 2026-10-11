@php
  // Chỉ hiển thị thanh menu sidebar cho Admin trên các trang quản trị
  // Ẩn hoàn toàn trên: trang đăng nhập (login), đăng ký (register), và trang học sinh (student.developing)
  $showSidebar = Auth::check() && Auth::user()->isAdmin() && !request()->routeIs('login', 'register', 'student.developing') && empty($hideSidebar);
@endphp
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Hệ thống quản lý')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    /* =====================================================
       RESET & BASE
    ===================================================== */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --sidebar-w:   {{ $showSidebar ? '240px' : '0px' }};
      --header-h:    60px;
      --c-sidebar:   #0f172a;   /* slate-900 */
      --c-sidebar2:  #1e293b;   /* slate-800 – hover bg */
      --c-header:    #ffffff;
      --c-accent:    #f59e0b;   /* amber-400 */
      --c-accent2:   #d97706;
      --c-page:      #f1f5f9;   /* slate-100 */
      --c-text:      #1e293b;
      --c-muted:     #64748b;
      --c-border:    #e2e8f0;
      --radius:      8px;
      --shadow-sm:   0 1px 3px rgba(0,0,0,.08), 0 1px 2px rgba(0,0,0,.04);
      --shadow-md:   0 4px 12px rgba(0,0,0,.10);
      --transition:  .2s ease;
    }

    @if(!$showSidebar)
      .sidebar { display: none !important; }
      .header { left: 0 !important; }
      .main-wrapper { margin-left: 0 !important; }
      .hamburger { display: none !important; }
    @endif

    body {
      font-family: 'Inter', 'Segoe UI', sans-serif;
      color: var(--c-text);
      background: var(--c-page);
      line-height: 1.6;
      overflow-x: hidden;
    }

    /* =====================================================
       SIDEBAR – fixed trái, full chiều cao
    ===================================================== */
    .sidebar {
      position: fixed;
      top: 0; left: 0;
      width: var(--sidebar-w);
      height: 100vh;
      background: var(--c-sidebar);
      display: flex;
      flex-direction: column;
      z-index: 200;
      overflow-y: auto;
      overflow-x: hidden;
    }

    /* Logo */
    .sidebar-logo {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 0 20px;
      height: var(--header-h);
      border-bottom: 1px solid rgba(255,255,255,.07);
      flex-shrink: 0;
    }
    .sidebar-logo .logo-icon {
      width: 34px; height: 34px;
      background: var(--c-accent);
      border-radius: 8px;
      display: flex; align-items: center; justify-content: center;
      font-size: 17px; font-weight: 700; color: #fff;
      flex-shrink: 0;
    }
    .sidebar-logo .logo-text {
      font-size: 15px; font-weight: 700;
      color: #fff;
      letter-spacing: .3px;
      line-height: 1.2;
    }
    .sidebar-logo .logo-text small {
      display: block;
      font-size: 10px; font-weight: 400;
      color: #94a3b8;
      letter-spacing: .5px;
      text-transform: uppercase;
    }

    /* Nav sections */
    .sidebar-nav { flex: 1; padding: 16px 0; }

    .nav-section { margin-bottom: 4px; }
    .nav-section-title {
      font-size: 10px; font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 1.2px;
      color: #475569;
      padding: 10px 20px 4px;
    }

    .sidebar a {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 9px 20px;
      color: #94a3b8;
      text-decoration: none;
      font-size: 13.5px;
      font-weight: 500;
      border-left: 3px solid transparent;
      transition: background var(--transition), color var(--transition), border-color var(--transition);
      white-space: nowrap;
      overflow: hidden;
    }
    .sidebar a .nav-icon {
      font-size: 15px;
      flex-shrink: 0;
      opacity: .75;
    }
    .sidebar a:hover {
      background: rgba(255,255,255,.06);
      color: #e2e8f0;
    }
    .sidebar a.active {
      background: rgba(245,158,11,.12);
      border-left-color: var(--c-accent);
      color: var(--c-accent);
    }
    .sidebar a.active .nav-icon { opacity: 1; }

    /* Sidebar footer */
    .sidebar-footer {
      padding: 14px 20px;
      border-top: 1px solid rgba(255,255,255,.07);
      font-size: 11px;
      color: #475569;
      flex-shrink: 0;
    }

    /* =====================================================
       HEADER – sticky, chiếm phần bên phải sidebar
    ===================================================== */
    .header {
      position: fixed;
      top: 0;
      left: var(--sidebar-w);
      right: 0;
      height: var(--header-h);
      background: var(--c-header);
      border-bottom: 1px solid var(--c-border);
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 28px;
      z-index: 100;
      box-shadow: var(--shadow-sm);
    }

    /* Breadcrumb / page title */
    .header-left .page-title {
      font-size: 15px;
      font-weight: 600;
      color: var(--c-text);
    }
    .header-left .breadcrumb-mini {
      font-size: 12px;
      color: var(--c-muted);
      display: flex;
      align-items: center;
      gap: 4px;
    }
    .header-left .breadcrumb-mini a {
      color: var(--c-muted);
      text-decoration: none;
    }
    .header-left .breadcrumb-mini a:hover { color: var(--c-accent2); }
    .header-left .breadcrumb-mini .sep { font-size: 10px; }

    /* Header nav links (từ DB – vi_tri = header) */
    .header-nav {
      display: flex;
      align-items: center;
      gap: 4px;
      list-style: none;
    }
    .header-nav a {
      color: var(--c-muted);
      text-decoration: none;
      font-size: 13px;
      font-weight: 500;
      padding: 5px 12px;
      border-radius: 6px;
      transition: background var(--transition), color var(--transition);
    }
    .header-nav a:hover, .header-nav a.active {
      background: #f0f9ff;
      color: var(--c-accent2);
    }

    /* User chip */
    .header-right {
      display: flex;
      align-items: center;
      gap: 12px;
    }
    .user-chip {
      display: flex;
      align-items: center;
      gap: 8px;
      cursor: pointer;
    }
    .user-avatar {
      width: 32px; height: 32px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--c-accent), #ef4444);
      display: flex; align-items: center; justify-content: center;
      font-size: 13px; font-weight: 700; color: #fff;
    }
    .user-name {
      font-size: 13px; font-weight: 600;
      color: var(--c-text);
    }

    /* =====================================================
       MAIN WRAPPER – đẩy sang phải sidebar, xuống dưới header
    ===================================================== */
    .main-wrapper {
      margin-left: var(--sidebar-w);
      margin-top: var(--header-h);
      min-height: calc(100vh - var(--header-h));
      display: flex;
      flex-direction: column;
    }

    /* =====================================================
       CONTENT
    ===================================================== */
    .content {
      flex: 1;
      padding: 28px 32px;
    }

    /* =====================================================
       FOOTER – nằm trong main-wrapper (cuối content)
    ===================================================== */
    .footer {
      background: #fff;
      border-top: 1px solid var(--c-border);
      padding: 14px 32px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      font-size: 12.5px;
      color: var(--c-muted);
    }
    .footer a { color: var(--c-muted); text-decoration: none; }
    .footer a:hover { color: var(--c-accent2); }

    /* =====================================================
       FLASH MESSAGES
    ===================================================== */
    .flash-success, .flash-error {
      border-radius: var(--radius);
      padding: 12px 18px;
      margin-bottom: 20px;
      font-size: 14px;
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .flash-success {
      background: #ecfdf5;
      border: 1px solid #a7f3d0;
      color: #065f46;
    }
    .flash-error {
      background: #fef2f2;
      border: 1px solid #fecaca;
      color: #991b1b;
    }

    /* =====================================================
       RESPONSIVE – tablet / mobile
    ===================================================== */
    @media (max-width: 900px) {
      :root { --sidebar-w: 0px; }

      .sidebar {
        transform: translateX(-240px);
        width: 240px;
        transition: transform .25s ease;
      }
      .sidebar.open { transform: translateX(0); }

      .header { left: 0; }
      .main-wrapper { margin-left: 0; }

      .hamburger { display: flex !important; }
    }

    .hamburger {
      display: none;
      background: none; border: none;
      cursor: pointer;
      flex-direction: column;
      gap: 5px;
      padding: 4px;
    }
    .hamburger span {
      display: block;
      width: 22px; height: 2px;
      background: var(--c-text);
      border-radius: 2px;
      transition: .2s;
    }
  </style>
  @stack('styles')
</head>
<body>

  @if($showSidebar)
  <!-- ======================== SIDEBAR ======================== -->
  <aside class="sidebar" id="sidebar">

    <div class="sidebar-logo">
      <div class="logo-icon">H</div>
      <div class="logo-text">
        HUCE
        <small>Quản trị hệ thống</small>
      </div>
    </div>

    <nav class="sidebar-nav">

      {{-- Menu động từ CSDL, gom theo nhóm --}}
      @foreach (collect($menuHienThi->get('sidebar', []))->groupBy('nhom') as $nhom => $menus)
        <div class="nav-section">
          @if ($nhom !== '')
            <div class="nav-section-title">{{ $nhom }}</div>
          @endif
          <ul style="list-style:none">
            @foreach ($menus as $menu)
              <li>
                <a href="{{ $menu->url }}" @class(['active' => $menu->dangChon()])>
                  <span class="nav-icon">›</span>
                  {{ $menu->ten }}
                </a>
              </li>
            @endforeach
          </ul>
        </div>
      @endforeach

    </nav>

    <div class="sidebar-footer">
      © {{ date('Y') }} HUCE
    </div>
  </aside>
  @endif

  <!-- ======================== HEADER ======================== -->
  <header class="header">
    <div class="d-flex align-items-center gap-3">
      @if($showSidebar)
        <button class="hamburger" id="hamburger" aria-label="Toggle menu">
          <span></span><span></span><span></span>
        </button>
      @else
        <a href="/" class="d-flex align-items-center gap-2 text-decoration-none">
          <div style="width:32px;height:32px;background:var(--c-accent);border-radius:6px;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:16px;">H</div>
          <span class="fw-bold text-dark fs-6">HUCE</span>
        </a>
      @endif

      <div class="header-left">
        <div class="page-title">@yield('title', 'Trang chủ')</div>
        <div class="breadcrumb-mini">
          <a href="/">Trang chủ</a>
          <span class="sep">›</span>
          <span>@yield('title', 'Trang chủ')</span>
        </div>
      </div>
    </div>

    <div class="header-right">
      {{-- Menu header từ CSDL: chỉ hiển thị cho Admin hoặc khi có sidebar --}}
      @if($showSidebar && $menuHienThi->get('header', [])->isNotEmpty())
        <ul class="header-nav">
          @foreach ($menuHienThi->get('header', []) as $menu)
            <li>
              <a href="{{ $menu->url }}" @class(['active' => $menu->dangChon()])>{{ $menu->ten }}</a>
            </li>
          @endforeach
        </ul>
      @endif

      @auth
        <div class="user-chip">
          <div class="user-avatar" title="{{ Auth::user()->name }}">
            {{ strtoupper(mb_substr(Auth::user()->name, 0, 1, 'UTF-8')) }}
          </div>
          <div class="d-flex flex-column text-start">
            <span class="user-name d-none d-md-inline" style="line-height: 1.2;">{{ Auth::user()->name }}</span>
            <span class="badge {{ Auth::user()->isAdmin() ? 'bg-danger' : 'bg-success' }} text-white" style="font-size: 10px; padding: 2px 6px; width: fit-content;">
              {{ Auth::user()->isAdmin() ? 'Quản trị viên' : 'Sinh viên' }}
            </span>
          </div>
          <form action="{{ route('logout') }}" method="POST" class="d-inline ms-2">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-danger py-1 px-2" title="Đăng xuất" style="font-size: 12px;">
              Đăng xuất
            </button>
          </form>
        </div>
      @else
        <div class="d-flex gap-2">
          <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary px-3">Đăng nhập</a>
          <a href="{{ route('register') }}" class="btn btn-sm btn-primary px-3">Đăng ký</a>
        </div>
      @endauth
    </div>
  </header>

  <!-- ======================== MAIN ======================== -->
  <div class="main-wrapper">
    <main class="content">

      {{-- Flash messages --}}
      @if(session('success'))
        <div class="flash-success">
          <span>✓</span> {{ session('success') }}
        </div>
      @endif
      @if(session('error'))
        <div class="flash-error">
          <span>✕</span> {{ session('error') }}
        </div>
      @endif
      @if(session('warning'))
        <div class="alert alert-warning py-2 px-3 small d-flex align-items-center gap-2 mb-3 border-warning">
          <span>{{ session('warning') }}</span>
        </div>
      @endif

      @yield('content')
    </main>

    <footer class="footer">
      <span>© {{ date('Y') }} Khoa Công nghệ Thông tin – ĐH Xây dựng Hà Nội</span>
      <span>Phiên bản 1.0</span>
    </footer>
  </div>

  <!-- Overlay khi sidebar mở (mobile) -->
  <div id="overlay" onclick="toggleSidebar()"
       style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:150;"></div>

  <script>
    function toggleSidebar() {
      const sb = document.getElementById('sidebar');
      const ov = document.getElementById('overlay');
      const open = sb.classList.toggle('open');
      ov.style.display = open ? 'block' : 'none';
    }
    document.getElementById('hamburger').addEventListener('click', toggleSidebar);
  </script>

  @stack('scripts')
</body>
</html>