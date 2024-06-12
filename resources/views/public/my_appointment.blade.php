@extends('public/layout/layout')
@section('content')
<!-- Page Header Start -->
<div class="page-header mb-0">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-head-content">
                    <h2>My Appointments</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">My Appointments</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->
<section id="site-content" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if($appointments->isNotEmpty())
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>S.No.</th>
                            <th>Appointment No.</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Services</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i=1; @endphp
                        @foreach($appointments as $row)
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$row->id}}</td>
                            <td>{{date('d M, Y',strtotime($row->date))}}</td>
                            <td>{{$row->timing->from_time}} - {{$row->timing->to_time}}</td>
                            <td>
                                <ul>
                                @foreach($row->services as $service)
                                    <li>{{$service->service_name->title}}</li>
                                @endforeach
                                </ul>
                            </td>
                            <td>
                                @if($row->service_status == '0')
                                <span class="badge bg-warning">Pending</span>
                                @elseif($row->service_status == '1')
                                <span class="badge bg-info">In Progress</span>
                                @else
                                <span class="badge bg-success">Completed</span>
                                @endif
                            </td>
                        </tr>
                        @php $i++; @endphp
                        @endforeach
                    </tbody>
                </table>
                {{$appointments->links()}}
                @else
                <div class="text-center">
                    <h4>No Appointments Found</h4>
                    <a href="{{url('/')}}" class="btn">Book Now</a>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection