@extends('layouts.app')
@section('title', '404')

@section('content')

<!-- Hero Start -->
<div class="container-fluid bg-light py-6 my-6 mt-0" style="
        background: url('img/bg-cover.jpg') no-repeat center center/cover;
        color: white;height: 379px;">
  <div class="container text-center animated bounceInDown">
    <h1 class="display-1 mb-4" style="color: white">404 Error</h1>
    <ol class="breadcrumb justify-content-center mb-0 animated bounceInDown">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item text-light" aria-current="page">404 Error</li>
    </ol>
  </div>
</div>
<!-- Hero End -->


<!-- 404 Start -->
<div class="container-fluid py-6 wow fadeInUp" data-wow-delay="0.1s">
  <div class="container text-center">
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <i class="bi bi-exclamation-triangle display-1 text-primary"></i>
        <h1 class="display-1">404</h1>
        <h1 class="mb-4">Page Not Found</h1>
        <p class="mb-4">We’re sorry, the page you have looked for does not exist in our website! Maybe go to our home
          page or try to use a search?</p>
        <a class="btn btn-primary rounded-pill py-3 px-5" href="">Go Back To Home</a>
      </div>
    </div>
  </div>
</div>
<!-- 404 End -->

@endsection