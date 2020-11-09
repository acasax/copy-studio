jQuery(document).on('ready', function() {
    $(window).on('load', function() {
        var portfolioIsotope = $('.portfolio-container').isotope({
            itemSelector: '.portfolio-item',
            layoutMode: 'fitRows',
            filter: '.filter-3'
        });

        $('#portfolio-flters li').on('click', function() {
            $("#portfolio-flters li").removeClass('filter-active');
            $(this).addClass('filter-active');

            portfolioIsotope.isotope({
                filter: $(this).data('filter')
            });
        });

        // Initiate venobox (lightbox feature used in portofilo)
        $(document).ready(function() {
            $('.venobox').venobox();
        });
    });

    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }

    $('#emailSend').click(() => {
        const lang = $(".site-lang").val();
        let url = lang == 'sr' ? 'assets/php/send_mail.php' : '../send_mail.php';
        const name = $("#name").val().trim(),
            email = $("#email1").val().trim(),
            message = $("#message").val().trim(),
            recaptcha_response = $("#recaptchaResponse").val();
        if (name == '' || email == '' || message == '') {
            $("#myModal").fadeIn(1000);
            if (lang == 'sr') {
                $('.modal-body').text("Niste popunili sva polja. Molimo pokušajte ponovo.");
            } else if (lang == 'en') {
                $('.modal-body').text("You need to fill out all the fields. Please try again.");
            }
            return;
        }
        if (!isEmail(email)) {
            $("#myModal").fadeIn(1000);
            if (lang == 'sr') {
                $('.modal-body').text("Nepravilna email adresa. Molimo pokušajte ponovo.");
            } else {
                $('.modal-body').text("Email address you have entered is not valid. Please try again.");
            }
            return;
        }
        const data = {
            name: name,
            email: email,
            message: message,
            recaptcha_response: recaptcha_response
        };
        $("#myModal").fadeIn(1000);
        $.ajax({
            type: "POST",
            dataType: 'text',
            url: url,
            data: data,
            success: (response) => {
                $("#name").val('');
                $("#email1").val('');
                $("#message").val('');
                $("#myModal").fadeIn(1000);
                if (lang == 'sr') {
                    $('.modal-body').text("Uspešno ste poslali poruku.");
                } else if (lang == 'en') {
                    $('.modal-body').text("You have successfully sent a message.");
                }
            },
            error: (response) => {
                $("#myModal").fadeIn(1000);
                if (lang == 'sr') {
                    $('.modal-body').text("Došlo je do greške. Molimo pokušajte ponovo.");
                } else if (lang == 'en') {
                    $('.modal-body').text("An error has occurred. Please try again.");
                }
            }
        })
    });

});

grecaptcha.ready(() => {
    grecaptcha.execute('6Lep9uAZAAAAALs8ucbCiJGVSN2NRX2qQNVTJrUc')
        .then((token) => {
            recaptchaResponse = document.getElementById('recaptchaResponse');
            recaptchaResponse.value = token;
        });
});