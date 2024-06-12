@extends('public/layout/layout')
@section('content')
    <!-- Page Header Start -->
    <div class="page-header mb-0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="page-head-content">
                        <h2>Login</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Login</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="col-12">
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header End -->
    <section id="site-content" class="py-5">
        <div class="container">
            <div class="row">
                <div class="offset-md-4 col-md-4 offset-sm-1 col-sm-10">
                    <form class="contact-form position-relative" id="user-login">
                        <h3 class="mb-4">Welcome</h3>
                        @csrf
                        <div class="message"></div>
                        <div class="form-group mb-3">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Email Your Email">
                        </div>
                        <div class="form-group mb-3">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Enter Your Password">
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary mb-2 btn">Login</button>
                            <span class="forgot"><a href="{{ url('forgot-password') }}">forgot password?</a></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
