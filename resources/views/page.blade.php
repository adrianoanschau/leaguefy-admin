@extends('leaguefy-admin::master')

@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('vendor/leaguefy-admin/nprogress/nprogress.css') }}">
    @stack('css')
    @yield('css')
@stop

@section('classes_body', $layoutHelper->makeBodyClasses())

@section('body_data', $layoutHelper->makeBodyData())

@section('body')
    <div class="wrapper">

        {{-- Preloader Animation --}}
        @if($layoutHelper->isPreloaderEnabled())
            @include('leaguefy-admin::partials.common.preloader')
        @endif

        {{-- Top Navbar --}}
        @if($layoutHelper->isLayoutTopnavEnabled())
            @include('leaguefy-admin::partials.navbar.navbar-layout-topnav')
        @else
            @include('leaguefy-admin::partials.navbar.navbar')
        @endif

        {{-- Left Main Sidebar --}}
        @if(!$layoutHelper->isLayoutTopnavEnabled())
            @include('leaguefy-admin::partials.sidebar.left-sidebar')
        @endif

        {{-- Content Wrapper --}}
        @empty($iFrameEnabled)
            @include('leaguefy-admin::partials.cwrapper.cwrapper-default')
        @else
            @include('leaguefy-admin::partials.cwrapper.cwrapper-iframe')
        @endempty

        {{-- Footer --}}
        @hasSection('footer')
            @include('leaguefy-admin::partials.footer.footer')
        @endif

        {{-- Right Control Sidebar --}}
        @if(config('adminlte.right_sidebar'))
            @include('leaguefy-admin::partials.sidebar.right-sidebar')
        @endif

    </div>
@stop

@section('adminlte_js')
    <script src="{{ asset('vendor/leaguefy-admin/axios/axios.min.js') }}"></script>
    <script src="{{ asset('vendor/leaguefy-admin/nprogress/nprogress.js') }}"></script>
    <script src="{{ asset('vendor/leaguefy-admin/js/helpers.js') }}"></script>
    <script src="{{ asset('vendor/leaguefy-admin/js/leaguefy-admin.js') }}"></script>
    @stack('js')
    @yield('js')
@stop
