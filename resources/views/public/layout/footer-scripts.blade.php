<script src="{{asset('public/assets/public/js/jquery.min.js')}}"></script>
<input type="hidden" class="base-url" value="{{url('/')}}"></input>
<script src="{{asset('public/assets/public/js/bootstrap5.0.2.min.js')}}"></script>
<script src="{{asset('public/assets/public/js/swiper.min.js')}}"></script>
<script src="{{asset('public/assets/public/js/lightgallery.min.js')}}"></script>
<script src="{{asset('public/assets/public/js/lg-fullscreen.min.js')}}"></script>
<script src="{{asset('public/assets/public/js/lg-zoom.min.js')}}"></script>
<script src="{{asset('public/assets/public/js/lg-share.min.js')}}"></script>
<script src="{{asset('public/assets/public/js/lg-thumbnail.min.js')}}"></script>
<script src="{{asset('public/assets/public/js/jquery.validate.min.js')}}"></script>
<script src="{{asset('public/assets/public/js/action.js')}}"></script>
<script type="text/javascript">
        lightGallery(document.getElementById('footergallery'), {
            plugins: [lgZoom,lgFullscreen,lgShare,lgThumbnail],
            speed: 500,
            download : false,
            fullscreen : false,
        });
        lightGallery(document.getElementById('servicegallery'), {
            plugins: [lgZoom,lgFullscreen,lgShare,lgThumbnail],
            speed: 500,
            download : false,
            fullscreen : false,
        });
        lightGallery(document.getElementById('galleryimages'), {
            plugins: [lgZoom,lgFullscreen,lgShare,lgThumbnail],
            speed: 500,
            download : false,
            fullscreen : false,
        });

        $(function(){
            const swiper = new Swiper('.swiper', {
            // Optional parameters
            direction: 'horizontal',
            loop: true,
            // If we need pagination
            pagination: {
                el: '.swiper-pagination',
            },
            autoplay: {
                delay: 5000,
            },
        });
        })
</script>
@yield('pageScripts')