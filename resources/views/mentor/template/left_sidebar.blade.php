<aside class="left-sidebar" data-sidebarbg="skin5">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav" class="pt-4">
                <li class="sidebar-item {{ (request()->is('mentor')) ? 'selected' : '' }}" > <a data-locs="{{url('/mentor')}}" class="sidebar-link waves-effect waves-dark sidebar-link {{ (request()->is('/')) ? 'active' : '' }}"
                         aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span
                            class="hide-menu" >Dashboard</span></a></li>
                <li class="sidebar-item {{ (request()->is('mentor/produk')) ? 'selected' : '' }}"> <a data-locs="{{url('/mentor/produk')}}" class="sidebar-link waves-effect waves-dark sidebar-link"
                         aria-expanded="false"><i class="mdi mdi-buffer"></i><span
                            class="hide-menu">Produk</span></a></li>
                            <li class="sidebar-item {{ (request()->is('mentor/penilaian')) ? 'selected' : '' }}"> <a data-locs="{{url('/mentor/penilaian')}}" class="sidebar-link waves-effect waves-dark sidebar-link"
                         aria-expanded="false"><i class="mdi mdi-account-multiple"></i><span
                            class="hide-menu">Penilaian</span></a></li>

                <li class="sidebar-item {{ (request()->is('mentor/feedback')) ? 'selected' : '' }}"> <a data-locs="{{url('/mentor/feedback')}}" class="sidebar-link waves-effect waves-dark sidebar-link" aria-expanded="false"><i class="mdi mdi-comment-check"></i><span
                class="hide-menu">Feedback</span></a></li>
                <li class="sidebar-item {{ (request()->is('mentor/laporan-produk')) ? 'selected' : '' }}"> <a data-locs="{{url('/mentor/laporan-produk')}}" class="sidebar-link waves-effect waves-dark sidebar-link"
                    aria-expanded="false"><i class="mdi mdi-account-multiple"></i><span
                       class="hide-menu">Laporan Bulanan Siswa</span></a></li>
                    
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>