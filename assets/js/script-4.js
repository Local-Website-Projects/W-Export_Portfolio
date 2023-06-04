;
(function ($) {
    $(document).on('ready', function () {

        
        $('img').addClass('lazy');
        $('.lazy').Lazy();
        
        /* Sticky-Menu-JS */
        $(window).scroll(function () {
            if ($(window).scrollTop() > 300) {
                $(".mainmenu-area").addClass('sticky');
            } else {
                $(".mainmenu-area").removeClass('sticky');
            }
        });

        $('.target-button').on('click', function () {
            var target = $(this).data('target');
            $(this).toggleClass('button-active');
            $(target).fadeToggle();
        });


        /* -- Submenu-Plus-Icon-Add --*/
        $('.mainmenu-area .menu-items li ul').each(function () {
            var items = $(this).children('li').length;
            $(this).parent('li').addClass('have-submenu');
            $(this).parent('li').append('<span class="plus"></span>');
            if (8 < items) {
                $(this).addClass('over-items');
            }
        });

        $('.mainmenu-area .nav-row .menu-items ul li .plus').on('click', function () {
            $(this).parent().toggleClass('menu-open');
        });






        /* -- Product-Color-Select -- */
        $('.color-select .color').each(function () {
            var color = $(this).data('color');
            $(this).css("background-color", color);
        });
        $('.color-select').each(function () {
            $(this).find('.color').on('click', function () {
                $(this).siblings().removeClass('active');
                $(this).addClass('active');
            });
        });

        /*====== Header-Slider ======*/
        var Header_Slider_Pagination = new Swiper(".header-slider-pagination", {
            loop: true,
            spaceBetween: 10,
            slidesPerView: 3,
            centeredSlides: true,
            watchSlidesProgress: true,
        });
        var Header_Slider = new Swiper(".header-slider", {
            loop: true,
            effect: "coverflow",
            grabCursor: true,
            centeredSlides: true,
            slidesPerView: "auto",
            watchSlidesProgress: true,
            thumbs: {
                swiper: Header_Slider_Pagination,
            },
            coverflowEffect: {
                rotate: 0,
                stretch: 100,
                depth: 500,
                modifier: 2,
                slideShadows: false,
            },
        });
        /*====== Slice-Slider ======*/
        var Slice_Slider = new Swiper(".slice-slider", {
            loop: true,
            effect: "cards",
            grabCursor: true,
            cardsEffect: {
                rotate: true,
                slideShadows: false,
                perSlideRotate: 5,
                perSlideOffset: 8,
            },
        });
        /*====== Intro-Slider ======*/
        var Intro_Slider = new Swiper(".intro-slide", {
            loop: true,
            speed: 1000,
            spaceBetween: -100,
            centeredSlides: true,
            slidesPerView: 1,
            watchSlidesVisibility: true,
            watchSlidesProgress: true,
            navigation: {
                nextEl: ".header-slider .arrow_next",
                prevEl: ".header-slider .arrow_prev",
            },
            pagination: {
                el: ".header-slider .slider-custom-pagination",
                clickable: true,
            },
            breakpoints: {
                320: {
                    slidesPerView: 2,
                },
                780: {
                    slidesPerView: 3,
                },
                992: {
                    slidesPerView: 4,
                },
            },
        });
        /*====== Testimonial-Slider ======*/
        var Testimonial_Slider_1 = new Swiper(".testimonial-navigate-slide", {
            loop: true,
            speed: 1000,
            spaceBetween: 30,
            slidesPerView: 2,
            watchSlidesVisibility: true,
            watchSlidesProgress: true,
            navigation: {
                nextEl: ".testimonial-navigation .next",
                prevEl: ".testimonial-navigation .prev",
            },
            pagination: {
                el: ".testimonial-navigation .slider-custom-pagination",
                clickable: true,
            },
            breakpoints: {
                320: {
                    slidesPerView: 2,
                },
                520: {
                    slidesPerView: 3,
                },
            },
        });
        var Testimonial_Slider_2 = new Swiper(".testimonial-photo-slide", {
            loop: true,
            speed: 1000,
            spaceBetween: 0,
            slidesPerView: 1,
            watchSlidesVisibility: true,
            watchSlidesProgress: true,
            navigation: {
                nextEl: ".testimonial-navigation .next",
                prevEl: ".testimonial-navigation .prev",
            },
            pagination: {
                el: ".testimonial-navigation .slider-custom-pagination",
                clickable: true,
            },
            breakpoints: {
                780: {
                    slidesPerView: 1,
                },
            },
            thumbs: {
                swiper: Testimonial_Slider_1,
            },
        });
        var Testimonial_Slider_3 = new Swiper(".testimonial-content-slide", {
            loop: true,
            speed: 1000,
            spaceBetween: 30,
            slidesPerView: 1,
            watchSlidesVisibility: true,
            watchSlidesProgress: true,
            navigation: {
                nextEl: ".testimonial-navigation .next",
                prevEl: ".testimonial-navigation .prev",
            },
            pagination: {
                el: ".testimonial-navigation .slider-custom-pagination",
                clickable: true,
            },
            breakpoints: {
                780: {
                    slidesPerView: 1,
                },
            },
            thumbs: {
                swiper: Testimonial_Slider_1,
            },
        });

        Testimonial_Slider_2.controller.control = Testimonial_Slider_1;
        Testimonial_Slider_2.controller.control = Testimonial_Slider_3;
        Testimonial_Slider_3.controller.control = Testimonial_Slider_1;
        Testimonial_Slider_3.controller.control = Testimonial_Slider_2;

        /*====== Product-Slider ======*/
        var Product_Slider = new Swiper(".product-slider", {
            speed: 1000,
            spaceBetween: 32,
            slidesPerView: 1,
            watchSlidesVisibility: true,
            watchSlidesProgress: true,
            navigation: {
                nextEl: "#product-slider-control .navigation-control .next",
                prevEl: "#product-slider-control .navigation-control .prev",
            },
            pagination: {
                el: "#product-slider-control .pagination-control",
                clickable: true,
            },
            breakpoints: {
                576: {
                    slidesPerView: 2,
                },
                900: {
                    slidesPerView: 3,
                },
            },
        });
        /*-- Mail-Chimp Integration--*/
        $('#subscribe-form').ajaxChimp({
            url: 'http://www.devitfamily.us14.list-manage.com/subscribe/post?u=b2a3f199e321346f8785d48fb&amp;id=d0323b0697', //Set Your Mailchamp URL
            callback: function (resp) {
                if (resp.result === 'success') {
                    $('#subscribe-form .form-group').fadeOut();
                }
            }
        });
    });
    /*------------- preloader js --------------*/
    var startTime = performance.now();
    var count = 0;
    var counter = setInterval(function () {
        if (count < 101) {
            $('.preloader .count').text(count + '%');
            $('.preloader .load').css('width', count + '%');
            count++;
        } else {
            $('.preloader').fadeOut();
            clearInterval(counter);
        }
    }, Math.floor(startTime / 100));
    $(window).on('load', function () {
        $('.preloader').fadeOut();
    });
})(jQuery);