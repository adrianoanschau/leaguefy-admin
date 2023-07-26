<aside class="main-sidebar {{ config('leaguefy-admin.classes_sidebar', 'sidebar-dark-primary elevation-4') }}">

    {{-- Sidebar brand logo --}}
    @if(config('leaguefy-admin.logo_img_xl'))
        @include('leaguefy-admin::partials.common.brand-logo-xl')
    @else
        @include('leaguefy-admin::partials.common.brand-logo-xs')
    @endif

    {{-- Sidebar menu --}}
    <div class="sidebar">
        <nav class="pt-2">
            <ul class="nav nav-pills nav-sidebar flex-column {{ config('leaguefy-admin.classes_sidebar_nav', '') }}"
                data-widget="treeview" role="menu"
                @if(config('leaguefy-admin.sidebar_nav_animation_speed') != 300)
                    data-animation-speed="{{ config('leaguefy-admin.sidebar_nav_animation_speed') }}"
                @endif
                @if(!config('leaguefy-admin.sidebar_nav_accordion'))
                    data-accordion="false"
                @endif>
                {{-- Configured sidebar links --}}
                @each('leaguefy-admin::partials.sidebar.menu-item', $adminlte->menu('sidebar'), 'item')
            </ul>
        </nav>
    </div>

</aside>
