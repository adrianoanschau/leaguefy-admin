@inject('sidebarItemHelper', 'JeroenNoten\LaravelAdminLte\Helpers\SidebarItemHelper')

@if ($sidebarItemHelper->isHeader($item))

    {{-- Header --}}
    @include('leaguefy-admin::partials.sidebar.menu-item-header')

@elseif ($sidebarItemHelper->isLegacySearch($item) || $sidebarItemHelper->isCustomSearch($item))

    {{-- Search form --}}
    @include('leaguefy-admin::partials.sidebar.menu-item-search-form')

@elseif ($sidebarItemHelper->isMenuSearch($item))

    {{-- Search menu --}}
    @include('leaguefy-admin::partials.sidebar.menu-item-search-menu')

@elseif ($sidebarItemHelper->isSubmenu($item))

    {{-- Treeview menu --}}
    @include('leaguefy-admin::partials.sidebar.menu-item-treeview-menu')

@elseif ($sidebarItemHelper->isLink($item))

    {{-- Link --}}
    @include('leaguefy-admin::partials.sidebar.menu-item-link')

@endif
