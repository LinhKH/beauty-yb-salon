@extends('admin.layout')
@section('title','Add New Appointment')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
@component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard','Appointment'=>'admin/appointment']])
    @slot('title') Add Appointment @endslot
    @slot('add_btn')  @endslot
    @slot('active') Add Appointment @endslot
@endcomponent
<!-- Main content -->
<section class="content card">
    <div class="container-fluid card-body">
        <!-- form start -->
        <form class="form-horizontal" id="addAppointment"  method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <!-- column -->
                <div class="col-md-12">
                    <!-- jquery validation -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Make Appointment</h3>
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
                                        <label>Client Name <small class="text-danger">*</small></label>
                                        <input type="text" class="form-control" name="c_name" placeholder="Client Name" required>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <!-- phone mask -->
                                    <div class="form-group">
                                        <label>Client Phone <span class="text-danger">*</span></label>
                                        <div class="input-group" >
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                            </div>
                                            <input type="text" name="c_phone" class="form-control"  placeholder="Client Phone" data-inputmask='"mask": "(999) 999-9999"' data-mask>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group mb-4">
                                        <label>Date <small class="text-danger">*</small></label>
                                        <input type="date" class="form-control" name="date" value="{{date('Y-m-d')}}" required>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group mb-4">
                                        <label>Time <small class="text-danger">*</small></label>
                                        <select name="time" class="form-control" required>
                                            <option value="" selected disabled>Select Time Slot</option>
                                            @foreach($time_slot as $time)
                                                <option value="{{$time->id}}">{{$time->from_time.' - '.$time->to_time}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="">Services  <small class="text-danger">*</small></label>
                                    <table class="table table-bordered service-list">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Qty</th>
                                                <th>Price</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <select name="service[]" class="form-control serviceSelect" id="sRow1" required>
                                                        <option value="" selected disabled>Select Service</option>
                                                        @foreach($services as $service)
                                                            <option value="{{$service->id}}">{{$service->title}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" name="qty[]" class="form-control serviceQty" id="sQty1" value="1" min="1" required>
                                                </td>
                                                <td>
                                                    <span class="serviceTotal"></span>
                                                    <input type="text" hidden class="servicePrice">
                                                </td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td></td>
                                                <th>Grand Total</th>
                                                <td><span class="grandTotal"></span></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <button type="button" class="btn btn-dark btn-sm add-service-row" data-id="1">+ Add Service</button>
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
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form> <!-- /.form start -->
    </div><!-- /.container-fluid -->
</section><!-- /.content -->
</div>
@stop