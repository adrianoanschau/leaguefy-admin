@extends('leaguefy-admin::page')

@section('content_header')
  <h1>New Game</h1>
@stop

@section('content')
    <x-leaguefy-admin::form name="game" :$fields :id="@$id" :data="@$data" />
@endsection
