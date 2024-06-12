@extends('public/layout/layout')
@section('content')
<!-- Page Header Start -->
<div class="page-header mb-0">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-head-content">
                    <h2>Forgot Password</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Forgot Password</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->
<section id="site-content" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4">
                <form class="form-horizontal" id="client-forgotPassword" method="POST">
                    <h3 class="mb-4">Enter your Email</h3>
                    @csrf
                    <div class="message"></div>
                    <div class="form-group mb-3">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" placeholder="Enter Email Address">
                    </div>
                    <div class="d-flex justify-content-between">
                        <input type="submit" class="btn btn-block mb-4" value="Submit">
                        <span class="create-new"><a href="{{url('login')}}">Back to Login</a></span>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(Session::has('loginError'))
                    <div class="alert alert-danger">
                        {{Session::get('loginError')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection