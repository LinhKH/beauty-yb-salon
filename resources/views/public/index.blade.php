@extends('public/layout/layout')
@section('content')
@if($service->isNotEmpty())
<section id="gallery-section" class="pt-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-12">
                <h2 class="section-head"><span>Our</span> Services</h2>
            </div>
        </div>
        <div class="row">
            @foreach($service as $item)
            <div class="col-md-4">
                <div class="service-box">
                    <div class="service-img">
                        <a href="{{url('service/'.$item->slug)}}">
                        @if($item->service_image != '')
                        <img src="{{asset('public/services/'.$item->service_image)}}" alt="{{$item->title}}">
                        @else
                        <img src="{{asset('public/services/default.jpg')}}" alt="{{$item->title}}">
                        @endif
                        </a>
                    </div>
                    <div class="card-footer">
                        <h4><a href="{{url('service/'.$item->slug)}}">{{$item->title}}</a></h4>
                        <ul>
                            <li><i class="fas fa-clock"></i> Duration: {{$item->duration}} Minutes</li>
                            <li><i class="fas fa-dollar-sign"></i> Price/Person: {{$siteInfo->cur_format}}{{$item->price}}</li>
                            <li><i class="fas fa-users"></i> Capacity : {{$item->avail_space}}</li>
                        </ul>
                        <div class="d-grid gap-2">
                            <a href="#header" class="btn btn-lg btn-primary home-book-service" data-id="{{$item->id}}" type="button">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <a href="{{url('services')}}" class="view-all">View All <i class="fa fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
</section>
@endif
@if($agent->isNotEmpty())
    <section id="team-section" class="py-5">
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-12">
                    <h2 class="section-head"><span>Our</span> Team</h2>
                </div>
            </div>
            <div class="row">
                @foreach($agent as $item)
                <div class="col-md-3 mb-3">
                    <div class="team-info">
                        <div class="team-img">
                            @if($item->agent_image != '')
                            <img src="{{asset('public/agents/'.$item->agent_image)}}" alt="{{$item->name}}">
                            @else
                            <img src="{{asset('public/agents/default.png')}}" alt="{{$item->name}}">
                            @endif
                        </div>
                        <div class="team-detail">
                            <h4>{{$item->name}}</h4>
                            <ul>
                                <li>{{$item->title}}</li>
                                <li>Experience : {{$item->experience}} years</li>
                            </ul>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <a href="{{url('agents')}}" class="view-all">View All <i class="fa fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </section>
    @endif
@endsection

