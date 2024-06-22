@extends('admin.layout')
@section('title','Edit Gallery Image')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
@component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard','Gallery Image'=>'admin/gallery_img']])
    @slot('title') Edit Gallery Image @endslot
    @slot('add_btn')  @endslot
    @slot('active') Edit Gallery Image @endslot
@endcomponent
<!-- Main content -->
<section class="content card">
    <div class="container-fluid card-body">
        <!-- form start -->
        <form class="form-horizontal" id="updateGalleryImg"  method="POST" enctype="multipart/form-data">
            @csrf
            {{ method_field('PUT') }}
            @if($gallery)
            <div class="row">
                <!-- column -->
                <div class="col-md-12">
                    <input type="hidden" class="url" value="{{url('admin/gallery_img/'.$gallery->id)}}" >
                    <!-- jquery validation -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Gallery Image Details</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group mb-4">
                                        <label> Gallery Name <small class="text-danger">*</small></label>
                                        <input type="text" class="form-control" name="title" value="{{$gallery->title}}" placeholder="Enter Gallery Image Name">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group mb-4">
                                        <label>Gallery Category <small class="text-danger">*</small></label>
                                        <select class="form-control category" name="category">
                                            <option disabled selected value="" >Select The Category Name</option>
                                            @if(!empty($category))
                                                @foreach($category as $types)
                                                    @if($gallery->category == $types->id)
                                                        <option value="{{$types->id}}" selected>{{$types->title}}</option>
                                                        @else
                                                        <option value="{{$types->id}}">{{$types->title}}</option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="form-group mb-4">
                                        <label>Description</label>
                                        <textarea type="text" class="form-control" name="description" rows="6">{!!htmlspecialchars_decode($gallery->description)!!}</textarea>
                                    </div>
                                </div>
                                <div class="col-10">
                                    <div class="form-group mb-4">
                                        <label>Image </label>
                                        <div class="custom-file">
                                            <input type="hidden" class="custom-file-input" name="old_img" value="{{$gallery->image}}" />
                                            <input type="file" class="custom-file-input" name="img" onChange="readURL(this);">
                                            <label class="custom-file-label">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2 text-center">
                                    @if($gallery->image != '')
                                    <img id="image" src="{{asset('/gallery/'.$gallery->image)}}" alt="" width="100px" height="80px">
                                    @else
                                    <img id="image" src="{{asset('/gallery/default.jpg')}}" alt="" width="100px" height="80px">
                                    @endif
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="form-group mb-4">
                                        <label>Status <small class="text-danger">*</small></label>
                                        <select name="status" class="form-control">
                                            <option value="" selected disabled>Select Status</option>    
                                            <option value="1" {{($gallery->status == "1" ? "selected":"") }}>Publish</option>
                                            <option value="0" {{($gallery->status == "0" ? "selected":"") }}>Draft</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
            @endif
        </form> <!-- /.form start -->
    </div><!-- /.container-fluid -->
</section><!-- /.content -->
</div>
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#image').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    }
</script>
@stop