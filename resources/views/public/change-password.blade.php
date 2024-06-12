@extends('public/layout/layout')
@section('content')
<!-- Page Header Start -->
<div class="page-header mb-0">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-head-content">
                    <h2>Change Password</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Change Password</li>
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
                <form class="change-pwd-form" id="updatePassword" method="POST">
                    @csrf
                    <div class="message"></div>
                    <div class="form-group mb-3">
                        <label>Current Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Enter Current Password Here">
                    </div>
                    <div class="form-group mb-3">
                        <label>New Password</label>
                        <input type="password" class="form-control" name="new_pass" placeholder="Enter New Password Here">
                    </div> 
                    <div class="form-group mb-3">
                        <label>Confirm Password</label>
                        <input type="password" class="form-control" name="new_confirm" placeholder="Confirm New Password Here">
                    </div> 
                    <button type="submit" class="btn">Update</button>
                </form>   
            </div>
        </div>
    </div>
</section>
@endsection