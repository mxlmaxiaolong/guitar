/**
 * Created by stanley on 12/09/2018.
 */
jQuery(document).ready(function($) {

    // Expose JS function for user login
    window.logIn = function() {
        $('#loginForm .submit').removeClass('active').attr('disabled', 'disabled')
        $('#loginForm .submit').val('登陆中...');

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_login_object.ajaxurl,
            data: {
                'action': 'ajaxlogin', //calls wp_ajax_nopriv_ajaxlogin
                'username': $('#loginForm #phoneNumberInput').val(),
                'password': $('#loginForm #passInput').val(),
                'security': $('input#security').val()},
            success: function(data){

                $('#loginForm .submit').addClass('active').attr('disabled', false)
                $('#loginForm .submit').val('登陆');

                if (data.errorCode !== 1){
                    document.location.href = ajax_login_object.redirecturl;
                } else {
                    window.alert(data.errorMsg);
                }
            }
        });
    }

    // Perform AJAX login on form submit
    $('form#login').on('submit', function(e){
        e.preventDefault();
        logIn()
    });


    window.register = function() {
        $('#regForm .submit').removeClass('active').attr('disabled', 'disabled')
        $('#regForm .submit').val('注册中...');
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_login_object.ajaxurl,
            data: {
                'action': 'register_user', //calls wp_ajax_nopriv_ajaxlogin
                'username': $('#regForm #phoneNumberInput').val(),
                'password': $('#regForm #passInput').val(),
                'code': $('#regForm #codeInput').val(),
                'security': $('input#security').val()},
            success: function(data){
                $('#regForm .submit').addClass('active').attr('disabled', false)
                $('#regForm .submit').val('注册');
                if (data.errorCode !== 1){
                    document.location.href = document.location.href;
                } else {
                    window.alert(data.errorMsg);
                }
            }
        });
    }

});