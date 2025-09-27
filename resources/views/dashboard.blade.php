@extends('layouts.main')

@section('navbar')
    @include('partials.navbarHome')
@endsection

@section('content')
    @include('partials.home')
    @include('partials.program')
@endsection