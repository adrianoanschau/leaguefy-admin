@php
    if (config()->has('leaguefy-admin.topbar.color')) {
        $classes_topnav_nav = config('leaguefy-admin.classes_topnav_nav');
        $classes_topnav_nav = explode(' ', $classes_topnav_nav);
        $classes_topnav_nav = array_map(function ($class) {
            if (!Str::of($class)->contains('bg-')) return $class;
            return config('leaguefy-admin.topbar.color');
        }, $classes_topnav_nav);
        $classes_topnav_nav = implode(' ', $classes_topnav_nav);
    } else {
        $classes_topnav_nav = config('leaguefy-admin.classes_topnav_nav', 'navbar-expand');
    }
@endphp

<nav class="main-header navbar
    {{ $classes_topnav_nav }}
    {{ config('leaguefy-admin.classes_topnav', 'navbar-white navbar-light') }}">

    {{-- Navbar left links --}}
    <ul class="navbar-nav">
        {{-- Left sidebar toggler link --}}
        @include('leaguefy-admin::partials.navbar.menu-item-left-sidebar-toggler')

        {{-- Configured left links --}}
        @each('leaguefy-admin::partials.navbar.menu-item', $adminlte->menu('navbar-left'), 'item')

        {{-- Custom left links --}}
        @yield('content_top_nav_left')
    </ul>

    {{-- Navbar right links --}}
    <ul class="navbar-nav ml-auto">
        {{-- Custom right links --}}
        @yield('content_top_nav_right')

        {{-- Configured right links --}}
        @each('leaguefy-admin::partials.navbar.menu-item', $adminlte->menu('navbar-right'), 'item')

        {{-- User menu link --}}
        @if(Auth::user())
            @if(config('leaguefy-admin.usermenu_enabled'))
                @include('leaguefy-admin::partials.navbar.menu-item-dropdown-user-menu')
            @else
                @include('leaguefy-admin::partials.navbar.menu-item-logout-link')
            @endif
        @endif

        {{-- Right sidebar toggler link --}}
        @if(config('leaguefy-admin.right_sidebar'))
            @include('leaguefy-admin::partials.navbar.menu-item-right-sidebar-toggler')
        @endif
    </ul>

</nav>
