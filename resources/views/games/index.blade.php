@extends('leaguefy-admin::page')

@section('content_header')
  <h1>Games</h1>
@stop

@section('content')
    <x-leaguefy-admin::grid name="game" :$columns :$data />
@endsection
