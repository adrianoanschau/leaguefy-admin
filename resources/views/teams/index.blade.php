@extends('leaguefy-admin::page')

@section('content_header')
  <h1>Teams</h1>
@stop

@section('content')
    <x-leaguefy-admin::grid name="team" :$columns :$data />
@endsection
