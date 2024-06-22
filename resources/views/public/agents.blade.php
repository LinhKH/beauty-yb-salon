@extends('public/layout/layout')
@section('content')
<!-- Page Header Start -->
<div class="page-header mb-0">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-head-content">
                    <h2><span>Our</span> Team</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Our Team</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<section id="site-content" class="py-5">
    <div class="container">
        <div class="row">
            @foreach($agent as $item)
            <div class="col-md-4 mb-3">
                <div class="team-info">
                    <div class="team-img">
                        @if($item->agent_image != '')
                        <img src="{{asset('/agents/'.$item->agent_image)}}" alt="{{$item->name}}">
                        @else
                        <img src="{{asset('/agents/default.png')}}" alt="{{$item->name}}">
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
            <div class="col-12">
                {{$agent->links()}}
            </div>
        </div>
    </div>
</section>
@endsection