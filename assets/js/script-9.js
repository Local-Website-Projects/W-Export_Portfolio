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
        $('.product-toggle').on('click',function(){
            $('body').toggleClass('nav-product-show');
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
        $('.footer-nav-links').each(function(){
            var items = $(this).children('li').length;
            if( 5 < items ){
                $(this).addClass('over-items');
            }
        });        

        $('.mainmenu-area .nav-row .menu-items ul li .plus').on('click', function(){
            $(this).parent().toggleClass('menu-open');
        });
        
        /*====== Header-Product-Slider ======*/
        var Product_Slider = new Swiper(".header-product-slide", {
            loop: true,
            speed: 1000,
            spaceBetween: 0,
            slidesPerView: 1,
            watchSlidesVisibility: true,
            watchSlidesProgress: true,
            pagination: {
                el: "#header-slider-pagination",
                clickable: true,
                renderBullet: function (index, className) {
                  var index = ++index;
                  return '<span class="' + className + '">' + (index > 9 ? index : '0'+index) + "</span>";
                },
            },
        });

        /*====== Testimonial-Photo-Slider ======*/
        var Testimonial_Photo = new Swiper(".testi-photo-slider", {
            loop: false,
            speed: 1000,
            effect: "coverflow",
            grabCursor: true,
            coverflowEffect: {
              rotate: 0,
              stretch: 100,
              depth: 500,
              modifier: 1,
              slideShadows: false,
            },
            breakpoints: {
                580: {
                    coverflowEffect: {
                      rotate: 0,
                      stretch: 400,
                      depth: 500,
                      modifier: 1,
                      slideShadows: false,
                    },
                },
                1200: {
                    coverflowEffect: {
                      rotate: 0,
                      stretch: 800,
                      depth: 500,
                      modifier: 1,
                      slideShadows: false,
                    },
                },
            },
        });   
        
        /*====== Testimonial-Content-Slider ======*/
        var Testimonial_Content = new Swiper(".testi-content-slider", {
            loop: false,
            speed: 1000,
            spaceBetween: 0,
            slidesPerView: 1,
            watchSlidesVisibility: true,
            watchSlidesProgress: true, 
            navigation: {
                nextEl: "#testi-pagination .arrow-next",
                prevEl: "#testi-pagination .arrow-prev",
            },
            pagination: {
                el: "#testimonial-slider-control .pagination-control",
                clickable: true,
            },
        });        
        Testimonial_Photo.controller.control = Testimonial_Content;
        Testimonial_Content.controller.control = Testimonial_Photo;
                
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