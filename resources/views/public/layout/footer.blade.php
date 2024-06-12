<footer id="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="footer-widget">
                    @if(settings()->com_logo != '')
                        <img class="mb-2" src="{{asset('public/site-img/'.settings()->com_logo)}}" alt="{{settings()->com_name}}" width="100px">
                    @else
                        <h5 class="logo text-uppercase mb-4"><a href="#">{{settings()->com_name}}</a></h5>
                    @endif
                    <ul class="icon">
                        
                        <!-- @foreach($social_settings as $item)
                            @if($item->instagram != '')  
                                <li><a href="{{$item->instagram}}"><i class="fab fa-instagram"></i></a></li>
                            @endif
                            @if($item->you_tube != '')      
                                <li><a href="you_tube.com"><i class="fab fa-youtube"></i></a></li>
                            @endif
                                @if($item->twitter != '')
                                <li><a href="twitter.com"><i class="fab fa-twitter"></i></a></li>
                            @endif
                            @if($item->facebook != '')
                                <li><a href="facebook.com"><i class="fab fa-facebook"></i></a></li>
                            @endif
                        @endforeach -->
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="footer-widget">
                    <h6 class="text-white text-uppercase mb-4">our services</h6>
                    <ul class="newsfeed text-capitalize">
                        <li><a href="#">business planning</a></li>
                        <li><a href="#">tax strategy</a></li>
                        <li><a href="#">financial advices</a></li>
                        <li><a href="#">insurance strategy</a></li>
                        <li><a href="#">manage investment</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="footer-widget">
                    <h6 class="text-white text-uppercase mb-3">contact us</h6>
                    <ul class="contacts">
                        <li class="mb-2"><i class="fas fa-map-marker-alt"></i>Ta-134/A, Gulshan Badda Link Rd, Dhaka</li>
                        <li class="mb-2"><i class="fa fa-phone"></i><a href="#">(+880)155 69569 365</a></li>
                        <li><i class="far fa-envelope"></i><a href="#">support@rstheme.com</a></li>
                        <li><i class="far fa-clock"></i>Office Hours: 8AM - 11PM</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="footer-widget">
                    <h6 class="text-white text-uppercase mb-4">newsletter</h6>
                    <div class="newsletter mb-4">
                        <p class="mb-4">Stay up to update with our latest news and products.</p>
                        <input type="email" class="form-control mb-3" placeholder="Your email address">
                        <button class="btn text-uppercase" type="submit">Subscribe now</button>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-widget footer-section">
        <div class="container">
            <div class="row">
               
            </div>
        </div>
    </div>
</footer>
</div>
<script src="{{asset('public/assets/public/js/jquery.min.js')}}"></script>
<script src="{{asset('public/assets/public/js/bootstrap5.0.2.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/9.2.4/swiper-bundle.min.js"></script>
<script src="{{asset('public/assets/public/js/sweetalert2.min.js')}}"></script>
<script src="{{asset('public/assets/public/js/jquery.validate.min.js')}}"></script>
<script src="{{asset('public/assets/public/js/action.js')}}"></script>
<input type="hidden" class="base-url" value="{{url('/')}}"></input>
</body>
</html>
