@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="container mt-5">
    <!-- Welcome Message -->
    <h1 class="text-center mb-4">Welcome to the Task-Manager App!</h1>

    <!-- Responsive Image -->
    <div class="text-center">
        <img src="{{ asset('images/welcome-image.jpg') }}" alt="Welcome Image" class="img-fluid" />
    </div>
    
</div>
@endsection
