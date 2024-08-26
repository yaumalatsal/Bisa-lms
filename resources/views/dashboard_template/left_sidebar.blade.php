<aside class="left-sidebar" data-sidebarbg="skin5">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav" class="pt-4">
                <li class="sidebar-item {{ request()->is('/') ? 'selected' : '' }}">
                    <a data-locs="{{ url('/') }}"
                        class="sidebar-link waves-effect waves-dark sidebar-link {{ request()->is('/') ? 'active' : '' }}"
                        aria-expanded="false">
                        <i class="mdi mdi-home"></i>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                @if (@session('id_produk'))
                    <li class="sidebar-item {{ request()->is('produk') ? 'selected' : '' }}">
                        <a data-locs="{{ url('/produk') }}"
                            class="sidebar-link waves-effect waves-dark sidebar-link"
                            aria-expanded="false">
                            <i class="mdi mdi-cube-outline"></i>
                            <span class="hide-menu">Produk</span>
                        </a>
                    </li>
                @endif
                <li class="sidebar-item {{ request()->is('courses*') ? 'selected' : '' }}">
                    <a data-locs="{{ url('/courses') }}"
                        class="sidebar-link waves-effect waves-dark sidebar-link"
                        aria-expanded="false">
                        <i class="mdi mdi-book"></i>
                        <span class="hide-menu">Course</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->is('inkubasi') ? 'selected' : '' }}">
                    <a data-locs="{{ url('/inkubasi') }}"
                        class="sidebar-link waves-effect waves-dark sidebar-link"
                        aria-expanded="false">
                        <i class="mdi mdi-lamp"></i>
                        <span class="hide-menu">Inkubasi</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->is('laporan') ? 'selected' : '' }}">
                    <a data-locs="{{ url('/laporan') }}"
                        class="sidebar-link waves-effect waves-dark sidebar-link"
                        aria-expanded="false">
                        <i class="mdi mdi-file-document"></i>
                        <span class="hide-menu">Laporan Bulanan</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->is('feedback') ? 'selected' : '' }}">
                    <a data-locs="{{ url('/feedback') }}"
                        class="sidebar-link waves-effect waves-dark sidebar-link"
                        aria-expanded="false">
                        <i class="mdi mdi-message-text"></i>
                        <span class="hide-menu">Feedback Mentor</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->is('penilaian') ? 'selected' : '' }}">
                    <a data-locs="{{ url('/penilaian') }}"
                        class="sidebar-link waves-effect waves-dark sidebar-link"
                        aria-expanded="false">
                        <i class="mdi mdi-star"></i> <!-- Updated Icon -->
                        <span class="hide-menu">Penilaian</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->is('monitoring') ? 'selected' : '' }}">
                    <a data-locs="{{ url('/monitoring') }}"
                        class="sidebar-link waves-effect waves-dark sidebar-link"
                        aria-expanded="false">
                        <i class="mdi mdi-chart-line"></i>
                        <span class="hide-menu">Monitoring Bisnis</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->is('quiz') ? 'selected' : '' }}">
                    <a data-locs="{{ url('/quiz') }}"
                        class="sidebar-link waves-effect waves-dark sidebar-link"
                        aria-expanded="false">
                        <i class="mdi mdi-puzzle"></i> <!-- Updated Icon -->
                        <span class="hide-menu">Kuis</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->is('peringkat') ? 'selected' : '' }}">
                    <a data-locs="{{ url('/peringkat') }}"
                        class="sidebar-link waves-effect waves-dark sidebar-link"
                        aria-expanded="false">
                        <i class="mdi mdi-trophy"></i>
                        <span class="hide-menu">Ranking Quiz</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->is('points') ? 'selected' : '' }}">
                    <a data-locs="{{ url('/points') }}"
                        class="sidebar-link waves-effect waves-dark sidebar-link"
                        aria-expanded="false">
                        <i class="mdi mdi-trophy"></i>
                        <span class="hide-menu">Ranking Point</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->is('groupchat') ? 'selected' : '' }}">
                    <a data-locs="{{ url('/groupchat') }}"
                        class="sidebar-link waves-effect waves-dark sidebar-link"
                        aria-expanded="false">
                        <i class="mdi mdi-forum"></i> <!-- Updated Icon -->
                        <span class="hide-menu">Group Chat</span>
                    </a>
                </li>
                <li class="sidebar-item d-sm-block d-lg-none {{ request()->is('profile*') ? 'selected' : '' }}">
                    <a data-locs="{{ url('/profile') }}"
                        class="sidebar-link waves-effect waves-dark sidebar-link"
                        aria-expanded="false">
                        <i class="mdi mdi-account"></i> <!-- Updated Icon -->
                        <span class="hide-menu">Profile</span>
                    </a>
                </li>
                <li class="sidebar-item d-sm-block d-lg-none {{ request()->is('logout_siswa') ? 'selected' : '' }}">
                    <a data-locs="{{ url('/logout_siswa') }}"
                        class="sidebar-link waves-effect waves-dark sidebar-link"
                        aria-expanded="false">
                        <i class="fa fa-power-off"></i> <!-- Updated Icon -->
                        <span class="hide-menu">Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
