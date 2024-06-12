@extends('public/layout/layout')
@section('content')
<!-- Page Header Start -->
<div class="page-header mb-0">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-head-content">
                    <h2><span>Contact</span> Us</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="site-content" class="p-5">
    <div class="container">
        <div class="row align-items-start">
            <form class="row col-md-6 form-content position-relative" id="addContact" method="POST">
                @csrf 
                <h3 class="mb-3 fw-bold">Get in Touch</h3>
                <div class="col-md-12 form-group mb-3">
                    <input type="text" class="form-control" name="client" placeholder="Your Name">
                </div>
                <div class="col-md-12 form-group mb-3">
                    <input type="email" class="form-control" name="email" placeholder="Your Email">
                </div>
                <div class="col-md-12 form-group mb-3">
                    <input type="number" class="form-control" name="phone" placeholder="Your Phone Number">
                </div>
                <div class="col-md-12 form-group mb-3">
                    <textarea name="description" class="form-control" cols="20" rows="5" placeholder="Message"></textarea>
                </div>
                <div class="col-md-12 form-group">
                    <input type="submit" class="btn btn-primary" value="Submit">
                </div>
                <div class="message mt-3"></div>
            </form>
            <div class="col-md-6">
                @if($siteInfo->address != '')
                <div class="contact-info">
                    <h5><i class="fa fa-map-marker-alt"></i> Address</h5>
                    <p>{{$siteInfo->address}}</p>
                </div>
                @endif
                @if($siteInfo->com_phone)
                <div class="contact-info">
                    <h5><i class="fa fa-phone"></i> Phone</h5>
                    <p>{{$siteInfo->com_phone}}</p>
                </div>
                @endif
                @if($siteInfo->com_email)
                <div class="contact-info">
                    <h5><i class="far fa-envelope"></i> Email</h5>
                    <p>{{$siteInfo->com_email}}</p>
                </div>
                @endif
                @if($siteInfo->description != '')
                <div class="contact-info">
                    <h5><i class="fa fa-cube"></i> More Info</h5>
                    <p>{{$siteInfo->description}}</p>
                </div>
                @endif
                @if($siteInfo->map != '')
                <div class="contact-info">
                    <h5><i class="far fa-map"></i> Location</h5>
                    <iframe src="{{$siteInfo->map}}" width="100%" height="200" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection