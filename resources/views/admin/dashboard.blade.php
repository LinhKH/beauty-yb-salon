@extends('admin.layout')
@section('title','Dashboard')
@section('content')
<!-- Main content -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0 text-dark">Dashboard</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Agents</span>
                        <span class="info-box-number">{{$agents}}</span>    
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-cubes"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Services</span>
                        <span class="info-box-number">{{$services}}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <!-- fix for small devices only -->
            <div class="clearfix hidden-md-up"></div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-users"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total Clients</span>
                    <span class="info-box-number">{{$clients}}</span>
                </div>
                <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fa fa-calendar" style="color:#fff;"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Appointments</span>
                            <span class="info-box-number">{{$appointments}}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
              <!-- TABLE: LATEST ORDERS -->
            <div class="card">
                <div class="card-header border-transparent">
                    <h3 class="card-title">Latest Appointments</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <div class="table-responsive">
                    <table class="table m-0 table-bordered">
                        <thead>
                            <tr>
                            <th>S No.</th>
                            <th>Client</th>
                            <th>Date / Time</th>
                            <th>Services Total</th>
                            <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i=1; @endphp
                            @foreach($today_appointments as $row)
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$row->client_detail->name}}<br><small><i class="fa fa-phone"></i> : {{$row->client_detail->phone}}</small></td>
                                <td>{{date('Y-m-d',strtotime($row->date))}}<br><small>@ : {{$row->from_time}} - {{$row->to_time}}</small></td>
                                <td>
                                    @foreach($row?->services as $service)
                                    <br><small class="badge badge-success">{{$service->service_name->title}}</small>
                                    @endforeach
                                    
                                </td>
                                </td>
                                <td>
                                    @if($row->service_status == '0')
                                    <span class="badge bg-warning">pending</span>
                                    @elseif($row->service_status == '1')
                                    <span class="badge bg-info">in progress</span>
                                    @else
                                    <span class="badge bg-success">completed</span>
                                    @endif
                                </td>
                            </tr>
                            @php $i++; @endphp
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                    <!-- /.table-responsive -->
                    </div>
                    <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@stop