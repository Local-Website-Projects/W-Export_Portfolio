;(function($){
    $(document).on('ready', function(){   
        
        $('img').addClass('lazy');
        $('.lazy').Lazy();    
        
        /* Sticky-Menu-JS */
        $(window).scroll(function () {
            if($(window).scrollTop() > 300) {
                $(".mainmenu-area").addClass('sticky');
            } else {
                $(".mainmenu-area").removeClass('sticky');
            }
        });


        /* Navbar-Toggle-Button */
        $('.toggle').on('click',function(){
            $(this).toggleClass('active');
            return false;
        });
        
        $('.menu-toggle').on('click',function(){
            $('.mainmenu-area .nav-row .menu-items').slideToggle();
        });
        /* -- Submenu-Plus-Icon-Add --*/
        $('.mainmenu-area .menu-items li ul').each(function(){
            var items = $(this).children('li').length;
            $(this).parent('li').addClass('have-submenu');
            $(this).parent('li').append('<span class="plus"></span>');
            if( 8 < items ){
                $(this).addClass('over-items');
            }
        });
        
        $('.mainmenu-area .nav-row .menu-items ul li .plus').on('click', function(){
            $(this).parent().toggleClass('menu-open');
        });
        
        /*====== Header-Product-Slider ======*/
        var Product_Slider = new Swiper(".header-product-slider", {
            loop: true,
            speed: 1000,
            spaceBetween: 0,
            slidesPerView: 1,
            watchSlidesVisibility: true,
            watchSlidesProgress: true,
            navigation: {
                nextEl: ".header-product-slider .arrow_next",
                prevEl: ".header-product-slider .arrow_prev",
            },
            pagination: {
                el: ".header-product-slider .slider-custom-pagination",
                clickable: true,
            },
            breakpoints: {
                380: {
                    slidesPerView: 2,
                },
                680: {
                    slidesPerView: 3,
                },
            },
        });
        /*====== Testimonial-Slider ======*/
        var Testimonial_Slider = new Swiper(".testimonial-slider", {
            loop: true,
            speed: 1000,
            spaceBetween: 0,
            slidesPerView: 1,
            watchSlidesVisibility: true,
            watchSlidesProgress: true,
            navigation: {
                nextEl: "#testimonial-slider-control .navigation-control .next",
                prevEl: "#testimonial-slider-control .navigation-control .prev",
            },
            pagination: {
                el: "#testimonial-slider-control .pagination-control",
                clickable: true,
            },
        });
        /*====== Product-Slider ======*/
        var Product_Slider = new Swiper(".product-slider", {
            loop: true,
            speed: 1000,
            spaceBetween: 0,
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
                575: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 3,
                },
                1250: {
                    slidesPerView: 4,
                },
            },
        });        
        /*-- Mail-Chimp Integration--*/
        $('#subscribe-form').ajaxChimp({
            url: 'http://www.devitfamily.us14.list-manage.com/subscribe/post?u=b2a3f199e321346f8785d48fb&amp;id=d0323b0697', //Set Your Mailchamp URL
            callback: function (resp) {
                if (resp.result === 'success') {
                    $('.subscribe-form input[type="email"], .subscribe-form button[type="submit"]').fadeOut();
                }
            }
        });
    });
    /*------------- preloader js --------------*/
    var startTime = performance.now();
    var count=0;
    var counter= setInterval(function() {
        if(count<101){
        $('.preloader .count').text(count+'%');
        $('.preloader .load').css('width', count+'%');
        count++; 
        }else {
        $('.preloader').fadeOut();
        clearInterval(counter);
        }
    }, Math.floor(startTime/100));

    $(window).on('load', function(){
        $('.preloader').fadeOut();
    });

})(jQuery);