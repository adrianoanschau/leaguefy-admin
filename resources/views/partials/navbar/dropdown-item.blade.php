@inject('navbarItemHelper', 'JeroenNoten\LaravelAdminLte\Helpers\NavbarItemHelper')

@if ($navbarItemHelper->isSubmenu($item))

    {{-- Dropdown submenu --}}
    @include('leaguefy-admin::partials.navbar.dropdown-item-submenu')

@elseif ($navbarItemHelper->isLink($item))

    {{-- Dropdown link --}}
    @include('leaguefy-admin::partials.navbar.dropdown-item-link')

@endif
