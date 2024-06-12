@extends('admin.layout')
@section('title','Edit Appointment')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
@component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard','Appointment'=>'admin/appointment']])
    @slot('title') Edit Appointment @endslot
    @slot('add_btn')  @endslot
    @slot('active') Edit Appointment @endslot
@endcomponent
<!-- Main content -->
<section class="content card">
    <div class="container-fluid card-body">
        <!-- form start -->
        <form class="form-horizontal" id="updateAppointment"  method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <!-- column -->
                <div class="col-md-12">
                    <!-- jquery validation -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Edit Appointment</h3>
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
                                        {{method_field('PUT')}}
                                        <input type="text" hidden class="app-id" value="{{$appointment->id}}">
                                        <label>Client Name <small class="text-danger">*</small></label>
                                        <input type="text" class="form-control" name="c_name" placeholder="Client Name" value="{{$appointment->name}}" disabled required>
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
                                            <input type="text" name="c_phone" class="form-control" value="{{$appointment->phone}}" placeholder="Client Phone" data-inputmask='"mask": "(999) 999-9999"' disabled data-mask>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group mb-4">
                                        <label>Date <small class="text-danger">*</small></label>
                                        <input type="date" class="form-control" name="date" value="{{$appointment->date}}" required>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group mb-4">
                                        <label>Time <small class="text-danger">*</small></label>
                                        <select name="time" class="form-control" required>
                                            <option value="" selected disabled>Select Time Slot</option>
                                            @foreach($time_slot as $time)
                                                @php $selected = ($time->id == $appointment->time) ? 'selected' : '';  @endphp
                                                <option value="{{$time->id}}" {{$selected}}>{{$time->from_time.' - '.$time->to_time}}</option>
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
                                        @php $app = 1; $g_total = 0; @endphp
                                        @foreach($appointmentServices as $app_service)
                                        <tr>
                                            <td>
                                                <select name="service[]" class="form-control serviceSelect" id="sRow{{$app}}" required>
                                                    <option value="" selected disabled>Select Service</option>
                                                    @foreach($services as $service)
                                                    @php $selected = ($service->id == $app_service->service) ? 'selected' : '';   @endphp
                                                        <option value="{{$service->id}}" {{$selected}}>{{$service->title}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" name="qty[]" class="form-control serviceQty" id="sQty{{$app}}" value="{{$app_service->qty}}" min="1" required>
                                            </td>
                                            <td><span class="serviceTotal">{{$app_service->service_price*$app_service->qty}}</span>
                                                <input type="text" hidden value="{{$app_service->service_price}}" class="servicePrice"></td>
                                            <td>
                                                @if($app > 1)
                                                    <button type="button" class="btn btn-md btn-danger remove-service-row">X</button>
                                                @endif
                                            </td>
                                        </tr>
                                        @php $app++; $g_total += $app_service->service_price*$app_service->qty @endphp
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td></td>
                                            <th>Grand Total</th>
                                            <td><span class="grandTotal">{{$g_total}}</span></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <th>Advance</th>
                                            <td><span>{{$appointment->advance}}</span></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <th>Balance</th>
                                            <td><span>{{$g_total-$appointment->advance}}</span></td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <button type="button" class="btn btn-dark btn-sm add-service-row" data-id="{{$app-1}}">+ Add Service</button>
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
        </form> <!-- /.form start -->
    </div><!-- /.container-fluid -->
</section><!-- /.content -->
</div>
@stop