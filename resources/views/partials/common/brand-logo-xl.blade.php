@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')

@php
    if (config()->has('leaguefy-admin.topbar.color')) {
        $classes_brand = config('leaguefy-admin.classes_brand');
        $classes_brand = explode(' ', $classes_brand);
        $classes_brand = array_map(function ($class) {
            if (!Str::of($class)->contains('bg-')) return $class;
            return '';
        }, $classes_brand);
        $classes_brand = implode(' ', $classes_brand);
    } else {
        $classes_brand = config('leaguefy-admin.classes_brand');
    }
@endphp

@php( $dashboard_url = View::getSection('dashboard_url') ?? config('leaguefy-admin.dashboard_url', 'home') )

@if (config('leaguefy-admin.use_route_url', false))
    @php( $dashboard_url = $dashboard_url ? route($dashboard_url) : '' )
@else
    @php( $dashboard_url = $dashboard_url ? url($dashboard_url) : '' )
@endif

<a href="{{ $dashboard_url }}"
    @if($layoutHelper->isLayoutTopnavEnabled())
        class="navbar-brand logo-switch {{ $classes_brand }}"
    @else
        class="brand-link logo-switch {{ $classes_brand }}"
    @endif>

    {{-- Small brand logo --}}
    {{-- <img src="{{ asset(config('leaguefy-admin.logo_img', 'vendor/adminlte/dist/img/AdminLTELogo.png')) }}"
         alt="{{ config('leaguefy-admin.logo_img_alt', 'AdminLTE') }}"
         class="{{ config('leaguefy-admin.logo_img_class', 'brand-image-xl') }} logo-xs"> --}}

    <div class="{{ config('leaguefy-admin.logo_img_class', 'brand-image-xl') }} logo-xs bg-light d-flex justify-content-center align-items-center"
        style="width: 32px; height: 32px; opacity:.8">
        <i class="fas fa-fw fa-trophy text-muted"></i>
    </div>

    {{-- Large brand logo --}}
    {{-- <img src="{{ asset(config('leaguefy-admin.logo_img_xl')) }}"
         alt="{{ config('leaguefy-admin.logo_img_alt', 'AdminLTE') }}"
         class="{{ config('leaguefy-admin.logo_img_xl_class', 'brand-image-xs') }} logo-xl"> --}}
    <div class="{{ config('leaguefy-admin.logo_img_xl_class', 'brand-image-xs') }} logo-xl bg-light d-flex justify-content-center align-items-center"
        style="width: 32px; height: 32px; opacity:.8">
        <i class="fas fa-fw fa-trophy text-muted"></i>
    </div>

</a>
