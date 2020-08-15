"use strict"; // Start of use strict

function page_loader() {
    $('.loading-area').fadeOut(2000)
    setTimeout(()=>{
        $('.loading-area').css('display','none')
    },1500)
};
page_loader()


function accrodion () {
    if ($('.accrodion-grp').length) {
        var accrodionGrp = $('.accrodion-grp');
        accrodionGrp.each(function () {
            var accrodionName = $(this).data('grp-name');
            var Self = $(this);
            var accordion = Self.find('.accrodion');
            Self.addClass(accrodionName);
            Self.find('.accrodion .accrodion-content').hide();
            Self.find('.accrodion.active').find('.accrodion-content').show();
            accordion.each(function() {
                $(this).find('.accrodion-title').on('click', function () {
                    if ($(this).parent().hasClass('active') === false ) {
                        $('.accrodion-grp.'+accrodionName).find('.accrodion').removeClass('active');
                        $('.accrodion-grp.'+accrodionName).find('.accrodion').find('.accrodion-content').slideUp();
                        $(this).parent().addClass('active');
                        $(this).parent().find('.accrodion-content').slideDown();
                    };


                });
            });
        });

    };
}

function thmMailchimp() {
    if ($('.mailchimp-form').length) {
        $('.mailchimp-form').each(function() {
            var mailChimpWrapper = $(this);
            mailChimpWrapper.validate({ // initialize the plugin
                rules: {
                    email: {
                        required: true,
                        email: true
                    }
                },
                submitHandler: function(form) {
                    // sending value with ajax request
                    $.post($(form).attr('action'), $(form).serialize(), function(response) {
                        $(form).parent().find('.result').append(response);
                        $(form).find('input[type="text"]').val('');
                        $(form).find('input[type="email"]').val('');
                        $(form).find('textarea').val('');
                    });
                    return false;
                }
            });
        });
    };
}


function thmOwlCarousel() {
    if ($('.testi-carousel').length) {
        $('.testi-carousel').owlCarousel({
            loop: true,
            margin: 0,
            nav: false,
            navText: [
                '<i class="fa fa-angle-left"></i>',
                '<i class="fa fa-angle-right"></i>'
            ],
            dots: true,
            autoWidth: false,
            autoplay: true,
            autoplayTimeout: 3000,
            autoplayHoverPause: true,
            responsive: {
                0: {
                    items: 1,
                    autoWidth: false
                },
                480: {
                    items: 1,
                    autoWidth: false
                },
                600: {
                    items: 1,
                    autoWidth: false
                },
                1000: {
                    items: 1,
                    autoWidth: false
                }
            }
        });
    };
    if ($('.team-carousel').length) {
        $('.team-carousel').owlCarousel({
            loop: true,
            margin: 0,
            nav: true,
            navText: [
                '<i class="fa fa-angle-left"></i>',
                '<i class="fa fa-angle-right"></i>'
            ],
            dots: false,
            autoWidth: false,
            autoplay: true,
            autoplayTimeout: 3000,
            autoplayHoverPause: true,
            responsive: {
                0: {
                    items: 1,
                    autoWidth: false
                },
                480: {
                    items: 1,
                    autoWidth: false
                },
                600: {
                    items: 1,
                    autoWidth: false
                },
                1000: {
                    items: 1,
                    autoWidth: false
                }
            }
        });
    };
    if ($('.banner-carousel-two').length) {
        $('.banner-carousel-two').owlCarousel({
            loop: true,
            margin: 0,
            nav: false,
            navText: [
                '<i class="fa fa-angle-left"></i>',
                '<i class="fa fa-angle-right"></i>'
            ],
            dots: true,
            autoWidth: false,
            autoplay: true,
            autoplayTimeout: 3000,
            autoplayHoverPause: true,
            responsive: {
                0: {
                    items: 1
                },
                480: {
                    items: 1
                },
                568: {
                    items: 1
                },
                600: {
                    items: 1
                },
                823: {
                    items: 1
                },
                1000: {
                    items: 1
                }
            }
        });
    };
    if ($('.we-believe-carousel').length) {
        $('.we-believe-carousel').owlCarousel({
            loop: true,
            margin: 0,
            nav: false,
            navText: [
                '<i class="fa fa-angle-left"></i>',
                '<i class="fa fa-angle-right"></i>'
            ],
            dots: true,
            autoWidth: false,
            autoplay: true,
            autoplayTimeout: 3000,
            autoplayHoverPause: true,
            responsive: {
                0: {
                    items: 1
                },
                480: {
                    items: 1
                },
                568: {
                    items: 1
                },
                600: {
                    items: 1
                },
                823: {
                    items: 1
                },
                1000: {
                    items: 1
                }
            }
        });
    };
    if ($('.brand-carousel').length) {
        $('.brand-carousel').owlCarousel({
            loop: true,
            margin: 90,
            nav: false,
            navText: [
                '<i class="fa fa-angle-left"></i>',
                '<i class="fa fa-angle-right"></i>'
            ],
            dots: false,
            autoWidth: false,
            autoplay: true,
            autoplayTimeout: 3000,
            autoplayHoverPause: true,
            responsive: {
                0: {
                    items: 1
                },
                480: {
                    items: 2
                },
                568: {
                    items: 3
                },
                600: {
                    items: 4
                },
                823: {
                    items: 4
                },
                1000: {
                    items: 6
                }
            }
        });
    };
}


function galleryMasonaryLayout() {
    if ($('.masonary-layout').length) {
        $('.masonary-layout').isotope({
            layoutMode: 'masonry'
        });
    }

    if ($('.post-filter').length) {
    	var postFilterList = $('.post-filter li');
        postFilterList.children('span').on('click', function() {
            var Self = $(this);
            var selector = Self.parent().attr('data-filter');
            postFilterList.children('span').parent().removeClass('active');
            Self.parent().addClass('active');


            $('.filter-layout').isotope({
                filter: selector,
                animationOptions: {
                    duration: 500,
                    easing: 'linear',
                    queue: false
                }
            });
            return false;
        });
    }

    if ($('.post-filter.has-dynamic-filter-counter').length) {
        // var allItem = $('.single-filter-item').length;

        var activeFilterItem = $('.post-filter.has-dynamic-filter-counter').find('li');

        activeFilterItem.each(function() {
            var filterElement = $(this).data('filter');
            var count = $('.gallery-content').find(filterElement).length;
            $(this).children('span').append('<span class="count"><b>' + count + '</b></span>');
        });
    };
}


function thmbxSlider() {
    if ($('.feature-carousel-box').length) {
        $('.feature-carousel-box').bxSlider({
            mode: 'vertical',
            auto: true,
            autoControls: false,
            controls: false,
            pause: 3000,
            slideMargin: 0
        });
    }
}



function stickyHeader() {
    if ($('.stricky').length) {
        var strickyScrollPos = 100;
        var stricky = $('.stricky');
        if ($(window).scrollTop() > strickyScrollPos) {
            stricky.removeClass('slideIn animated');
            stricky.addClass('stricky-fixed slideInDown animated');
            $('.scroll-to-top').fadeIn(500);
        } else if ($(this).scrollTop() <= strickyScrollPos) {
            stricky.removeClass('stricky-fixed slideInDown animated');
            stricky.addClass('slideIn animated');
            $('.scroll-to-top').fadeOut(500);
        }
    };
}


function thmLightBox() {
    if ($('.img-popup').length) {
        var groups = {};
        var imgPop = $('.img-popup');
        imgPop.each(function() {
            var id = parseInt($(this).attr('data-group'), 10);

            if (!groups[id]) {
                groups[id] = [];
            }

            groups[id].push(this);
        });


        $.each(groups, function() {

            $(this).magnificPopup({
                type: 'image',
                closeOnContentClick: true,
                closeBtnInside: false,
                gallery: { enabled: true }
            });

        });

    };
}

function thmCounter() {
    if ($('.counter').length) {
        $('.counter').counterUp({
            delay: 10,
            time: 3000
        });
    };
}

function thmScrollAnim() {
    if ($('.wow').length) {
        var wow = new WOW({
            mobile: false
        });
        wow.init();
    };
}


const languages = {
    'sr': {
        'globalErrorMsg': "Nešto nije uredu. Pokušajte ponovo ili kontaktirajte nas.",
        'nameRequired': "Unesite Vaše ime",
        'nameMinLength': "Vaše ima mora da sadrži najmanje 2 slova",
        'messageRequired': "Unesite poruku",
        'messageMinLength': "Vaša poruka mora da sadrži najmanje 20 slova",
        'emailRequired': "Unesite Vašu e adresu",
        'emailValid': 'Vaša adresa nije validnog formata',
        'secPartnerWelcome': "Kontaktiraćemo Vas u najkraćem vremenskom intervalu.",
        'contactWelcome': 'Hvala Vam na interesovanju.',
        'contactSecMsg': "Kontaktiraćemo Vas u najkraćem vremenskom intervalu.",
    },
    'en': {
        'globalErrorMsg': "Something gose wrong.Try again or contact our services.",
        'nameRequired': "Please enter your name",
        'nameMinLength': "Your name must consist of at least 2 characters",
        'messageRequired': "Please enter message",
        'messageMinLength': "Your message must consist of at least 20 characters",
        'emailRequired': "Please enter your email",
        'secPartnerWelcome': "We will contact you in the shortest possible time.",
        'contactWelcome': 'Thank you for your interest.',
        'contactSecMsg': "We will contact you in the shortest possible time.",
    }
}


const translate = (attribute)=>{
    const href = window.location.href
    let lang = 'sr'
    if(href.includes('en')) lang = 'en';
    return languages[lang][attribute]
}





function contactFormValidation() {






    let language = void(0)
    let lang = 'en'

    if(localStorage.getItem('copyStudio')){
        lang = localStorage.getItem('copyStudio')
    }



    /** CONTACT FORM SUBMIT / VALIDATION */
    if ($('.contact-form').length) {
    $('.contact-form').validate({
        rules: {
            name: {
                required: true,
                minlength: 2
            },
            message: {
                required: true,
                minlength: 20
            },
            email: {
                required: true,
                email: true
            }
        },
        messages: {
            name: {
                required: translate('nameRequired'),
                minlength: translate('nameMinLength'),
            },
            message: {
                required:  translate('messageRequired'),
                minlength: translate('messageMinLength'),
            },
            email: {
                required: translate('emailRequired'),
            }
        },
        submitHandler: function submitHandler(form) {
            const data = {
                name: $('#name').val(),
                email: $('#email').val(),
                message: $('#message').val(),
                "g-recaptcha-response": $('textarea[id="g-recaptcha-response"]').val()
            }
            $(form).ajaxSubmit({
                url: 'app/ajax/send_email.php',
                type: "POST",
                data: data,
                dataType: "JSON",
                beforeSend: function () {
                    $('.loading-area').css('display', 'block')
                },
                success: function success(data) {
                    if (data.type === "message") {
                        swal({
                            title: translate(data.welcome),
                            text: translate(data.secMsg),
                            timer: 4000,
                            showCancelButton: false,
                            showConfirmButton: false,
                            type: "success"
                        });
                        form.reset();
                        grecaptcha.reset();
                    } else {
                        let str = data.text;
                        swal({
                            title: "Error",
                            text: str,
                            timer: 3000,
                            showCancelButton: false,
                            showConfirmButton: false,
                            type: "error"
                        });
                        form.valid()
                        grecaptcha.reset();
                    }
                },
                error: function error() {
                    swal({
                        title: "Error",
                        text: translate('globalErrorMsg'),
                        timer: 3000,
                        showCancelButton: false,
                        showConfirmButton: false,
                        type: "error"
                    });
                    grecaptcha.reset();
                },
                complete: function () {
                    $('.loading-area').fadeOut(2000)
                    setTimeout( ()=>{
                        $('.loading-area').css('display', 'none')
                    },1000)
                }
            });
        }
    });

    }
}

$(document).on('blur','#EMAIL',function (e){

})

/** CONTACT FORM SUBMIT / VALIDATION */
if ($('#newsletter_form').length) {
   const newsletterFormValidation =  $('#newsletter_form').validate({
        errorPlacement: function(error,element) {
            if(error) {
              $('#newsletter_form').find('.mc4wp-form-fields').addClass('error')
              return true
            }
            $('#newsletter_form').find('.mc4wp-form-fields').removeClass('error')
            return true;
        },
        rules: {
            EMAIL: {
                required: true,
                email: true
            },
            AGREE_TO_TERMS: {
                required: true
            },
        },
        messages: {
            EMAIL: {
                required: '',
                email: ''
            },
            AGREE_TO_TERMS: {
                required: ''
            }
        },
        submitHandler: function submitHandler(form) {
            $('.loading-area').css('display', 'block')
            $(form).ajaxSubmit({
                type: "POST",
                dataType: "JSON",
                url: "admin/newsletter.php",
                method: 'POST',
                data: {
                  EMAIL: $('#EMAIL').val(),
                  AGREE_TO_TERMS: $("#AGREE_TO_TERMS").val()
                },
                success: function (data) {
                    var objResp = data;
                    var str=objResp.type;
                    if(str==='ERROR')
                    {
                        str=objResp.data;
                        swal({
                            title: "Greška!",
                            text: str,
                            timer: 2500,
                            showCancelButton: false,
                            showConfirmButton: false,
                            type: "error"
                        });
                        resetValidation()
                        return;
                    }

                    if(str==='OK')
                    {
                        str=objResp.data;
                        swal({
                            title: "Uspešno!",
                            text: str,
                            timer: 2500,
                            showCancelButton: false,
                            showConfirmButton: false,
                            type: "success"
                        });
                        $('#newsletter_form')[0].reset();
                        return;
                    }

                },
                error: function error() {
                    swal({
                        title: "Error",
                        text: translate('globalErrorMsg'),
                        timer: 3000,
                        showCancelButton: false,
                        showConfirmButton: false,
                        type: "error"
                    });
                },
                complete: function () {
                    $('.loading-area').fadeOut(2000)
                    setTimeout( ()=>{
                        $('.loading-area').css('display', 'none')
                    },1000)
                }
            });
        }
    });

   const  resetValidation = ()=> {
        newsletterFormValidation.resetForm()
    }
}



$(document).on('submit','#newsletter_form',function (e){
    e.preventDefault();
    $.ajax({

    })
})

function thmVideoPopup() {
    if ($('.video-popup').length) {
        $('.video-popup').magnificPopup({
            disableOn: 700,
            type: 'iframe',
            mainClass: 'mfp-fade',
            removalDelay: 160,
            preloader: true,

            fixedContentPos: false
        });
    };
}

function scrollToTarget() {
    if ($('.scroll-to-target').length) {
        $(".scroll-to-target").on('click', function() {
            var target = $(this).attr('data-target');
            // animate
            $('html, body').animate({
                scrollTop: $(target).offset().top
            }, 1000);

            return false;

        });
    }
}

function mobileNavToggle () {
    if ($('#main-nav-bar .navbar-nav .sub-menu').length) {
    	var subMenu = $('#main-nav-bar .navbar-nav .sub-menu');
        subMenu.parent('li').children('a').append(function () {
            return '<button class="sub-nav-toggler"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>';
        });
        var subNavToggler = $('#main-nav-bar .navbar-nav .sub-nav-toggler');
        subNavToggler.on('click', function () {
            var Self = $(this);
            Self.parent().parent().children('.sub-menu').slideToggle();
            return false;
        });

    };
}


function handlePreloader() {
    if($('.preloader').length){
        $('body').removeClass('active-preloader-ovh');
        $('.preloader').fadeOut();
    }
}

function bootstrapAnimatedLayer() {

    /* Demo Scripts for Bootstrap Carousel and Animate.css article
     * on SitePoint by Maria Antonietta Perna
     */

    //Function to animate slider captions
    function doAnimations(elems) {
        //Cache the animationend event in a variable
        var animEndEv = 'webkitAnimationEnd animationend';

        elems.each(function() {
            var $this = $(this),
                $animationType = $this.data('animation');
            $this.addClass($animationType).one(animEndEv, function() {
                $this.removeClass($animationType);
            });
        });
    }

    //Variables on page load
    var $myCarousel = $('#minimal-bootstrap-carousel'),
        $firstAnimatingElems = $myCarousel.find('.item:first').find("[data-animation ^= 'animated']");

    //Initialize carousel
    $myCarousel.carousel({
        interval: 7000
    });

    //Animate captions in first slide on page load
    doAnimations($firstAnimatingElems);

    //Pause carousel
    $myCarousel.carousel('pause');


    //Other slides to be animated on carousel slide event
    $myCarousel.on('slide.bs.carousel', function(e) {
        var $animatingElems = $(e.relatedTarget).find("[data-animation ^= 'animated']");
        doAnimations($animatingElems);
    });
}

function pogressbarAnim () {
    if ($('.single-progress-bar .pogress-wow').length) {
        var wow = new WOW({
            boxClass:     'pogress-wow',      // default
            animateClass: 'animated',
            mobile: true
        });
        wow.init();
    }
}


function thmHalfChart() {
    if ($('.circle').length) {
        var cricleWrap = $('.circle');
        cricleWrap.each(function () {
            var Self = $(this);
            var circleSize = Self.data('size');
            var circleValue = Self.data('value');
            var circleColor = Self.data('color');
            Self.waypoint(function () {
                Self.circleProgress({
                    value: circleValue,
                    size: circleSize,
                    thickness: 18,
                    fill: { color: circleColor }
                });
            }, { offset: 'bottom-in-view' });

        });
    };
}
thmHalfChart();


// instance of fuction while Document ready event
jQuery(document).on('ready', function() {
    (function($) {
        thmMailchimp();
        thmLightBox();
        thmCounter();
        contactFormValidation();
        scrollToTarget();
        thmVideoPopup();
        accrodion();
        mobileNavToggle();
        bootstrapAnimatedLayer();
        page_loader();
    })(jQuery);
});

// instance of fuction while Window Load event
jQuery(window).on('load', function() {
    (function($) {
        galleryMasonaryLayout();
        handlePreloader()
        // thmScrollAnim();
        pogressbarAnim();
        thmOwlCarousel();
    })(jQuery);
});

// instance of fuction while Window Scroll event
jQuery(window).on('scroll', function() {
    (function($) {
        stickyHeader();
    })(jQuery);
});
