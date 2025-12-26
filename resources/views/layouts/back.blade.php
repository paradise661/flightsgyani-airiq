<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Flights Gyani | @yield('title')</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{asset('back/css/app.css')}}"> @stack('styles')


    <meta name="csrf-token" content="{{ csrf_token() }}">


    @yield('style')

</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper" style="height: auto;min-height: 100%">
    <style>
        @media print {
            .hidden-print {
                display: none !important;
            }
        }

        .error {
            color: #a55959;
        }

        .row {
            width: 100%;
        }

        .dataTables_filter {
            margin-left: 200px;
        }

        div#dataTable_length {
            margin-left: -280px;
        }

        .pagination {
            margin-left: 460px;
        }

        .form-group.has-error label {
            color: inherit !important;
        }

        .container {
            margin-top: -50px;
        }

        .bg-aqua, .callout.callout-info, .alert-info, .label-info, .modal-info .modal-body {
            margin-top: -30px !important;
            z-index: 1049 !important;
        }

        .mgl-10 {
            margin-left: 10px;
        }

        .dropdown-menu {
            min-width: 0 !important;
        }

        dropdown-toggle::after {
            display: none !important;
        }
    </style>

    @include('admin.partials.top_nav')
    @include('admin.partials.side_nav')

    <div class="content-wrapper">
        <section class="content-header">
            @yield('button')

            {{--<h1>--}}
            {{--@yield('title')--}}
            {{--<small>@yield('sub_title')</small>--}}
            {{--</h1>--}}
        </section>

        <section class="content">
                        @include('admin.partials.message')

            @yield('content')
        </section>
    </div>
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 1.0.0
        </div>
        <strong>Copyright &copy; {{date('Y')}} <a href="https://www.flightsgyani.com" target="_blank">Flights Gyani</a>.</strong>
        All rights reserved.
    </footer>
</div>

<script src="{{asset("back/js/app.js")}}"></script>
@yield('scripts')

<script>
    $(function () {
        $('body').on('click', '[data-action=delete]',

            function (e) {
                e.preventDefault();


                var source = $(e.target);
                if (source.get(0).tagName == "I") {
                    source = source.closest('a');
                }
                var url = source.attr('href');
                var id = source.data('id');


                swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result, source) => {
                    if (result.value) {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: "GET",
                            url: url,
                            data: {id: id},
                            dataType: 'json',
                            success: (function (data, source) {


                                swal.fire({
                                    icon: 'success',
                                    title: 'Done',
                                    text: 'Data deleted successfully!',
                                })
                                window.location.reload();
                            }),
                            error: (function (data) {
                                swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Something went wrong!',
                                    footer: '<a href>Why do I have this issue?</a>'
                                })
                            })

                        });


                    }
                })


            }
        )
    })
</script>
<script>
    $('.single-notification').on('click', function () {
        event.preventDefault();
        var notif = $(this).parent('li').attr('id');
        console.log(notif);
        $.ajax({
            method: 'get',
            data: {notif: notif},
            url: '{{ route('notification.read') }}',
            success: function (response) {

                window.location.href = response;
            },
            // error : function(response){
            //     window.location.href = '/admin/dashboard/detail';
            // }
        });
    })
</script>
</body>

</html>
