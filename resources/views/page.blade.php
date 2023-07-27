@extends('leaguefy-admin::master')

@if (config('leaguefy-admin.settings.sidebar'))
    @section('right-sidebar')
        @include('leaguefy-admin::partials.settings.index')
    @stop
@endif
