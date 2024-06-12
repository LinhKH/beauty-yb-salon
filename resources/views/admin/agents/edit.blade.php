@extends('admin.layout')
@section('title','Edit Agent')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
@component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard','Agent'=>'admin/agents']])
    @slot('title') Edit Agent @endslot
    @slot('add_btn')  @endslot
    @slot('active') Edit Agent @endslot
@endcomponent
<!-- Main content -->
<section class="content card">
    <div class="container-fluid card-body">
        <!-- form start -->
        <form class="form-horizontal" id="updateAgent" method="POST" enctype="multipart/form-data">
            @csrf
            {{ method_field('PUT') }}
            @if($agent)
            <div class="row">
                <!-- column -->
                <div class="col-md-12">
                    <input type="hidden" class="url" value="{{url('admin/agents/'.$agent->id)}}" >
                    <!-- jquery validation -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Agent Details</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-10">
                                    <div class="form-group mb-4">
                                        <label>Image </label>
                                        <div class="custom-file">
                                            <input type="hidden" class="custom-file-input" name="old_img" value="{{$agent->agent_image}}" />
                                            <input type="file" class="custom-file-input" name="img" onChange="readURL(this);">
                                            <label class="custom-file-label">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2 text-center">
                                    @if($agent->agent_image != '')
                                    <img id="image" src="{{asset('public/agents/'.$agent->agent_image)}}" alt="" width="100px" height="80px">
                                    @else
                                    <img id="image" src="{{asset('public/agents/default.png')}}" alt="" width="100px" height="80px">
                                    @endif
                                </div>
                                <!-- <div class="col-10">
                                    <div class="form-group mb-4">
                                        <label>Image </label>
                                        <div class="custom-file">
                                            <input type="hidden" class="custom-file-input" name="old_img" value="{{$agent->image}}" />
                                            <input type="file" class="custom-file-input" name="img" onChange="readURL(this);">
                                            <label class="custom-file-label">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2 text-center">
                                    @if($agent->agent_image != '')
                                    <img id="image" src="{{asset('public/agents/'.$agent->agent_image)}}" alt="" width="100px" height="80px">
                                    @else
                                    <img id="image" src="{{asset('public/agents/default.png')}}" alt="" width="100px" height="80px">
                                    @endif
                                </div> -->
                                <div class="col-md-4 col-12">
                                    <div class="form-group mb-4">
                                        <label>Name <small class="text-danger">*</small></label>
                                        <input type="text" class="form-control" name="name" value="{{$agent->name}}" placeholder="Enter Agent Name">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group mb-4">
                                        <label>Experience (Years)</label>
                                        <input type="number" class="form-control" name="experience" value="{{$agent->experience}}">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group mb-4">
                                        <label>Status <small class="text-danger">*</small></label>
                                        <select name="status" class="form-control">
                                            <option value="" selected disabled>Select Status</option>    
                                            <option value="1" {{($agent->status == "1" ? "selected":"") }}>Active</option>
                                            <option value="0" {{($agent->status == "0" ? "selected":"") }}>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- <div class="col-md-6 col-12">
                                    <div class="form-group mb-4">
                                        <label>Total Bookings</label>
                                        <input type="number" class="form-control" name="booking" value="">
                                    </div>
                                </div> -->
                                <div class="col-md-12 col-12">
                                    <div class="form-group mb-4">
                                        <label>Description</label>
                                        <textarea type="text" class="form-control" name="description" rows="6">{!!htmlspecialchars_decode($agent->description)!!}</textarea>
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