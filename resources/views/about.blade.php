@extends('layouts.app')
@section('title', 'About Us')

@section('content')

  <!-- Hero Start -->
  <div class="container-fluid bg-light py-6 my-6 mt-0" style="
      background: url('img/bg-cover.jpg');
      color: white;height: 379px;
      ">
    <div class="container text-center animated bounceInDown">
    <h1 class="display-1 mb-4" style="color: white">About Us</h1>
    <ol class="breadcrumb justify-content-center mb-0 animated bounceInDown">
      <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
      <li class="breadcrumb-item text-light" aria-current="page">About</li>
    </ol>
    </div>
  </div>
  <!-- Hero End -->

  <!-- About Satrt -->
  <div class="container-fluid py-6">
    <div class="container">
    <div class="row g-5 align-items-center">
      <div class="col-lg-5">
      <img src="img/about1.png" class="img-fluid rounded" alt="Traditional Pickles" />
      </div>
      <div class="col-lg-7">
      <small
        class="d-inline-block fw-bold text-dark text-uppercase bg-light border border-primary rounded-pill px-4 py-1 mb-3">About
        Us</small>
      <h1 class="display-5 mb-4">
        Bringing Authentic Homemade Pickles to You
      </h1>
      <p class="mb-4">
        Our journey began with a passion for preserving traditional
        flavors passed down through generations. Using time-honored
        recipes and handpicked ingredients, we craft each jar of pickle
        with love and authenticity. Every bite is a taste of tradition,
        made just like home.
      </p>
      <div class="row g-4 text-dark mb-5">
        <div class="col-sm-6">
        <i class="fas fa-seedling text-primary me-2"></i>Made with
        Handpicked Ingredients
        </div>
        <div class="col-sm-6">
        <i class="fas fa-leaf text-primary me-2"></i>Authentic &
        Traditional Recipes
        </div>
        <div class="col-sm-6">
        <i class="fas fa-hand-holding-heart text-primary me-2"></i>Homemade with Love & Care
        </div>
        <div class="col-sm-6">
        <i class="fas fa-star text-primary me-2"></i>Rich & Bold Flavors
        in Every Bite
        </div>
      </div>
      <a href="" class="btn btn-primary py-3 px-5 rounded-pill">Know More <i class="fas fa-arrow-right ps-2"></i></a>
      </div>
    </div>
    </div>
  </div>
  <!-- About End -->


  <!-- Team Start -->
  <div class="container-fluid team py-6">
    <div class="container">
    <div class="text-center">
      <small
      class="d-inline-block fw-bold text-dark text-uppercase bg-light border border-primary rounded-pill px-4 py-1 mb-3">Our
      Team</small>
      <h1 class="display-5 mb-5">We have experienced chef Team</h1>
    </div>
    <div class="row g-4">
      <div class="col-lg-3 col-md-6">
      <div class="team-item rounded">
        <img class="img-fluid rounded-top" src="img/chef1.jpg" alt="" />
        <div class="team-content text-center py-3 bg-dark rounded-bottom">
        <h4 class="text-light">chef 1</h4>
        <p class="text-white mb-0">Professional Chef</p>
        </div>
        <div class="team-icon d-flex flex-column justify-content-center m-4">
        <a class="share btn btn-primary btn-md-square rounded-circle mb-2" href=""><i
          class="fas fa-share-alt"></i></a>
        <a class="share-link btn btn-primary btn-md-square rounded-circle mb-2" href=""><i
          class="fab fa-facebook-f"></i></a>
        <a class="share-link btn btn-primary btn-md-square rounded-circle mb-2" href=""><i
          class="fab fa-twitter"></i></a>
        <a class="share-link btn btn-primary btn-md-square rounded-circle mb-2" href=""><i
          class="fab fa-instagram"></i></a>
        </div>
      </div>
      </div>
      <div class="col-lg-3 col-md-6">
      <div class="team-item rounded">
        <img class="img-fluid rounded-top" src="img/chef2.jpg" alt="" />
        <div class="team-content text-center py-3 bg-dark rounded-bottom">
        <h4 class="text-light">Chef 2</h4>
        <p class="text-white mb-0">Professional Chef</p>
        </div>
        <div class="team-icon d-flex flex-column justify-content-center m-4">
        <a class="share btn btn-primary btn-md-square rounded-circle mb-2" href=""><i
          class="fas fa-share-alt"></i></a>
        <a class="share-link btn btn-primary btn-md-square rounded-circle mb-2" href=""><i
          class="fab fa-facebook-f"></i></a>
        <a class="share-link btn btn-primary btn-md-square rounded-circle mb-2" href=""><i
          class="fab fa-twitter"></i></a>
        <a class="share-link btn btn-primary btn-md-square rounded-circle mb-2" href=""><i
          class="fab fa-instagram"></i></a>
        </div>
      </div>
      </div>
      <div class="col-lg-3 col-md-6">
      <div class="team-item rounded">
        <img class="img-fluid rounded-top" src="img/chef3.jpg" alt="" />
        <div class="team-content text-center py-3 bg-dark rounded-bottom">
        <h4 class="text-light">Chef 3</h4>
        <p class="text-white mb-0">Professional Chef</p>
        </div>
        <div class="team-icon d-flex flex-column justify-content-center m-4">
        <a class="share btn btn-primary btn-md-square rounded-circle mb-2" href=""><i
          class="fas fa-share-alt"></i></a>
        <a class="share-link btn btn-primary btn-md-square rounded-circle mb-2" href=""><i
          class="fab fa-facebook-f"></i></a>
        <a class="share-link btn btn-primary btn-md-square rounded-circle mb-2" href=""><i
          class="fab fa-twitter"></i></a>
        <a class="share-link btn btn-primary btn-md-square rounded-circle mb-2" href=""><i
          class="fab fa-instagram"></i></a>
        </div>
      </div>
      </div>
      <div class="col-lg-3 col-md-6">
      <div class="team-item rounded">
        <img class="img-fluid rounded-top" src="img/chef4.jpg" alt="" />
        <div class="team-content text-center py-3 bg-dark rounded-bottom">
        <h4 class="text-light">Chef 4</h4>
        <p class="text-white mb-0">Professional Chef</p>
        </div>
        <div class="team-icon d-flex flex-column justify-content-center m-4">
        <a class="share btn btn-primary btn-md-square rounded-circle mb-2" href=""><i
          class="fas fa-share-alt"></i></a>
        <a class="share-link btn btn-primary btn-md-square rounded-circle mb-2" href=""><i
          class="fab fa-facebook-f"></i></a>
        <a class="share-link btn btn-primary btn-md-square rounded-circle mb-2" href=""><i
          class="fab fa-twitter"></i></a>
        <a class="share-link btn btn-primary btn-md-square rounded-circle mb-2" href=""><i
          class="fab fa-instagram"></i></a>
        </div>
      </div>
      </div>
    </div>
    </div>
  </div>
  <!-- Team End -->
@endsection