@extends('layouts.web')

@section('title', 'Home')

@section('content')
<div class="hero-section py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold">Welcome to {{ config('app.name', 'Laravel') }}</h1>
                <p class="lead">Your amazing website description goes here.</p>
                <a href="#" class="btn btn-primary btn-lg">Get Started</a>
            </div>
            <div class="col-lg-6">
                <img src="https://via.placeholder.com/600x400" alt="Hero Image" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<div class="features-section py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Feature 1</h5>
                        <p class="card-text">Description of feature 1.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Feature 2</h5>
                        <p class="card-text">Description of feature 2.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Feature 3</h5>
                        <p class="card-text">Description of feature 3.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
