@extends('technical::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>Module: {!! config('technical.name') !!}</p>
@endsection
