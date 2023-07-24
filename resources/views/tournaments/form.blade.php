@extends('leaguefy-admin::page')

@section('content_header')
  <h1>New Tournament</h1>
@stop

@section('content')
    <x-leaguefy-admin::form name="tournament" :$fields :id="@$id" :data="@$data" />
@endsection
