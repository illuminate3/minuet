$( document ).ready(function() {
    var radio_btn_value = $('input[type="radio"]:checked').val();

    if(radio_btn_value === 'ROLE_BUYER')
    {
        $('#email-div').removeClass('hide');
        $('#password-div').removeClass('hide');
        $('#agree-terms-div').removeClass('hide');
        $('#btn-register').removeClass('hide');
        $('#registration_form_password').prop('required',true);
        $('#registration_form_agreeTerms').prop('required',true);
    }

    if(radio_btn_value === 'ROLE_DEALER')
    {
        $('#email-div').removeClass('hide');
        $('#password-div').addClass('hide');
        $('#agree-terms-div').addClass('hide');
        $('#btn-register').removeClass('hide');
        $('#registration_form_password').prop('required',false);
        $('#registration_form_agreeTerms').prop('required',false);
        $('#btn-register').html('Next');
    }

    $('.form-check-input').on('change',function() {
        if (this.value == 'ROLE_DEALER') {
            $('#email-div').removeClass('hide');
            $('#password-div').addClass('hide');
            $('#agree-terms-div').addClass('hide');
            $('#btn-register').removeClass('hide');
            $('#registration_form_password').prop('required',false);
            $('#registration_form_agreeTerms').prop('required',false);
            $('#btn-register').html('Next');
        }
        else if (this.value == 'ROLE_BUYER') {
            $('#email-div').removeClass('hide');
            $('#password-div').removeClass('hide');
            $('#agree-terms-div').removeClass('hide');
            $('#btn-register').removeClass('hide');
            $('#btn-register').html('Register');
            $('#registration_form_password').prop('required',true);
            $('#registration_form_agreeTerms').prop('required',true);
        }
    });
});

