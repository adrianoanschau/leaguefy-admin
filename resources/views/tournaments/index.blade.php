@extends('leaguefy-admin::page')

@section('content_header')
  <h1>Tournaments</h1>
@stop

@section('content')
    <x-leaguefy-admin::grid :$columns :$data />
@endsection
