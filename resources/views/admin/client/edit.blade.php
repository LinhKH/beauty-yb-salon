@extends('admin.layout')
@section('title','Edit Client')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
@component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard','Clients'=>'admin/client']])
    @slot('title') Edit Client @endslot
    @slot('add_btn')  @endslot
    @slot('active') Edit Client @endslot
@endcomponent
<!-- Main content -->
<section class="content card">
    <div class="container-fluid card-body">
        <!-- form start -->
        <form class="form-horizontal" id="updateClient"  method="POST" enctype="multipart/form-data">
            @csrf
            {{ method_field('PUT') }}
            @if($client)
            <div class="row">
                <!-- column -->
                <div class="col-md-12">
                    <input type="hidden" class="id" value="{{$client->id}}" >
                    <!-- jquery validation -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Client Details</h3>
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
                                        <label> Client Name <small class="text-danger">*</small></label>
                                        <input type="text" class="form-control" name="name" value="{{$client->name}}" placeholder="Client Name">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group mb-4">
                                        <label>Client Email </label>
                                        <input type="email" class="form-control" name="email" value="{{$client->email}}" placeholder="Client Email">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <!-- phone mask -->
                                    <div class="form-group">
                                        <label>Phone Number <span class="text-danger">*</span></label>
                                        <div class="input-group" >
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                            </div>
                                            <input type="text" name="phone" value="{{$client->phone}}" class="form-control" data-inputmask='"mask": "(999) 999-9999"' data-mask>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group mb-4">
                                        <label>Client Password</label>
                                        <input type="password" class="form-control" name="password" value="" placeholder="Client Password">
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
@stop