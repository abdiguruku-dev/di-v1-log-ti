<div class="topbar">
    <div class="d-flex align-items-center gap-3">
        <button class="btn btn-light border shadow-sm rounded-circle" id="sidebarToggle" style="width: 40px; height: 40px; display:flex; align-items:center; justify-content:center;">
            <i class="bi bi-list fs-5 text-dark"></i>
        </button>
        <div class="mobile-brand">
            <img src="{{ $logoApp }}" class="logo-img" style="height: 30px; width: 30px;">
            <span class="fw-bold text-dark ms-2">{{ Str::limit($namaSekolah, 15) }}</span>
        </div>
        <h5 class="m-0 fw-bold text-dark d-none d-md-block ms-2">@yield('page_title', 'Dashboard')</h5>
    </div>

    <div class="dropdown">
        <div class="d-flex align-items-center gap-3 cursor-pointer" data-bs-toggle="dropdown">
            <div class="text-end d-none d-md-block">
                <div class="fw-bold text-dark">{{ Auth::user()->name }}</div>
                <small class="text-primary fw-bold">Administrator</small>
            </div>
            <img src="{{ $userPhoto }}" alt="User" class="profile-img shadow-sm">
        </div>
        <ul class="dropdown-menu dropdown-menu-end animated fadeIn">
            <li>
                <h6 class="dropdown-header">Halo, {{ Auth::user()->name }}</h6>
            </li>
            <li><a class="dropdown-item" href="#"><i class="bi bi-person"></i> Profil Saya</a></li>
            <li><a class="dropdown-item" href="#"><i class="bi bi-key"></i> Ganti Password</a></li>
        </ul>
    </div>
</div>