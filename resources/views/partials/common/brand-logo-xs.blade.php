@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')

@php
    if (config()->has('leaguefy-admin.topbar.color')) {
        $classes_brand = config('leaguefy-admin.classes_brand');
        $classes_brand = explode(' ', $classes_brand);
        $classes_brand = array_map(function ($class) {
            if (!Str::of($class)->contains('bg-')) return $class;
            return config('leaguefy-admin.topbar.color');
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
        class="navbar-brand {{ $classes_brand }}"
    @else
        class="brand-link {{ $classes_brand }}"
    @endif>

    {{-- Small brand logo --}}
    <div class="{{ config('leaguefy-admin.logo_img_class', 'brand-image img-circle elevation-3') }} bg-light d-flex justify-content-center align-items-center"
        style="width: 32px; height: 32px; opacity:.8">
        <i class="fas fa-fw fa-trophy text-muted"></i>
    </div>
    {{-- <img src="{{ asset(config('leaguefy-admin.logo_img', 'vendor/adminlte/dist/img/AdminLTELogo.png')) }}"
         alt="{{ config('leaguefy-admin.logo_img_alt', 'AdminLTE') }}"
         class="{{ config('leaguefy-admin.logo_img_class', 'brand-image img-circle elevation-3') }}"
         style="opacity:.8"> --}}

    {{-- Brand text --}}
    <span class="brand-text font-weight-light {{ config('leaguefy-admin.topbar.logo_color', 'text-dark') }} {{ config('leaguefy-admin.classes_brand_text') }}">
        <strong>{!! config('leaguefy-admin.logo', 'Leaguefy Admin') !!}</strong>
    </span>

</a>
