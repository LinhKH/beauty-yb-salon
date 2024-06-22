@extends('admin.layout')
@section('title','Add Banner Slide')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard','Banner Slider'=>'admin/banner-slider']])
        @slot('title') Add Banner Slide @endslot
        @slot('add_btn') @endslot
        @slot('active') Add Banner Slide @endslot
    @endcomponent
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- form start -->
            <form class="form-horizontal" id="addBanner" method="POST">
            {{csrf_field() }}
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group row">
                                            <label class="col-md-3">Banner Image</label>
                                            <div class="col-md-9">
                                                <input type="file" hidden class="change-com-img" name="image" onChange="readURL(this);">
                                                <img class="img-thumbnail" id="image" src="{{asset('/banner/default.jpg')}}" width="150px" height="150px">
                                                <button type="button" class="btn btn-info d-block mt-2 change-logo">Change</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Title <small class="text-danger">*</small></label>
                                            <input type="text" class="form-control" name="title"  placeholder="Enter Title">
                                        </div>
                                        <div class="form-group">
                                            <label>Sub Title</label>
                                            <input type="text" class="form-control" name="sub_title"  placeholder="Enter Sub Title">
                                            <small>Leave this field empty if you want to hide</small>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group col-md-4 col-12">
                                        <input type="submit" class="btn btn-primary" value="Submit"/>
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