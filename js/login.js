$(document).ready(function () {

    const languages = {
        'sr': {
            'globalErrorMsg': "Nešto nije uredu. Pokušajte ponovo ili kontaktirajte nas.",
            'emailRequired': "Unesite Vašu e adresu",
            'emailValid': 'Vaša adresa nije validnog formata',
            'passwordRequired': 'Unesite lozinku',
            'loginFaild' : "Koisnčko ili lozinka nisu validni.",
        },
        'en': {
            'globalErrorMsg': "Something gose wrong.Try again or contact our services.",
            'emailRequired':"Please enter your email",
            'emailValid': 'You email is not in valid format.',
            'passwordRequired': "Please enter your password",
            'loginFaild' : "Username or password are not good."
        }
    }


    "use strict";





    /*==================================================================
    [ Show pass ]*/
    var showPass = 0;
    $('.btn-show-pass').on('click', function(){
        if(showPass == 0) {
            $(this).next('input').attr('type','text');
            $(this).find('i').removeClass('zmdi-eye');
            $(this).find('i').addClass('zmdi-eye-off');
            showPass = 1;
        }
        else {
            $(this).next('input').attr('type','password');
            $(this).find('i').addClass('zmdi-eye');
            $(this).find('i').removeClass('zmdi-eye-off');
            showPass = 0;
        }
    });

    function page_loader() {
        $('.loading-area').fadeOut(2000)
        setTimeout(()=>{
            $('.loading-area').css('display','none')
        },1500)
    };
    page_loader()


    const translate = (attribute)=>{
        const href = window.location.href
        let lang = 'sr'
        if(href.includes('en')) lang = 'en';
        return languages[lang][attribute]
    }


    if (loginForm.length) {
        var $loginForm = $('#loginForm');
        $loginForm.validate({
            rules: {
                loginemail: {
                    required: true,
                    email: true
                },
                loginpassword: {
                    required: true
                },
            },
            messages: {
                loginemail: {
                    required: translate('emailRequired'),
                    email: translate('emailValid'),
                },
                loginpassword: {
                    required: translate('passwordRequired'),
                },
            },
            submitHandler: function submitHandler(form) {
                const data = {
                    loginemail: $('#loginemail').val(),
                    loginpasswordpassword: $('#loginpassword').val(),
                }
                $(form).ajaxSubmit({
                    url: 'admin/ajax/global/login.php',
                    type: "POST",
                    data: data,
                    dataType: "JSON",
                    beforeSend: function() {
                        page_loader()
                    },
                    success: function success(data) {
                        let type = data.type
                        if(type === "OK"){
                            localStorage.setItem('token', data.jwt)
                            let url = data.url;
                            window.location.replace(url)
                        }else{
                            let str=data.data;
                            swal({
                                title: "Error",
                                text: str,
                                timer: 3000,
                                showCancelButton: false,
                                showConfirmButton: false,
                                type: "error"
                            });
                            $loginForm.valid()
                        }
                    },
                    error: function error() {
                        const validator = $loginForm.validate();
                        validator.showErrors({
                            ['loginpassword']: translate('loginFaild')
                        });
                        return false
                    }
                });
            }
        });
    }




})
