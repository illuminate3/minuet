$(function() {
    
    "use strict";
    
    
    /*=============================================
    =                   Sticky                    =
    =============================================*/
    
    $(window).on('scroll', function(event) {    
        var scroll = $(window).scrollTop();
        if (scroll < 110) {
            $(".navigation").removeClass("sticky");
        } else{
            $(".navigation").addClass("sticky");
        }
    });

    /*=====  End of Sticky  ======*/
    

    /*=============================================
    =                  Menu                 =
    =============================================*/

    $( ".sub-menu" ).parent( "li" ).addClass( "menu-item-has-children" );

    /*=====  End of Sticky  ======*/

    /*=============================================
    =                 Slick Slider                =
    =============================================*/
    
    function mainSlider() {
            
        var BasicSlider = $('.slider-active');
            
        BasicSlider.on('init', function(e, slick) {
            var $firstAnimatingElements = $('.single-slider:first-child').find('[data-animation]');
            doAnimations($firstAnimatingElements);
        });
            
        BasicSlider.on('beforeChange', function(e, slick, currentSlide, nextSlide) {
            var $animatingElements = $('.single-slider[data-slick-index="' + nextSlide + '"]').find('[data-animation]');
            doAnimations($animatingElements);
        });
            
        BasicSlider.slick({
            autoplay: true,
            autoplaySpeed: 10000,
            pauseOnHover: false,
            dots: false,
            fade: true,
			      arrows: true,
            prevArrow:'<span class="prev"><i class="ion-ios-arrow-back"></i></span>',
            nextArrow: '<span class="next"><i class="ion-ios-arrow-forward"></i></span>',
            responsive: [            
              {
                breakpoint: 1200,
                settings: {
                  arrows: false,
                  dots: true,
                }
              },
              {
                breakpoint: 992,
                settings: {
                  arrows: false,
                  dots: true,
                }
              },
              {
                breakpoint: 768,
                settings: {
                  arrows: false,
                  dots: true,
                }
              },
              {
                breakpoint: 576,
                settings: {
                  arrows: false,
                  dots: true,
                }
              }
            ] 
        });

        function doAnimations(elements) {
            var animationEndEvents = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
            elements.each(function() {
                var $this = $(this);
                var $animationDelay = $this.data('delay');
                var $animationType = 'animated ' + $this.data('animation');
                $this.css({
                    'animation-delay': $animationDelay,
                    '-webkit-animation-delay': $animationDelay
                });
                $this.addClass($animationType).one(animationEndEvents, function() {
                    $this.removeClass($animationType);
                });
            });
        }
    }
    mainSlider();

    /*=====  End of Slick Slider  ======*/


    /*=============================================
    =            Bootstrap dropdown               =
    =============================================*/

    // Add slideDown animation to Bootstrap dropdown when expanding.

    $('.dropdown').on('show.bs.dropdown', function() {
        $(this).find('.dropdown-menu').first().stop(true, true).slideDown();
    });
    // Add slideUp animation to Bootstrap dropdown when collapsing.
    $('.dropdown').on('hide.bs.dropdown', function() {
        $(this).find('.dropdown-menu').first().stop(true, true).slideUp();
    });

    $('.cart-dropdown').hover(function() {
        $('.dropdown-menu', this).stop(true, true).slideDown(500);
        $(this).addClass('open');
    }, function() {
        $('.dropdown-menu', this).stop(true, true).slideUp(500);
        $(this).removeClass('open');
    });

  /*=====  End of Bootstrap dropdown ======*/
    

    /*=============================================
    =                Sumo Select                  =
    =============================================*/

    $('.optgroup_test').SumoSelect();

    /*=====  End of Sumo Select  ======*/
    

    /*=============================================
    =           Search Field Show                 =
    =============================================*/
  
    $(".field-toggle").on('click', function(){
        $(".field-toggle-wrapper").slideToggle("slow");
    });

    $(".field-toggle").on('click', function(){
        $(this).toggleClass("shown");
    });

    
    /*=====  End of Search Field Show ======*/


    /*=============================================
    =                Mobile Menu                  =
    =============================================*/

    $('.navbar-mobile-open').on('click', function(){
        $('.mobile-navigation').addClass('open')
        $('.overlay').addClass('open')
    });
    
    $('.close-navbar-mobile').on('click', function(){
        $('.mobile-navigation').removeClass('open')
        $('.overlay').removeClass('open')
    });
    
    $('.overlay').on('click', function(){
        $('.mobile-navigation').removeClass('open')
        $('.overlay').removeClass('open')
    });
        
    
    /*Variables*/
    var $offCanvasNav = $('.mobile-navigation'),
        $offCanvasNavSubMenu = $offCanvasNav.find('.sub-menu');

    /*Add Toggle Button With Off Canvas Sub Menu*/
    $offCanvasNavSubMenu.parent().prepend('<span class="mobile-menu-expand"></span>');

    /*Close Off Canvas Sub Menu*/
    $offCanvasNavSubMenu.slideUp();

    /*Category Sub Menu Toggle*/
    $offCanvasNav.on('click', 'li a, li .mobile-menu-expand, li .menu-title', function(e) {
        var $this = $(this);
        if (($this.parent().attr('class').match(/\b(menu-item-has-children|has-children|has-sub-menu)\b/)) && ($this.attr('href') === '#' || $this.hasClass('mobile-menu-expand'))) {
            e.preventDefault();
            if ($this.siblings('ul:visible').length) {
                $this.parent('li').removeClass('active-expand');
                $this.siblings('ul').slideUp();
            } else {
                $this.parent('li').addClass('active-expand');
                $this.closest('li').siblings('li').find('ul:visible').slideUp();
                $this.closest('li').siblings('li').removeClass('active-expand');
                $this.siblings('ul').slideDown();
            }
        }
    });
    
    $( ".sub-menu" ).parent( "li" ).addClass( "menu-item-has-children" );

    /*=====  End of Navbar Category ======*/


    /*=============================================
    =              Magnific Popup                 =
    =============================================*/

    $('.video-popup').magnificPopup({
        type: 'iframe'
        // other options
    });

    $('.image-popup').magnificPopup({
        type: 'image',
        gallery:{
          enabled:true
        }
      });

    /*=====  End of Magnific Popup ======*/


    /*=============================================
    =             Newsletter Remove               =
    =============================================*/

    $('.newsletter-overlay').on('click', function(){
        $('.newsletter-popup').fadeOut()
        $(this).fadeOut()
    });
    $('.close').on('click', function(){
        $('.newsletter-popup').fadeOut()
        $('.newsletter-overlay').fadeOut()
    });

    /*=====  End of Newsletter Remove ======*/


    /*=============================================
    =             Trending Active                 =
    =============================================*/

    $('.trending-active').slick({
        dots: false,
        infinite: true,
        arrows: true,
        prevArrow:'<span class="prev"><i class="ion-ios-arrow-back"></i></span>',
        nextArrow: '<span class="next"><i class="ion-ios-arrow-forward"></i></span>',
        speed: 800,
        slidesToShow: 5,
        slidesToScroll: 1,      
        responsive: [            
          {
            breakpoint: 1200,
            settings: {
              slidesToShow: 4,
            }
          },
          {
            breakpoint: 992,
            settings: {
              slidesToShow: 3,
            }
          },
          {
            breakpoint: 768,
            settings: {
              slidesToShow: 2,
            }
          },
          {
            breakpoint: 576,
            settings: {
              slidesToShow: 1,
            }
          }
        ]  
    });
  
    /*===== End of Trending Active ======*/


    /*=============================================
    =                Cars Active                  =
    =============================================*/

    $('.cars-active').slick({
        dots: false,
        infinite: true,
        arrows: true,
        prevArrow:'<span class="prev"><i class="ion-ios-arrow-back"></i></span>',
        nextArrow: '<span class="next"><i class="ion-ios-arrow-forward"></i></span>',
        speed: 800,
        slidesToShow: 4,
        slidesToScroll: 1,      
        responsive: [            
          {
            breakpoint: 1200,
            settings: {
              slidesToShow: 3,
            }
          },
          {
            breakpoint: 992,
            settings: {
              slidesToShow: 2,
            }
          },
          {
            breakpoint: 768,
            settings: {
              slidesToShow: 2,
            }
          },
          {
            breakpoint: 576,
            settings: {
              slidesToShow: 1,
            }
          }
      ]  
    });


    $('.cars-active-2').slick({
        dots: false,
        infinite: true,
        arrows: true,
        prevArrow:'<span class="prev"><i class="ion-ios-arrow-back"></i></span>',
        nextArrow: '<span class="next"><i class="ion-ios-arrow-forward"></i></span>',
        speed: 800,
        slidesToShow: 5,
        slidesToScroll: 1,      
        responsive: [            
          {
            breakpoint: 1600,
            settings: {
              slidesToShow: 4,
            }
          },
          {
            breakpoint: 1200,
            settings: {
              slidesToShow: 3,
            }
          },
          {
            breakpoint: 992,
            settings: {
              slidesToShow: 2,
            }
          },
          {
            breakpoint: 768,
            settings: {
              slidesToShow: 1,
            }
          },
          {
            breakpoint: 576,
            settings: {
              slidesToShow: 1,
            }
          }
      ]  
    });

    
    $('.cars-active-3').slick({
        dots: false,
        infinite: true,
        arrows: true,
        prevArrow:'<span class="prev"><i class="ion-ios-arrow-back"></i></span>',
        nextArrow: '<span class="next"><i class="ion-ios-arrow-forward"></i></span>',
        speed: 800,
        slidesToShow: 2,
        slidesToScroll: 1,      
        responsive: [          
          {
            breakpoint: 1200,
            settings: {
              slidesToShow: 2,
            }
          },
          {
            breakpoint: 992,
            settings: {
              slidesToShow: 2,
            }
          },
          {
            breakpoint: 768,
            settings: {
              slidesToShow: 1,
            }
          },
          {
            breakpoint: 576,
            settings: {
              slidesToShow: 1,
              dots: true,
              arrows: false,
            }
          }
      ]  
    });
  
    /*===== End of Trending Active ======*/


    /*=============================================
    =            Testimonial Active               =
    =============================================*/

    $('.testimonial-active').slick({
        dots: false,
        infinite: true,
        arrows: true,
        prevArrow:'<span class="prev"><i class="ion-ios-arrow-back"></i></span>',
        nextArrow: '<span class="next"><i class="ion-ios-arrow-forward"></i></span>',
        speed: 800,
        slidesToShow: 2,
        slidesToScroll: 1,      
        responsive: [            
          {
            breakpoint: 1200,
            settings: {
              slidesToShow: 2,
            }
          },
          {
            breakpoint: 992,
            settings: {
              slidesToShow: 1,
            }
          },
          {
            breakpoint: 768,
            settings: {
              slidesToShow: 1,
            }
          },
          {
            breakpoint: 576,
            settings: {
              slidesToShow: 1,
            }
          }
      ]  
    });
  
    /*===== End of Trending Active ======*/


    /*=============================================
    =             Car Logo Active                 =
    =============================================*/

    $('.car-logo-active').slick({
      dots: false,
      infinite: true,
      arrows: true,
      prevArrow:'<span class="prev"><i class="ion-ios-arrow-back"></i></span>',
      nextArrow: '<span class="next"><i class="ion-ios-arrow-forward"></i></span>',
      speed: 800,
      slidesToShow: 8,
      slidesToScroll: 1,
      responsive: [
        {
          breakpoint: 1200,
          settings: {
            slidesToShow: 7,
          }
        },
        {
          breakpoint: 992,
          settings: {
            slidesToShow: 4,
          }
        },
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 3,
          }
        },
        {
          breakpoint: 576,
          settings: {
            slidesToShow: 2,
          }
        }
      ]  
    });

    /*===== End of Car Logo Active ======*/


    /*=============================================
     =           Browse Type Active               =
    =============================================*/

    $('.browse-type-active').slick({
      dots: false,
      infinite: true,
      arrows: true,
      prevArrow:'<span class="prev"><i class="ion-ios-arrow-back"></i></span>',
      nextArrow: '<span class="next"><i class="ion-ios-arrow-forward"></i></span>',
      speed: 800,
      slidesToShow: 4,
      slidesToScroll: 1,      
      responsive: [            
        {
          breakpoint: 1200,
          settings: {
            slidesToShow: 4,
          }
        },
        {
          breakpoint: 992,
          settings: {
            slidesToShow: 3,
          }
        },
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 2,
          }
        },
        {
          breakpoint: 576,
          settings: {
            slidesToShow: 1,
          }
        }
      ]  
    });

    /*===== End of Browse Type Active ======*/


    /*=============================================
    =               Brand Active                  =
    =============================================*/

    $('.brand-active').slick({
      dots: false,
      infinite: true,
      arrows: false,
      prevArrow:'<span class="prev"><i class="ion-ios-arrow-back"></i></span>',
      nextArrow: '<span class="next"><i class="ion-ios-arrow-forward"></i></span>',
      autoplay: true,
      speed: 800,
      slidesToShow: 6,
      slidesToScroll: 1,
      responsive: [
        {
          breakpoint: 1200,
          settings: {
            slidesToShow: 6,
          }
        },
        {
          breakpoint: 992,
          settings: {
            slidesToShow: 4,
          }
        },
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 4,
          }
        },
        {
          breakpoint: 576,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2,
          }
        }
      ]  
    });

    /*===== End of Car Logo Active ======*/


    /*=============================================
    =               Team Active                   =
    =============================================*/

    $('.team-active').slick({
      dots: false,
      infinite: true,
      arrows: true,
      prevArrow:'<span class="prev"><i class="ion-ios-arrow-back"></i></span>',
      nextArrow: '<span class="next"><i class="ion-ios-arrow-forward"></i></span>',
      speed: 800,
      slidesToShow: 4,
      slidesToScroll: 1,      
      responsive: [            
        {
          breakpoint: 1200,
          settings: {
            slidesToShow: 3,
          }
        },
        {
          breakpoint: 992,
          settings: {
            slidesToShow: 2,
          }
        },
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 2,
          }
        },
        {
          breakpoint: 576,
          settings: {
            slidesToShow: 1,
            dots: true,
            arrows: false,
          }
        }
      ]  
    });

    /*===== End of Team Active ======*/
       
    
    /*=============================================
    =                Testimonial                  =
    =============================================*/

    $('.testimonial-content-active').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      dots: false,
      arrows: false,
      fade: true,
      asNavFor: '.testimonial-author-active'
    });

    $('.testimonial-author-active').slick({
      slidesToShow: 3,
      slidesToScroll: 1,
      asNavFor: '.testimonial-content-active',
      dots: false,
      arrows: false,
      focusOnSelect: true,
      responsive: [        
        {
          breakpoint: 992,
          settings: {
            slidesToShow: 3,
          }
        },
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 2,
          }
        },
        {
          breakpoint: 576,
          settings: {
            slidesToShow: 1,
          }
        }
      ] 
    });


    /*===== End of Testimonial ======*/


    /*=============================================
    =              Testimonial 2                  =
    =============================================*/

    $('.testimonial-content-2-active').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      dots: false,
      arrows: true,
      prevArrow:'<span class="prev"><i class="ion-ios-arrow-back"></i></span>',
      nextArrow: '<span class="next"><i class="ion-ios-arrow-forward"></i></span>',
      fade: true,
      asNavFor: '.testimonial-author-2-active'
    });

    $('.testimonial-author-2-active').slick({
      slidesToShow: 3,
      slidesToScroll: 1,
      asNavFor: '.testimonial-content-2-active',
      dots: false,
      arrows: false,
      focusOnSelect: true,
      responsive: [        
        {
          breakpoint: 992,
          settings: {
            slidesToShow: 3,
          }
        },
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 2,
          }
        },
        {
          breakpoint: 576,
          settings: {
            slidesToShow: 1,
          }
        }
      ] 
    });


    /*===== End of Testimonial 2 ======*/
       
    
    /*=============================================
    =            Inventory Gallery                =
    =============================================*/

    $('.inventory-gallery-active').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: false,
      centerMode: true,
      centerPadding: '300px',
      asNavFor: '.inventory-thumb-active',
      speed: 800,
      infinite: true,
      responsive: [        
        {
          breakpoint: 1600,
          settings: {
            centerPadding: '150px',
          }
        },       
        {
          breakpoint: 1200,
          settings: {
            centerPadding: '100px',
          }
        },
        {
          breakpoint: 992,
          settings: {
            centerMode: false,
            centerPadding: '0',
          }
        }
      ] 
    });
    
    $('.inventory-thumb-active').slick({
      slidesToShow: 4,
      slidesToScroll: 1,
      asNavFor: '.inventory-gallery-active',
      arrows: false,
      dots: false,
      focusOnSelect: true,
      infinite: true,
      responsive: [
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 3,
            centerMode: true,
            centerPadding: '0',
          }
        }
      ] 
    });

    /*===== End of Inventory Gallery ======*/

    /*=============================================
    =         Dealership Gallery Active           =
    =============================================*/

    $('.dealership-gallery-active').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: true,
      prevArrow:'<span class="prev"><i class="ion-ios-arrow-back"></i></span>',
      nextArrow: '<span class="next"><i class="ion-ios-arrow-forward"></i></span>',
      asNavFor: '.dealership-gallery-thumb-active',
      speed: 800,
      infinite: true,      
    });
    
    $('.dealership-gallery-thumb-active').slick({
      slidesToShow: 4,
      slidesToScroll: 1,
      asNavFor: '.dealership-gallery-active',
      arrows: true,
      prevArrow:'<span class="prev"><i class="ion-ios-arrow-back"></i></span>',
      nextArrow: '<span class="next"><i class="ion-ios-arrow-forward"></i></span>',
      dots: false,
      focusOnSelect: true,
      infinite: true,
      responsive: [
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 3,
            centerMode: true,
            centerPadding: '0',
          }
        }
      ] 
    });

    /*===== End of Dealership Gallery Active ======*/


    /*=============================================
    =               Post Wrapper                  =
    =============================================*/

    $('.post-wrapper').slick({
      dots: false,
      infinite: true,
      arrows: true,
      prevArrow: '<span class="prev"><i class="ion-ios-arrow-back"></i></span>',
      nextArrow: '<span class="next"><i class="ion-ios-arrow-forward"></i></span>',
      speed: 800,
      slidesToShow: 1,
      slidesToScroll: 1,  
    });
    
    /*=====  End of Post Wrapper ======*/


    /*=============================================
    =           Blog Features Active              =
    =============================================*/

    $('.blog-feature-active').slick({
      dots: false,
      infinite: true,
      arrows: true,
      prevArrow: '<span class="prev"><i class="ion-ios-arrow-back"></i></span>',
      nextArrow: '<span class="next"><i class="ion-ios-arrow-forward"></i></span>',
      speed: 800,
      slidesToShow: 1,
      slidesToScroll: 1,  
      responsive: [            
        {
          breakpoint: 1200,
          settings: {
            arrows: false,
            dots: true,
          }
        },
        {
          breakpoint: 992,
          settings: {
            arrows: false,
            dots: true,
          }
        },
        {
          breakpoint: 768,
          settings: {
            arrows: false,
            dots: true,
          }
        },
        {
          breakpoint: 576,
          settings: {
            arrows: false,
            dots: true,
          }
        }
      ]
    });
    
    /*=====  End of Blog Features Active ======*/


    /*=============================================
    =           Blog Features Active              =
    =============================================*/

    $('.news-image-gallery').slick({
      dots: false,
      infinite: true,
      arrows: true,
      prevArrow: '<span class="prev"><i class="ion-ios-arrow-back"></i></span>',
      nextArrow: '<span class="next"><i class="ion-ios-arrow-forward"></i></span>',
      speed: 800,
      slidesToShow: 1,
      slidesToScroll: 1,      
    });
    
    /*=====  End of Blog Features Active ======*/


    /*=============================================
    =               Rating Active                 =
    =============================================*/

    /* 1. Visualizing things on Hover - See next part for action on click */
    $('#stars li').on('mouseover', function(){
        var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on
        
        // Now highlight all the stars that's not after the current hovered star
        $(this).parent().children('li.star').each(function(e){
            if (e < onStar) {
                $(this).addClass('hover');
            }
            else {
                $(this).removeClass('hover');
            }
        });
        
    }).on('mouseout', function(){
        $(this).parent().children('li.star').each(function(e){
            $(this).removeClass('hover');
        });
    });

    /* 2. Action to perform on click */
    var spansCounts =  $('#stars li').length
    $('#stars li').on('click', function(e) {
        console.log($(this).index())
        $('#stars li').removeClass('selected');

        for(var i=0 ; i < $(this).index() + 1; i++){
            $('#stars li').eq(i).addClass('selected')
        }
    })   
      

    /*=====  End of Rating Active ======*/


    /*=============================================
    =                Back to top                  =
    =============================================*/

  //  Show or hide the sticky footer button
    $(window).on('scroll', function(event) {
        if($(this).scrollTop() > 200){
            $('.back-to-top').fadeIn(200)
        } else{
            $('.back-to-top').fadeOut(200)
        }
    });
    
    
    //Animate the scroll to yop
    $('.back-to-top').on('click', function(event) {
        event.preventDefault();
        
        $('html, body').animate({
            scrollTop: 0,
        }, 1500);
    });

    

    /*=====  End of Back to top ======*/


    /*=============================================
    =             Car Color Active                =
    =============================================*/

    $('.color-items li span').each(function() {
        var get_color = $(this).attr('data-color');
        $(this).css("background-color", get_color);
    });        
        
    /*=====  End of Car Color Active ======*/
       
    
    /*=============================================
    =                Datepicker                   =
    =============================================*/

    // $('#datepicker').datepicker({
    //     uiLibrary: 'bootstrap4',
    //     icons: {
    //       rightIcon: '<i class="ion-android-calendar"></i>'
    //     }
    // });

    /*=====  End of Datepicker ======*/
    
    
    /*=============================================
    =              File Upload Js                 =
    =============================================*/
    
    var inputs = document.querySelectorAll('.file-input')

    for (var i = 0, len = inputs.length; i < len; i++) {
      customInput(inputs[i])
    }
    
    function customInput (el) {
      const fileInput = el.querySelector('[type="file"]')
      const label = el.querySelector('[data-js-label]')
      
      fileInput.onchange =
      fileInput.onmouseout = function () {
        if (!fileInput.value) return
        
        var value = fileInput.value.replace(/^.*[\\\/]/, '')
        el.className += ' -chosen'
        label.innerText = value
      }
    }

    /*=====  End of  ======*/
    
    
    /*=============================================
    =                Countdown                    =
    =============================================*/

    $('[data-countdown]').each(function() {
      var $this = $(this), finalDate = $(this).data('countdown');
      $this.countdown(finalDate, function(event) {
        $this.html(event.strftime('<div class="count-items d-flex justify-content-center"><div class="single-count"><span class="count">%D</span><p>Days</p></div><div class="single-count"><span class="count">%H</span><p>Hours</p></div><div class="single-count"><span class="count">%M</span><p>Minutes</p></div><div class="single-count"><span class="count">%S</span><p>Seconds</p></div></div>'));
      });
    });

    /*=====  End of Countdown ======*/
    
    
    /*=============================================
    =                                  =
    =============================================*/

    

    /*=====  End of  ======*/

    
    
    
});

