
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>invoice</title>

        <!-- Custom fonts for this template -->
        <link href="{{asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
        <link
            href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
            rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="{{asset('css/sb-admin-2.min.css')}}" rel="stylesheet">

        <!-- Custom styles for this page -->
        <link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">

        <!-- laravel toaster message display -->
        <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">

        <!-- ata requered validation er sob message show er custom link-->
        <link rel="stylesheet" href="/dist/css/custom.css">

        <!-- Js cdn -->
        <script src='http://cdn.jsdelivr.net/npm/jquery@3.7.0/jquery.min.js'></script>
        
        <!-- start axios cdn -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.7.2/axios.min.js" integrity="sha512-JSCFHhKDilTRRXe9ak/FJ28dcpOJxzQaCd3Xg8MyF6XFjODhy/YMCM8HW0TFDckNHWUewW+kfvhin43hKtJxAw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <!-- end axios cdn -->
        
    </head>

    <body id="page-top">

        <!-- Start of Page Wrapper -->
        <div id="wrapper">

            @include('frontend.component.sidebar')

            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">


                <!-- Main Content -->
                @include('frontend.component.topbar')
                
                
                    
                <!-- svg +icon a click er age jei title text ase tar code -->
                    <div class="card-body" id="additionalText" style="display: none;"> </div>
                        <script>
                            $(document).ready(function(){
                                // Initialize Bootstrap tooltips
                                $('[data-toggle="tooltip"]').tooltip();

                                // Toggle additional text when icon is clicked
                                $('#iconLink').click(function(){
                                $('#additionalText').toggle();
                                });
                            });
                        </script>
                <!-- svg +icon a click er age jei title text ase tar code -->
                    

                @yield('content')

                
                <!-- Footer -->
                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>Copyright Akash Islam &copy; Invoice Website 2024</span>
                        </div>
                    </div>
                </footer>
                <!-- End of Footer -->

            </div>
            <!-- End of Content Wrapper -->

        </div>
        <!-- End of Page Wrapper -->

        

        <!-- start sweetalert Cdn delete alert link  -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <!-- end sweetalert Cdn delete alert link  -->

        <!-- laravel toaster message display -->
        <script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
        
        <!-- Bootstrap core JavaScript-->
        <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

        <!-- Core plugin JavaScript-->
        <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

        <!-- Custom scripts for all pages-->
        <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

        <!-- Page level plugins -->
        <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

        <!-- Page level custom scripts -->
        <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>

        

        @yield('script')



    </body>

</html>


