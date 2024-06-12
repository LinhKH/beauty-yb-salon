@extends('public/layout/layout')
@section('content')
<!-- Page Header Start -->
<div class="page-header mb-0">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-head-content">
                    <h2>{{$service->title}}</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{url('/services')}}">Services</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$service->title}}</li>
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
            <div class="col-md-3">
                @if($service->service_image != '')
                <img src="{{asset('public/services/'.$service->service_image)}}" alt="{{$service->title}}" width="100%">
                @else
                <img src="{{asset('public/services/default.jpg')}}" alt="{{$service->title}}" width="100%">
                @endif
            </div>
            <div class="col-md-9 service-box">
                <ul>
                    <li><i class="fas fa-clock"></i> Duration : {{$service->duration}} minutes</li>
                    <li><i class="fas fa-dollar-sign"></i> Price/Person : {{$siteInfo->cur_format}}{{$service->price}} </li>
                    <li><i class="fas fa-users"></i> Capacity/Service : {{$service->avail_space}} </li>
                    <li>{!!htmlspecialchars_decode($service->description)!!}</li>
                </ul>
                <button class="btn btn-primary single-service-book" data-id="{{$service->id}}" data-max="{{$service->avail_space}}" >Book Now</button>
                @php $images = array_filter(explode(',',$service->images));
                $images_count = count($images);
                @endphp
                @if($images_count > 0)
                <h4 class="mt-5 mb-3">Images</h4>
                <div class="service-images" id="servicegallery">
                    @for($i=0;$i<$images_count;$i++)
                        <a href="{{asset('public/services/'.$images[$i])}}">
                            <img src="{{asset('public/services/'.$images[$i])}}" alt="">
                        </a>
                    @endfor
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@include('public.partials.single-service-book')
@endsection
