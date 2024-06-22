<section id="banner" >
    <div class="swiper">
        <div class="swiper-wrapper">
            @foreach($banner as $banner)
            <div class="swiper-slide" style="background-image:url({{asset('/banner/'.$banner->banner_image)}})">
                <div class="banner-content mt-auto">
                    <h1>{{$banner->title}}</h1>
                    @if($banner->sub_title != '')<h4>{{$banner->sub_title}}</h4> @endif
                </div>
            </div>
            @endforeach
        </div>
        <div class="swiper-pagination"></div>
    </div>
    <div class="banner-form">
        <form id="appointmentForm" method="GET">
            <div class="form-group">
                <label class="form-label">Services</label>
                <select class="form-control" id="serviceSelect" name="service" required>
                    <option value="" selected disabled>Select Service</option>
                    @php $services = all_services(); @endphp
                    @foreach($services as $types)
                        <option value="{{$types->id}}" data-max="{{$types->avail_space}}">{{$types->title}}</option>
                    @endforeach
                </select>
                @if($errors->has('service'))
                    <div class="alert alert-danger">{{ $errors->first('service') }}</div>
                @endif
            </div>
            <div class="form-group">
                <label class="form-label">Persons</label>
                <input type="number" class="form-control" id="personSelect" name="person" disabled min="1" max="" value="1">
            </div>
            <div class="row">
                <div class="col-sm-6 form-group">
                    <label class="form-label">Date</label>
                    <input type="date" class="form-control" id="dateSelect" name="date" placeholder="Please Enter Date" disabled min="{{date('Y-m-d')}}" value="{{date('Y-m-d')}}">
                </div>
                <div class="col-sm-6 form-group">
                    <label class="form-label">Time</label>
                    <select class="form-control" name="time" id="timeSelect" disabled required>
                        <option value="" selected disabled>Select The Time Slot</option>
                        @php $time = time_slots(); @endphp
                        @foreach($time as $types)
                            <option value="{{$types->id}}">{{$types->from_time}} - {{$types->to_time}}</option>
                        @endforeach
                    </select>
                    @if($errors->has('time'))
                        <div class="alert alert-danger">{{ $errors->first('time') }}</div>
                    @endif
                </div>
            </div>
            
            <div class="agentsList service-agents-radio">
                
            </div>
            <button type="submit" class="btn btn-primary">Add to Cart</button>
            <div class="message"></div>
        </form>    
    </div>
</section>