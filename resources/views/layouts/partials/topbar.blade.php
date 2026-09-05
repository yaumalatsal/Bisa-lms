<header class="topbar">
    <nav class="navbar top-navbar navbar-expand-md">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ url($nav['home']) }}">
                <img src="{{ asset('assets/images/logo_fix.png') }}" alt="BISa">
            </a>
            <button class="nav-toggler btn btn-link d-md-none" type="button"
                aria-label="Buka menu navigasi">
                <i class="mdi mdi-menu" aria-hidden="true"></i>
            </button>
        </div>

        <div class="navbar-collapse collapse">
            <ul class="navbar-nav float-start me-auto align-items-center">
                <li class="nav-item d-none d-lg-block">
                    <button class="nav-link sidebartoggler btn btn-link" type="button"
                        data-sidebartype="mini-sidebar" aria-label="Perkecil menu samping">
                        <i class="mdi mdi-menu font-24" aria-hidden="true"></i>
                    </button>
                </li>
                <li class="nav-item d-none d-md-block">
                    {{-- Which of the four areas am I in? Previously the roles were
                         visually identical once you were inside. --}}
                    <span class="bisa-role-chip">{{ $nav['label'] }}</span>
                </li>
            </ul>

            <ul class="navbar-nav float-end align-items-center">
                <li class="nav-item">
                    <button type="button" class="nav-link btn btn-link" data-bisa-theme-toggle
                        aria-label="Ganti tema terang / gelap" title="Ganti tema">
                        <i class="mdi mdi-theme-light-dark font-24" aria-hidden="true"></i>
                    </button>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#"
                        id="bisaUserMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="bisa-avatar" aria-hidden="true">{{ $initials }}</span>
                        <span class="d-none d-lg-block text-start">
                            <span class="bisa-user-name d-block">{{ $userName }}</span>
                            <span class="bisa-user-role d-block">{{ $nav['label'] }}</span>
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="bisaUserMenu">
                        @if ($nav['profile'])
                            <li>
                                <a class="dropdown-item" href="{{ url($nav['profile']) }}">
                                    <i class="mdi mdi-account" aria-hidden="true"></i> Profil
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                        @endif
                        <li>
                            <a class="dropdown-item" href="{{ url($nav['logout']) }}">
                                <i class="mdi mdi-power" aria-hidden="true"></i> Logout
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
