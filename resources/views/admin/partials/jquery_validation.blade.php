<script src="{{URL::to('back/bower_components/jquery-validation/dist/jquery.validate.js')}}"></script>
<script src="{{ URL::to('back/bower_components/jquery-validation/dist/additional-methods.js') }}"></script>

<script type="text/javascript">
    /**
     * default validation configs, can be override in specifc view blades
     */
    $.validator.setDefaults({
        errorClass: 'help-block with-errors',
        errorElement: 'div',
        /*//        onkeyup: function (element) {
        //            $(element).valid();
        //        },*/
        onfocusout: function (element) {
            $(element).valid();
        },
        highlight: function (element, errorClass, validClass) {
            //console.log('hee');
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).closest('.form-group').removeClass('has-error');
            $(element).closest('.form-group').find('.help-block').hide();
        },
        errorPlacement: function (error, element) {
            $(element).closest('.form-group').append(error);
        },
    });
</script>
<style>
    .help-block.with-errors {
        color: #EF6F6C;
    }
</style>
