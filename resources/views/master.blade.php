@extends('leaguefy-admin::base')

@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('vendor/leaguefy-admin/nprogress/nprogress.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/leaguefy-admin/toastify/toastify.css') }}">
    @stack('css')
    @yield('css')
@stop

@section('classes_body', $layoutHelper->makeBodyClasses())

@section('body_data', $layoutHelper->makeBodyData())

@section('body')

    <script src="{{ asset('vendor/leaguefy-admin/axios/axios.min.js') }}"></script>
    <script src="{{ asset('vendor/leaguefy-admin/nprogress/nprogress.js') }}"></script>
    <script src="{{ asset('vendor/leaguefy-admin/swal/swal.js') }}"></script>
    <script src="{{ asset('vendor/leaguefy-admin/toastify/toastify.js') }}"></script>

    <script src="{{ asset('vendor/leaguefy-admin/leaguefy-admin/js/helpers.js') }}"></script>
    <script src="{{ asset('vendor/leaguefy-admin/leaguefy-admin/js/leaguefy-admin.js') }}"></script>
    <script src="{{ asset('vendor/leaguefy-admin/leaguefy-admin/js/leaguefy-admin-swal.js') }}"></script>
    <script src="{{ asset('vendor/leaguefy-admin/leaguefy-admin/js/leaguefy-admin-form.js') }}"></script>
    <script src="{{ asset('vendor/leaguefy-admin/leaguefy-admin/js/leaguefy-admin-toastr.js') }}"></script>
    <script src="{{ asset('vendor/leaguefy-admin/leaguefy-admin/js/leaguefy-admin-tournaments.js') }}"></script>

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
        {{-- @empty($iFrameEnabled)
            @include('leaguefy-admin::partials.cwrapper.cwrapper-default')
        @else
            @include('leaguefy-admin::partials.cwrapper.cwrapper-iframe')
        @endempty --}}

        {{-- Content Wrapper --}}
        @inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')

        @if($layoutHelper->isLayoutTopnavEnabled())
            @php( $def_container_class = 'container' )
        @else
            @php( $def_container_class = 'container-fluid' )
        @endif

        {{-- Default Content Wrapper --}}
        <main id="main" class="content-wrapper {{ config('leaguefy-admin.classes_content_wrapper', '') }}">
            <!--start-pjax-container-->

            {{-- Content Header --}}
            @hasSection('content_header')
                <div class="content-header">
                    <div class="{{ config('leaguefy-admin.classes_content_header') ?: $def_container_class }}">
                        @yield('content_header')
                    </div>
                </div>
            @endif

            <div class="border-top m-3"></div>

            {{-- Main Content --}}
            <div class="content">
                <div class="{{ config('leaguefy-admin.classes_content') ?: $def_container_class }}">
                    @include('leaguefy-admin::partials.common.alerts')
                    <div id="app">
                        @yield('content')
                    </div>

                    @include('leaguefy-admin::partials.common.toastr')
                </div>
            </div>

            <!--end-pjax-container-->
        </main>

        {{-- Footer --}}
        @include('leaguefy-admin::partials.footer.footer')

        {{-- Right Control Sidebar --}}
        @if(config('leaguefy-admin.right_sidebar'))
            @include('leaguefy-admin::partials.sidebar.right-sidebar')
        @endif

        @section('adminlte_js')
            @stack('js')
            @yield('js')
        @stop

    </div>
@stop
