{{--
    Sidebar, rendered from config/navigation.php.

    Items are real <a href> links now. They used to carry the destination in a
    `data-locs` attribute with a jQuery click handler doing the navigation, so
    they could not be opened in a new tab, middle-clicked, focused or read as
    links by assistive technology.
--}}
<aside class="left-sidebar">
    <div class="scroll-sidebar">
        <nav class="sidebar-nav" aria-label="Navigasi utama">
            <ul id="sidebarnav">
                @foreach ($nav['items'] as $item)
                    @continue(isset($item['when']) && ! ($item['when'])())

                    @php
                        $href = isset($item['route']) ? route($item['route']) : url($item['url'] ?? '/');
                        $isActive = request()->is(...(array) ($item['active'] ?? []));
                    @endphp

                    <li class="sidebar-item {{ $isActive ? 'selected' : '' }}">
                        <a href="{{ $href }}"
                            class="sidebar-link {{ $isActive ? 'active' : '' }}"
                            @if ($isActive) aria-current="page" @endif>
                            <i class="mdi {{ $item['icon'] }}" aria-hidden="true"></i>
                            <span class="hide-menu">{{ $item['label'] }}</span>
                        </a>
                    </li>
                @endforeach

                {{-- On small screens the topbar menu is hidden, so surface these here. --}}
                @if ($nav['profile'])
                    <li class="sidebar-item d-lg-none {{ request()->is(ltrim($nav['profile'], '/') . '*') ? 'selected' : '' }}">
                        <a href="{{ url($nav['profile']) }}" class="sidebar-link">
                            <i class="mdi mdi-account" aria-hidden="true"></i>
                            <span class="hide-menu">Profil</span>
                        </a>
                    </li>
                @endif

                <li class="sidebar-item d-lg-none">
                    <a href="{{ url($nav['logout']) }}" class="sidebar-link">
                        <i class="mdi mdi-power" aria-hidden="true"></i>
                        <span class="hide-menu">Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
