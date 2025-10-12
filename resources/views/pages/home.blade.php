@extends('layouts.main')

@section('navbar')
@include('partials.navbarHome')
@endsection

@section('content')
@auth
@if(Auth::user()->role === 'admin' || Auth::user()->role === 'staff')
<!-- Redirect admin/staff users to dashboard -->
<script>
    window.location.href = "{{ route('dashboard') }}";
</script>
@else
@include('partials.home')
@endif
@else
@include('partials.home')
@endauth
@endsection