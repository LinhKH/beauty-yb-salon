@extends('admin.layout')
@section('title','Add New Appointment')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
@component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard','Appointment'=>'admin/appointment']])
    @slot('title') Print Invoice @endslot
    @slot('add_btn')  @endslot
    @slot('active') Print Invoice @endslot
@endcomponent
<!-- Main content -->
<section class="content card">
    <div class="container-fluid card-body">
        <div class="row">
            <!-- column -->
            <div class="col-md-12">
                <!-- jquery validation -->
                <div class="card card-primary">
                    <div class="card-body">
                        <button class="btn btn-success" onclick="PrintDiv();"><i class="fa fa-print"></i></button>
                        <div class="print-box">
                        <div class="invoice-head">
                            <img src="{{asset('public/site-img/'.$siteInfo->com_logo)}}" alt="" width="150px">
                            <h3>{{$siteInfo->com_name}}</h3>
                            <ul>
                                <li>{{$siteInfo->address}}</li>
                                <li>{{$siteInfo->com_email}}</li>
                                <li>{{$siteInfo->com_phone}}</li>
                            </ul>
                        </div>
                        <div class="invoice-body">
                            <div class="left">
                                <table>
                                    <tr>
                                        <td>Invoice No.</td>
                                        <td>{{$appointment->id}}</td>
                                    </tr>
                                    <tr>
                                        <td>Invoice To :</td>
                                        <td>{{$appointment->name}}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="right">
                                <table>
                                    <tr>
                                        <td>Date</td>
                                        <td>{{date('d M, Y',strtotime($appointment->date))}}</td>
                                    </tr>
                                    <tr>
                                        <td>Time</td>
                                        <td>{{$appointment->from_time.' - '.$appointment->to_time}}</td>
                                    </tr>
                                </table>
                            </div>
                            <table class="table table-bordered service-list">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Qty</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $app = 1; $g_total = 0; @endphp
                                    @foreach($appointmentServices as $app_service)
                                    <tr>
                                        <td>{{$app_service->title}}</td>
                                        <td>{{$app_service->qty}}</td>
                                        <td><span class="serviceTotal">{{$app_service->service_price*$app_service->qty}}</span>
                                    </tr>
                                    @php $app++; $g_total += $app_service->service_price*$app_service->qty @endphp
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <th>Grand Total</th>
                                        <td><span class="grandTotal">{{$g_total}}</span></td>
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
                        </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!--/.col -->
        </div>  <!-- /.row -->
    </div><!-- /.container-fluid -->
</section><!-- /.content -->
</div>
@stop