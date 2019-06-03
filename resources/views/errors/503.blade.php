@extends('layouts.error')

@section('content')
@php
var_dump($exception);
@endphp
<h1 class="font-s128 font-w300 text-smooth animated rollIn">503</h1>
<h2 class="h3 font-w300 push-50 animated fadeInUp">We are sorry but our service is currently not available..</h2>
@endsection
