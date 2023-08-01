<aside class="control-sidebar control-sidebar-{{ config('leaguefy-admin.right_sidebar_theme') }}">
    @if (config('leaguefy-admin.settings.sidebar'))
        @include('leaguefy-admin::partials.settings.index')
    @endif
</aside>
