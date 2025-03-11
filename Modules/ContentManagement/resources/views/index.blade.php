@extends('contentmanagement::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>Module: {!! config('contentmanagement.name') !!}</p>
@endsection
