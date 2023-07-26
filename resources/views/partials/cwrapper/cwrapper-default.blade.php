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

    {{-- Main Content --}}
    <div class="content">
        <div class="{{ config('leaguefy-admin.classes_content') ?: $def_container_class }}">
            <div id="app">
                @yield('content')
            </div>
        </div>
    </div>

    <!--end-pjax-container-->
</main>
