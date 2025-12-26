{{-- <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script> --}}
{{-- <!-- Include Date Range Picker --> --}}
{{-- <script type="text/javascript" src="https://cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script> --}}
{{-- <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css"/> --}}

<script src="https://code.jquery.com/jquery-migrate-3.4.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.14.0/jquery-ui.js"></script>
<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

{{-- ./Legacy Old script --}}

{{-- <script src="{{ asset('frontend/js/jquery-2.1.1.min.js') }}"></script> --}}
{{-- <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script> --}}
{{-- <script src="{{ asset('frontend/js/jquery.validate.js') }}"></script> --}}
{{-- <script src="{{ asset('frontend/js/plugin.js') }}"></script> --}}
<script src="{{ asset('frontend/js/detail-tab.js') }}"></script>
<script src="{{ asset('frontend/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('frontend/js/accordion.js') }}"></script>
{{-- <script src="{{ asset('frontend/js/datepicker.min.js') }}"></script> --}}
<script src="{{ asset('frontend/js/jquery.steps.js') }}"></script>
<script src="{{ asset('frontend/js/additional-methods.js') }}"></script>
<script src="{{ asset('frontend/plugins/InputSpinner/number.js') }}"></script>

{{-- <script src="{{ asset('frontend/js/typeahead.js') }}"></script> --}}
<script src="{{ asset('frontend/js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('frontend/js/main.js') }}"></script>
<script src="{{ asset('frontend/js/custom.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script type="text/javascript">
    $(document).on('click', '#btn-signin', function(e) {
        e.preventDefault();
        let url = "{{ route('login') }}";
        let form = $('#signInForm');
        $.ajax({
            url: url,
            type: 'POST',
            data: form.serialize(),

            success: function(data) {
                $('#login_register').modal('hide');
                window.location.replace("{{ route('frontend.index') }}")
            },
            error: function(error) {
                let response = $.parseJSON(error.responseText);
                $.each(response.errors, function(key, val) {
                    $("#" + key + "_error").text(val[0]);
                    // alert(val[0])
                })
            }
        });
        console.log(url, form)
    });

    $(document).on('click', '#btn-register', function(e) {
        e.preventDefault();
        let urlr = "{{ route('register') }}";
        let formr = $('#registerForm');
        $.ajax({
            url: urlr,
            type: 'POST',
            data: formr.serialize(),
            success: function(data) {
                $('#login_register').modal('hide');
                window.location.replace("{{ route('home') }}")
            },
            error: function(error) {
                if (error.status == 403) {
                    $('#login_register').modal('hide');
                    window.location.replace("{{ route('verification.notice') }}")
                }
                let response = $.parseJSON(error.responseText);
                $.each(response.errors, function(key, val) {
                    $("#" + key + "_rerror").text(val[0]);
                    // alert(val[0])
                })
            }
        });
    });
</script>
<script type="text/javascript">
    $('#callMeBack').on('click', function() {
        $('#typeValue').val('inquery');
        $('#packageId').val('');

        $('#callActionTitle').html('Call Me Back');
        $('#call-popup').modal({
            backdrop: 'static',
            keyboard: false
        });
    });

    $('#call-popup').on('hidden.bs.modal', function() {
        $(this).find('form')[0].reset();
    });

    $(function() {
        $('input[name="inq_date"]').datepicker({
            format: "yyyy-mm-dd",
            language: "es",
            autoclose: true,
            todayHighlight: true
        });
    });

    $(document).on('click', '#callMeBackButton', function(e) {
        e.preventDefault();
        if ($('#callMeBackForm').valid()) {
            var url = "{{ route('call.me.back') }}";
            var form = $('#callMeBackForm');
            $.ajax({
                url: url,
                type: 'POST',
                data: form.serialize(),
                beforeSend: function() {
                    $('#callMeBackButton').attr('disabled', true).html('processing....');
                },
                success: function(res) {
                    $('#call-popup').modal('hide');
                    $('#successModal').modal('show');
                    setTimeout(function() {
                        $('#successModal').modal('hide').fadeOut;
                    }, 2000);
                    $('#callMeBackButton').attr('disabled', false);
                    $('#message').html(res.message);

                },
                error: function(err) {
                    console.log(JSON.parse(err.responseText));
                    $('#call-popup').modal('hide');
                    $('#successModal').modal('show');
                    setTimeout(function() {
                        $('#successModal').modal('hide').fadeOut;
                    }, 2000);
                    $('#callMeBackButton').attr('disabled', false).html('Submit');
                    $('#message').html(JSON.parse(err.responseText).message);
                },
            });
        }
    });


    // $('#callMeBackForm').validate();
</script>
<script>
    $(function() {
        $(".departuredate").datepicker({
            minDate: "0"
        });
        $(".returndate").datepicker({
            minDate: "0"
        });
    })
</script>


<script src="{{ asset('js/app.js') }}"></script>
{{-- <script src="{{ asset('frontend/js/flatpickr.js') }}"></script> --}}
@yield('scripts')
@livewireScripts
</body>

</html>
