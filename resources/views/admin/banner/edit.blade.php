@extends('admin.layout')
@section('title','Edit Banner Slide')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard','Banner Slider'=>'admin/banner-slider']])
        @slot('title') Edit Banner Slide @endslot
        @slot('add_btn') @endslot
        @slot('active') Edit Banner Slide @endslot
    @endcomponent
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- form start -->
            <form class="form-horizontal" id="updateBanner" method="POST">
            {{csrf_field() }}
            {{method_field('PUT')}}
            <input type="text" class="id" value="{{$banner->id}}" hidden>
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- jquery validation -->
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group row">
                                            <label class="col-md-3">Banner Image</label>
                                            <div class="col-md-9">
                                                <input type="hidden" class="custom-file-input" name="old_image" value="{{$banner->banner_image}}" />
                                                <input type="file" hidden class="change-com-img" name="image" onChange="readURL(this);">
                                                @if($banner->banner_image != '')
                                                    <img class="img-thumbnail" id="image" src="{{asset('public/banner/'.$banner->banner_image)}}" width="150px" height="150px">
                                                @else
                                                    <img class="img-thumbnail" id="image" src="{{asset('public/banner/default.jpg')}}" width="150px" height="150px">
                                                @endif 
                                                <button type="button" class="btn btn-info d-block mt-2 change-logo">Change</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Title Name</label>
                                            <input type="text" class="form-control" name="title" value="{{$banner->title}}"  placeholder="Enter Title">
                                        </div>
                                        <div class="form-group">
                                            <label>Sub Title</label>
                                            <input type="text" class="form-control" name="sub_title" value="{{$banner->sub_title}}"  placeholder="Enter Sub Title">
                                            <small>Leave this field empty if you want to hide</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-6">
                                        <div class="form-group mb-4">
                                            <label>Status</label>
                                            <select name="status" class="form-control">
                                                <option value="" selected disabled>Select Status</option>    
                                                <option value="1" {{($banner->status == "1" ? "selected":"") }}>Active</option>
                                                <option value="0" {{($banner->status == "0" ? "selected":"") }}>Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 col-12">
                                        <input type="submit" class="btn btn-primary" value="Update"/>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </form> <!-- /.form start -->
        </div><!-- /.container-fluid -->
    </section><!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script type="text/javascript">
    function readURL(input) {
        if(input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#image').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    }
</script>
@stop