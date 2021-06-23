<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'Home') - CRED BOLT</title>

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;700&display=swap" rel="stylesheet">
    <link href="{{ asset('global_assets/css/icons/icomoon/styles.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/bootstrap_limitless.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/layout.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/components.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/colors.min.css') }}" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Custom Stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <!-- /Custom Stylesheet -->

    @yield('plugin-styles')
    @yield('custom-styles')
</head>

<body>
     @include('layouts.partials.navbar') 

    <!-- Page content -->
    <div class="page-content">
        <!-- Sidebar -->
         @include('layouts.partials.sidebar') 
        <!-- /Sidebar -->

        <!-- Main content -->
        <div class="content-wrapper">
            <div class="page-header page-header-light">
                <div class="page-header-content header-elements-md-inline">
                    <div class="page-title d-flex">
                        <h4>@yield('header')</h4>
                    </div>
                </div>
            </div>

            <!-- Breadcrumbs -->
            @yield('breadcrumbs')
            <!-- /Breadcrumbs -->

            <!-- Page header -->
            @yield('page-title')
            <!-- /page header -->

            <!-- Content area -->
            <div class="content pt-0">
                <!-- Alert component -->
             
                <!-- /Alert component -->

                <!-- Validation errors -->
              
                <!-- /Validation errors -->

                <!-- @yield('content') -->
            </div>
            <!-- /content area -->

            <!-- Footer -->
             @include('layouts.partials.footer') 
            <!-- /footer -->
        </div>
        <!-- /main content -->
    </div>
    <!-- /page content -->

    <script src="{{ asset('global_assets/js/main/jquery.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/main/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/loaders/blockui.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/tables/datatables/datatables.min.js') }}"></script>

    <script src="{{ asset('assets/js/app.js') }}"></script>

    <script>
        $.extend( $.fn.dataTable.defaults, {
            autoWidth: false,
            columnDefs: [{
                width: 100,
            }],
            dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            language: {
                search: '<span>Filter:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span>Show:</span> _MENU_',
                paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
            },
        });

    </script>

    @yield('plugin-scripts')
    @yield('custom-scripts')
</body>
</html>
