<!-- /.content-wrapper -->
    <footer class="main-footer">
        <strong>Copyright © 2023 | <a href="https://www.yahoobaba.net" target="_blank">YahooBaba</a></strong>
    </footer>
    <input type="hidden" class="demo" value="{{url('/')}}"></input>
    <!-- ./wrapper -->
    <!-- jQuery UI 1.11.4 -->
    <script src="{{asset('public/assets/js/jquery.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('public/assets/js/bootstrap.bundle.min.js')}}"></script>
    <!-- InputMask -->
    <script src="{{asset('public/assets/js/jquery.inputmask.bundle.min.js')}}"></script> 
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{asset('public/assets/js/moment.min.js')}}"></script>
    <script src="{{asset('public/assets/js/tempusdominus-bootstrap-4.min.js')}}"></script>
    <!-- bs-custom-file-input -->
    <script src="{{asset('public/assets/js/bs-custom-file-input.min.js')}}"></script>
    <!-- daterangepicker -->
    <script src="{{asset('public/assets/js/daterangepicker.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('public/assets/js/adminlte.js')}}"></script>
    
    <!-- jquery-validation -->
    <script src="{{asset('public/assets/js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('public/assets/js/additional-methods.min.js')}}"></script>
    <!-- Summernote -->
    <script src="{{asset('public/assets/js/summernote-bs4.min.js')}}"></script>
    <!-- SweetAlert -->
    <script src="{{asset('public/assets/js/sweetalert2.min.js')}}"></script>
    <script src="{{asset('public/assets/js/image-uploader.js')}}"></script>
    <script src="{{asset('public/assets/js/printThis.js')}}"></script>
    <!-- Main_ajax.js -->
    <script src="{{asset('public/assets/js/main_ajax.js')}}"></script>
    <input type="hidden" class="demo" value="{{url('/')}}"></input>
    <script type="text/javascript">
        $(document).ready(function () {
            bsCustomFileInput.init();
        });
    </script>
    <script>
        $(function () {
            // Summernote
            $('.textarea').summernote()

            //Money Euro
            $('[data-mask]').inputmask()
        })
        function PrintDiv() {   
            $('.print-box').printThis({
                importCSS: false,
                importStyle: true,
                loadCSS: "{{url('/')}}/public/assets/css/style.css",
            });
        }
    </script>
    @yield('pageJsScripts')
</body>
</html>