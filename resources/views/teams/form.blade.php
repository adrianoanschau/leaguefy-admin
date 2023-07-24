@extends('leaguefy-admin::page')

@section('content_header')
  <h1>New Team</h1>
@stop

@section('content')
    <x-leaguefy-admin::form name="team" :$fields :id="@$id" :data="@$data" />
@endsection
