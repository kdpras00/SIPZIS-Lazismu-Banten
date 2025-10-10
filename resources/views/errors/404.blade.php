@extends('layouts.app')

@section('title', 'Page Not Found')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">404 - Page Not Found</div>
                <div class="card-body text-center">
                    <h1 class="display-1">404</h1>
                    <p class="lead">Oops! The page you're looking for doesn't exist.</p>
                    <p>The requested URL was not found on this server.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection