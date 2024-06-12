<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay with AuthorizeNet</title>
    <link rel="stylesheet" href="{{asset('public/assets/public/css/bootstrap5.0.min.css')}}">
    <link href="{{asset('public/assets/public/css/fontawesome.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('public/assets/public/css/style.css')}}">
    <script src="{{asset('public/assets/public/js/jquery.min.js')}}"></script>
    <script src="http://igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js"></script>
    <style>
        #wrapper{
            padding-top: 100px;
        }

        #wrapper img{
            padding-top: 100px;
        }
    </style>
    <script>
        $(function(){
            $('#cardNo').mask('0000 0000 0000 0000');
        });
    </script>
</head>
<body>
    <div id="wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img src="{{asset('public/payment/authorizenet.png')}}" alt="" class="w-100">
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title mb-0">Pay with Authorize.net</h3>
                        </div>
                        <div class="card-body">
                            <form role="form" class="form-content row positon-relative" action="{{url('appointment/checkout/status')}}" method="POST">
                                @csrf
                                @if ($errors->any())
                                    @foreach ($errors->all() as $error)
                                        <div class="alert alert-danger">{{$error}}</div>
                                    @endforeach
                                @endif
                                <div class="col-12 form-group mb-3">
                                    <label for="">Full Name (on the card)</label>
                                    <input type="text" class="form-control" name="fullName" placeholder="Full Name">
                                </div>
                                <div class="col-12 form-group mb-3">
                                    <label for="">Card Number</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="cardNumber" placeholder="Card Number" size="20">
                                        <div class="input-group-append">
                                            <span class="input-group-text text-muted">
                                            <i class="fab fa-cc-visa fa-lg pr-1"></i>
                                            <i class="fab fa-cc-amex fa-lg pr-1"></i>
                                            <i class="fab fa-cc-mastercard fa-lg"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4 form-group mb-3">
                                    <label for="">Expiry Month</label>
                                    <select name="month" class="form-control">
                                        <option value="">MM</option>
                                        @foreach(range(1, 12) as $month)
                                            <option value="{{$month}}">{{$month}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-4 form-group mb-3">
                                    <label for="">Expiry Year</label>
                                    <select name="year" class="form-control">
                                        <option value="" selected disabled>YYYY</option>
                                        @foreach(range(date('Y'), date('Y') + 10) as $year)
                                            <option value="{{$year}}">{{$year}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-4 form-group mb-3">
                                    <label data-toggle="tooltip" title="" data-original-title="3 digits code on back side of the card">CVV <i class="fa fa-question-circle"></i></label>
                                    <input type="number" name="cvv" class="form-control" size="4" placeholder="CVV">
                                </div>
                                <div class="col-4 form-group">
                                    <input type="submit" class="btn btn-primary" value="Pay Now">
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            var loader = `<div class="loader-container">
                    <div class="loader">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>`;
                $('form').submit(function(){
                    $('form').append(loader);
                })
        });
    </script>
</body>
</html>