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

        $('.target-button').on('click', function(){
            var target = $(this).data('target');
            $(this).toggleClass('button-active');
            $(target).fadeToggle();
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
              
        /*====== Testimonial-Slider ======*/        
        var Testimonial_Slider_Menu = [
            '<img src="assets/images/theme-5/client-1.png" alt="">',
            '<img src="assets/images/theme-5/client-2.png" alt="">',
            '<img src="assets/images/theme-5/client-3.png" alt="">',
            '<img src="assets/images/theme-5/client-4.png" alt="">',
            '<img src="assets/images/theme-5/client-5.png" alt="">',
            '<img src="assets/images/theme-5/client-6.png" alt="">',
            '<img src="assets/images/theme-5/client-7.png" alt="">'
        ];
        var Testimonial_Slider_1 = new Swiper(".testimonial-content-slide", {
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
                el: '#testimonial_slider_pagination',
                bulletClass: 'bullet',
                bulletActiveClass: 'active',
                clickable: true,
                renderBullet: function (index, className) {
                    return '<span class="'+ (index == 1 ? `carousel_mid_item` : `carousel__item`) + ' ' + className + '">' + (Testimonial_Slider_Menu[index]) + '</span>';
                }
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
        
        /*-- Mail-Chimp Integration--*/
        $('#subscribe-form').ajaxChimp({
            url: 'http://www.devitfamily.us14.list-manage.com/subscribe/post?u=b2a3f199e321346f8785d48fb&amp;id=d0323b0697', //Set Your Mailchamp URL
            callback: function (resp) {
                if (resp.result === 'success') {
                    $('#subscribe-form .form-group').fadeOut();
                }
            }
        });        
        $('.carousel').each(function(){ 
            var lomba = $(this).outerWidth(),
            delay = 0,
            item = $(this).find('.carousel__item').length,
            step = 20 / item; /* 5 is the animation duration */
            $(this).css('height', lomba+'px');
            $(this).find('.carousel__item').each(function() {
                var lomba = $(this).outerWidth();
                let rand = Math.floor((Math.random() * 40) + 5);
                $(this).css('width', lomba+rand+'px');
                $(this).css('height', lomba+rand+'px');
                $(this).css('animation-delay', -delay + "s");
                delay += step;
            });
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