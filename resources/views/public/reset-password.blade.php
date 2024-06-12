@extends('public/layout/layout')
@section('content')
<!-- Page Header Start -->
<div class="page-header mb-0">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-head-content">
                    <h2>Reset Password</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Reset Password</li>
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
                <form class="form-horizontal" id="client-resetPassword" method="POST">
                    <h3>Enter New Password</h3>
                    @csrf
                    <div class="message"></div>
                    <div class="form-group mb-3">
                        <label class="col-form-label">New Password</label>
                        <input type="hidden" name="id"  class="url" value="{{$client[0]['id']}}">
                        <input type="password" class="form-control" name="password" placeholder="Enter Password">
                    </div>
                    <div class="form-group mb-3">
                        <label class="col-form-label">Confirm Password</label>
                        <input type="password" class="form-control" name="confirm_password" placeholder="Enter Confirm Password">
                    </div>
                    <input type="submit" class="btn btn-block" value="Reset Password">
                </form>
            </div>
        </div>
    </div>
</section>
@endsection