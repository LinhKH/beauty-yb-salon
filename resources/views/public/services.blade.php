@extends('public/layout/layout')
@section('content')
<!-- Page Header Start -->
<div class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-head-content">
                    <h2><span>Our</span> Services</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Our services</li>
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
            @foreach($service as $item)
            <div class="col-md-4">
                <div class="service-box">
                    <div class="service-img">
                        <a href="{{url('service/'.$item->slug)}}">
                        @if($item->service_image != '')
                        <img src="{{asset('/services/'.$item->service_image)}}" alt="{{$item->title}}">
                        @else
                        <img src="{{asset('/services/default.jpg')}}" alt="{{$item->title}}">
                        @endif
                        </a>
                    </div>
                    <div class="card-footer">
                        <h4><a href="{{url('service/'.$item->slug)}}">{{$item->title}}</a></h4>
                        <ul>
                            <li><i class="fas fa-clock"></i> Duration: {{$item->duration}} Minutes</li>
                            <li><i class="fas fa-dollar-sign"></i> Price: {{$siteInfo->cur_format}}{{$item->price}}</li>
                            <li><i class="fas fa-users"></i> Capacity : {{$item->avail_space}}</li>
                        </ul>
                        <div class="d-grid gap-2">
                            <a href="javascript:void(0);" class="btn btn-lg btn-primary single-service-book" data-id="{{$item->id}}" data-max="{{$item->avail_space}}">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-12">
                {{$service->links()}}
            </div>
        </div>
    </div>
</section>
@include('public.partials.single-service-book')
@endsection