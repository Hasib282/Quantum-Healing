<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Bank Bima Arthonity</title>
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
        <!-- Google Font: Roboto -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
        
        <!-- Font Awesome CDN -->
        <link href="{{ asset('css/fontawesome/css/all.css') }}" rel="stylesheet">
        
        <!-- jQuery Link -->
        <script src="{{ asset('js/jQuery-3.7.1.js') }}"></script>
        <!--  Api Url  -->
        <script>let apiUrl = "{{ config('app.api_url') }}";</script>
        <!-- Common Ajax File Load -->
        <script src="{{ asset('js/ajax/common_ajax/ajax_setup.js') }}"></script>
        {{-- datatable js  --}}
        <script src="{{ asset('js/datatable.js') }}"></script>
        
        <!-- including custom style sheet -->
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <!-- including custom style sheet -->
        <link rel="stylesheet" href="{{ asset('css/datatable.css') }}">
        {{-- brian2694/laravel-toastr css  --}}
        <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}">

        <!-- add extra styles if needed -->
        @yield('style')
    </head>
    <body>
        <div class="main-container">
            <!-- Sidebar Container -->
            @include('layouts.sidebar')

            <!-- Body Wrapper. Contains main content -->
            <div class="body-wrapper">
                <!-- include header file --> 
                @include('layouts.header')
                

                <!-- Dynamic Content will be added here -->
                <div class="main-content">
                    @yield('main-content')
                </div>


                <!-- Include Footer file --> 
                @include('layouts.footer')
            </div>
        </div>

        <!-- ////////////////////////////////////////  Script file add start from here /////////////////////////// -->

        <!-- Bootstrap cdn link -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        {{-- laravel csrf token ajax --}}
        {{-- <script>
            var token = localStorage.getItem('token');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json',
                }
            });
        </script> --}}
        {{-- common ajax Request file --}}
        <script src="{{ asset('js/ajax/common_ajax/common_events.js') }}"></script>
        <script src="{{ asset('js/ajax/common_ajax/custom_helper_function.js') }}"></script>
        <script src="{{ asset('js/ajax/common_ajax/get_data.js') }}"></script>
        <script src="{{ asset('js/ajax/common_ajax/crude_ajax.js') }}"></script>
        {{-- add extra ajax file if needed --}}
        @yield('ajax')
        {{-- custom sidebar ajax --}}
        <script src="{{ asset('js/sidebar.js') }}"></script>
        {{-- custom modal ajax --}}
        <script src="{{ asset('js/modal.js') }}"></script> 
        {{-- brian2694/laravel-toastr js  --}}
        <script src="{{ asset('js/toastr.min.js') }}"></script> 
        {{-- {!! Toastr::message()  --}}
        {{-- <script>
            let role = @json(UserRole());
            let userPermissions = @json(UserPermissions());
        </script> --}}
        {{-- @if (session('message'))
            <script>
                toastr.error('{{ session('message') }}', 'Permission Denied!');
            </script>
        @endif --}}
        @yield('script')
    </body>
</html>