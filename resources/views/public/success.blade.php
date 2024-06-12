@extends('public/layout/layout')
@section('content')
<!-- Page Header Start -->
<div class="page-header mb-0">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-head-content">
                    <h2>Booking Successfull</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Booking Successfull</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="site-content" class="p-5">
    <div class="container">
        <div class="row">
            <div class="offset-0 col-12 offset-sm-2 col-sm-8 offset-md-3 col-md-6">
                <div class="alert alert-success d-flex justify-content-center">
                    <h4>Your Appointment Booked Successfully</h4>
                </div>
                <a href="{{url('my_appointment')}}" class="btn">View Appointments</a>
            </div> 
        </div>
    </div>
</div>
<script type="text/javascript">
    localStorage.removeItem('client_service');
</script>
@endsection