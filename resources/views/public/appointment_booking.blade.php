@extends('public/layout/layout')
@section('content')
<!-- Page Header Start -->
<div class="page-header mb-0">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-head-content">
                    <h2>Appointment Booking</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Appointment Booking</li>
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
            <div class="col-md-12 d-flex justify-content-center mb-3">
            </div>
        </div>
        <div class="row">
            <div class="offset-0 col-12 offset-sm-2 col-sm-8 offset-md-2 col-md-8">
                <form id="client_form" action="{{url('appointment')}}" class="border" method="POST">
                    @csrf
                <table class="table table-bordered">
                    <tr>
                        <td>Date</td>
                        <td>{{$date}}</td>
                        <td>Time</td>
                        <td>{{$time->from_time.' - '.$time->to_time}}</td>
                    </tr>
                </table>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Service</th>
                            <th>Agent</th>
                            <th>Persons</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $g_total = 0;  @endphp
                        @foreach($service as $key => $value)
                        <tr>
                            <td>{{$services[$value]->title}}
                            <input type="text" hidden name="service[]" value="{{$services[$value]->id}}"></td>
                            <td>@if(!empty($agent_id) && isset($agent_id[$key]))
                                {{$agents[$agent_id[$key]]->name}}
                                <input type="text" hidden name="agent[]" value="{{$agents[$agent_id[$key]]->id}}">
                            @else
                                Any Agent
                                <input type="text" hidden name="agent[]" value="0">
                            @endif
                            </td>
                            <td>{{$qty[$key]}}
                            <input type="text" hidden name="qty[]" value="{{$qty[$key]}}"></td>
                            <td>{{$siteInfo->cur_format}}{{$services[$value]->price}}</td>
                            <td>{{$siteInfo->cur_format}}{{$services[$value]->price*$qty[$key]}}</td>
                            @php $g_total += $services[$value]->price*$qty[$key];  @endphp
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4">Grand Total</td>
                            @php session()->put('grand_total', $g_total); @endphp
                            <td>{{$siteInfo->cur_format}}{{$g_total}}</td>
                        </tr>
                        <tr>
                            <th colspan="4">Advance Payment ({{$siteInfo->booking_amount}}%)</th>
                            <th>{{$siteInfo->cur_format}}{{ceil($g_total*$siteInfo->booking_amount/100)}}
                            <input type="text" hidden name="advance_payment" value="{{ceil($g_total*$siteInfo->booking_amount/100)}}"></th>
                        </tr>
                    </tfoot>
                </table>
                    <input type='text' hidden id="date" name="date" class="form-control date" value="{{$date}}"/>
                    <input type='text' hidden id="time" name="time" class="form-control time" value="{{$time->id}}"/>
                    @If(session()->has('id'))
                        <table class="table table-bordered">
                            <tr>
                                <td>Client Name</td>
                                <td>{{session()->get('name')}}</td>
                            </tr>
                            <tr>
                                <td>Client Phone</td>
                                <td>{{$client->phone}}</td>
                            </tr>
                            <tr>
                                <td>Client Email</td>
                                <td>{{$client->email}}</td>
                            </tr>
                        </table>
                    @else
                    <span class="mb-2 d-block">Already Client <a href="{{url('login')}}" class="view-all">Login</a></span>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Client Name</label>
                        <input type="text" name="client" class="form-control client">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control email">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Phone</label>
                        <input type="number" name="phone" class="form-control phone">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Set Password</label>
                        <input type="password" name="pass" id="password" class="form-control">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Set Confirm Password</label>
                        <input type="password" name="con_pass" class="form-control">
                    </div>
                    @endif
                    @php $payment_methods = payment_methods(); @endphp
                    @if($payment_methods->isNotEmpty())
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Pay With</label>
                        <ul class="pay-method-list">
                            @php $i=0; @endphp
                            @foreach($payment_methods as $pay_method)
                            <li>
                                <input type="radio" id="{{$pay_method->payment_name}}" name="pay_method" value="{{strtolower($pay_method->payment_name)}}" @if($i==1) checked @endif required>
                                <label for="{{$pay_method->payment_name}}">
                                    <img src="{{asset('public/payment/'.$pay_method->payment_img)}}">
                                </label>
                                
                                <input type="text" hidden name="razor_payid" value="">
                                <input type="text" hidden name="pay_with_razorpay" value="1">
                                <input type="text" hidden name="razor_key" value="{{env('RAZOR_KEY')}}">
                                
                            </li>
                            @php $i++; @endphp
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-md-12 mb-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                    @else
                        <h4>No Payment methods found try after sometime :)</h4>
                    @endif
                </form>   
            </div>    
        </div>
    </div>
</div>
@endsection
@section('pageScripts')
<script src="https://checkout.razorpay.com/v1/checkout.js" type="text/javascript"></script>
<script>
    $(document).ready(function(){
        $('input[name=pay_method]').change(function(){
            var val = $('input[name=pay_method]:checked').val();
            if(val === 'razorpay'){
                $('input[name=pay_with_razorpay]').val('1');
            }else{
                $('input[name=pay_with_razorpay]').val('0');
            }
        });


        $('#client_form').submit(function(e){
            if($('input[name=pay_with_razorpay]').val() == '1'){
                e.preventDefault();
                var amount = $('input[name=advance_payment]').val();
                var razorpay = new Razorpay({
                    key: $('input[name=razor_key]').val(),
                    amount: parseInt(amount)*100, 
                    name: 'Service Purchase',
                    order_id: '',
                    handler: function (transaction) {
                        var tr = transaction.razorpay_payment_id;
                        $('input[name=razor_payid]').val(tr);
                        $('input[name=pay_with_razorpay]').val('0');
                        $('#client_form').submit();
                    }
                });
                razorpay.open();
            }
        })
    });
    
</script>
@stop