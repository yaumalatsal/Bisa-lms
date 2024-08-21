<aside class="left-sidebar" data-sidebarbg="skin5">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav" class="pt-4">
                <li class="sidebar-item {{ request()->is('admin') ? 'selected' : '' }}"> <a
                        data-locs="{{ url('/admin') }}"
                        class="sidebar-link waves-effect waves-dark sidebar-link {{ request()->is('/') ? 'active' : '' }}"
                        aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span
                            class="hide-menu">Dashboard</span></a></li>
                <li class="sidebar-item {{ request()->is('admin/produk*') ? 'selected' : '' }}"> <a
                        data-locs="{{ route('admin.produk') }}"
                        class="sidebar-link waves-effect waves-dark sidebar-link" aria-expanded="false"><i
                            class="mdi mdi-buffer"></i><span class="hide-menu">Produk</span></a></li>
                <li class="sidebar-item {{ request()->is('admin/siswa*') ? 'selected' : '' }}"> <a
                        data-locs="{{ route('admin.siswa') }}" class="sidebar-link waves-effect waves-dark sidebar-link"
                        aria-expanded="false"><i class="mdi mdi-account-multiple"></i><span
                            class="hide-menu">Siswa</span></a></li>
                <li class="sidebar-item {{ request()->is('admin/penilaian') ? 'selected' : '' }}"> <a
                        data-locs="{{ url('/admin/penilaian') }}"
                        class="sidebar-link waves-effect waves-dark sidebar-link" aria-expanded="false"><i
                            class="mdi mdi-account-multiple"></i><span class="hide-menu">Penilaian</span></a></li>

                <li class="sidebar-item {{ request()->is('admin/feedback') ? 'selected' : '' }}"> <a
                        data-locs="{{ url('/admin/feedback') }}"
                        class="sidebar-link waves-effect waves-dark sidebar-link" aria-expanded="false"><i
                            class="mdi mdi-comment-check"></i><span class="hide-menu">Feedback</span></a></li>

                <li class="sidebar-item {{ request()->is('admin/materi') ? 'selected' : '' }}"> <a
                        data-locs="{{ url('/admin/materi') }}"
                        class="sidebar-link waves-effect waves-dark sidebar-link" aria-expanded="false"><i
                            class="mdi mdi-comment-check"></i><span class="hide-menu">Daftar Materi</span></a></li>


                <li class="sidebar-item {{ request()->is('admin/mapel') ? 'selected' : '' }}"> <a
                        data-locs="{{ route('admin.mapels.index') }}"
                        class="sidebar-link waves-effect waves-dark sidebar-link" aria-expanded="false"><i
                            class="mdi mdi-comment-check"></i><span class="hide-menu">Soal Quiz</span></a></li>

                            <li class="sidebar-item {{ request()->is('admin/bmc') ? 'selected' : '' }}"> <a
                                data-locs="{{ route('admin.bmc.index') }}"
                                class="sidebar-link waves-effect waves-dark sidebar-link" aria-expanded="false"><i
                                    class="mdi mdi-comment-check"></i><span class="hide-menu">Pertanyaan BMC</span></a></li>

        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
