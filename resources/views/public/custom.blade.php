@extends('public/layout/layout')
@section('content')
<!-- Page Header Start -->
<div class="page-header mb-0">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-head-content">
                    <h2>{{$page->page_title}}</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$page->page_title}}</li>
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
            <div class="col-md-12">
                {!!htmlspecialchars_decode($page->description)!!}
            </div>
        </div>
    </div>
</section>
@endsection