@extends('public/layout/layout')
@section('content')
<!-- Page Header Start -->
<div class="page-header mb-0">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-head-content">
                    <h2>{{$gallery_category->title}} Images</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{url('gallery')}}">Gallery</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{$gallery_category->title}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<section id="site-content" class="py-5">
    <div class="container">
        <div class="row mb-3">
            <div class="col-md-12">
                <ul class="list-group list-group-horizontal">
                    <li class="nav-item me-3">
                        <a href="{{url('gallery')}}" class="btn">All</a>
                    </li>
                    @foreach($category as $row)
                    @if($row->images_count > 0)
                    @php $active = ($row->id == $gallery_category->id) ? 'active' : ''; @endphp
                     <li class="nav-item me-3">
                        <a href="{{url('gallery/'.strtolower($row->title))}}" class="btn {{$active}}">{{$row->title}}</a>
                    </li>
                    @endif
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="row" id="galleryimages">
            @if($gallery->isNotEmpty())
            @foreach($gallery as $gimage)
                <a href="{{asset('public/gallery/'.$gimage->image)}}" class="col-md-4 p-0 gallery-thumb card text-white">
                    <img src="{{asset('public/gallery/'.$gimage->image)}}" alt="<h3>{{$gimage->title}}</h3><p>{{$gimage->description}}</p>">
                    <div class="card-img-overlay">
                        <h5 class="card-title">{{$gimage->title}}</h5>
                    </div>
                </a>
            @endforeach
            @else
                <div class="col-12">
                    <h4>No Images Found</h4>
                </div>
            @endif
        </div>
        <div class="row">
            <div class="col-12">
                {{$gallery->links()}}
            </div>
        </div>
    </div>
</section>
@endsection