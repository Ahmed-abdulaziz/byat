(function($) {

	"use strict";


	$(window).stellar({
    responsive: true,
    parallaxBackgrounds: true,
    parallaxElements: true,
    horizontalScrolling: false,
    hideDistantElements: false,
    scrollProperty: 'scroll'
  });


	var fullHeight = function() {

		$('.js-fullheight').css('height', $(window).height());
		$(window).resize(function(){
			$('.js-fullheight').css('height', $(window).height());
		});

	};
	fullHeight();

	// loader
	var loader = function() {
		setTimeout(function() { 
			if($('#ftco-loader').length > 0) {
				$('#ftco-loader').removeClass('show');
			}
		}, 1);
	};
	loader();

  var carousel = function() {
		$('.home-slider').owlCarousel({
	    loop:true,
	    autoplay: true,
	    margin:0,
	    nav:true,
	    dots: true,
	    autoplayHoverPause: false,
	    items: 1,
	    navText : ["<span class='ion-ios-arrow-back'></span>","<span class='ion-ios-arrow-forward'></span>"],
	    responsive:{
	      0:{
	        items:1
	      },
	      600:{
	        items:1
	      },
	      1000:{
	        items:1
	      }
	    }
		});

		$('.adv-slider').owlCarousel({
			loop:true,
			autoplay: true,
			margin:0,
			nav:true,
			dots: true,
			autoplayHoverPause: false,
			items: 1,
			navText : ["<span class='ion-ios-arrow-back'></span>","<span class='ion-ios-arrow-forward'></span>"],
			responsive:{
			  0:{
				items:1
			  },
			  600:{
				items:1
			  },
			  1000:{
				items:1
			  }
			}
			});

			$('.home-inner-slider').owlCarousel({
				loop:true,
				autoplay: true,
				margin:0,
				nav:true,
				dots: true,
				autoplayHoverPause: false,
				items: 1,
				navText : ["<span class='ion-ios-arrow-back'></span>","<span class='ion-ios-arrow-forward'></span>"],
				responsive:{
				  0:{
					items:1
				  },
				  600:{
					items:1
				  },
				  1000:{
					items:1
				  }
				}
				});

		$('.carousel-testimony').owlCarousel({
			center: true,
			loop: true,
			items:1,
			margin: 30,
			stagePadding: 0,
			nav: false,
			navText: ['<span class="ion-ios-arrow-back">', '<span class="ion-ios-arrow-forward">'],
			responsive:{
				0:{
					items: 1
				},
				600:{
					items: 2
				},
				1000:{
					items: 3
				}
			}
		});

		$('.carousel-testimony2').owlCarousel({
			center: true,
			loop: true,
			items:1,
			margin: 30,
			stagePadding: 0,
			nav: false,
			navText: ['<span class="ion-ios-arrow-back">', '<span class="ion-ios-arrow-forward">'],
			responsive:{
				0:{
					items: 1
				},
				600:{
					items: 2
				},
				1000:{
					items: 3
				}
			}
		});

	};
	carousel();



	$('nav .dropdown').hover(function(){
		var $this = $(this);
		// 	 timer;
		// clearTimeout(timer);
		$this.addClass('show');
		$this.find('> a').attr('aria-expanded', true);
		// $this.find('.dropdown-menu').addClass('animated-fast fadeInUp show');
		$this.find('.dropdown-menu').addClass('show');
	}, function(){
		var $this = $(this);
			// timer;
		// timer = setTimeout(function(){
			$this.removeClass('show');
			$this.find('> a').attr('aria-expanded', false);
			// $this.find('.dropdown-menu').removeClass('animated-fast fadeInUp show');
			$this.find('.dropdown-menu').removeClass('show');
		// }, 100);
	});


	$('#dropdown04').on('show.bs.dropdown', function () {
	  console.log('show');
	});

	// magnific popup
	$('.image-popup').magnificPopup({
    type: 'image',
    closeOnContentClick: true,
    closeBtnInside: false,
    fixedContentPos: true,
    mainClass: 'mfp-no-margins mfp-with-zoom', // class to remove default margin from left and right side
     gallery: {
      enabled: true,
      navigateByImgClick: true,
      preload: [0,1] // Will preload 0 - before current, and 1 after the current image
    },
    image: {
      verticalFit: true
    },
    zoom: {
      enabled: true,
      duration: 300 // don't foget to change the duration also in CSS
    }
  });


  var counter = function() {
		
		$('#section-counter').waypoint( function( direction ) {

			if( direction === 'down' && !$(this.element).hasClass('ftco-animated') ) {

				var comma_separator_number_step = $.animateNumber.numberStepFactories.separator(',')
				$('.number').each(function(){
					var $this = $(this),
						num = $this.data('number');
						console.log(num);
					$this.animateNumber(
					  {
					    number: num,
					    numberStep: comma_separator_number_step
					  }, 7000
					);
				});
				
			}

		} , { offset: '95%' } );

	}
	counter();

	var contentWayPoint = function() {
		var i = 0;
		$('.ftco-animate').waypoint( function( direction ) {

			if( direction === 'down' && !$(this.element).hasClass('ftco-animated') ) {
				
				i++;

				$(this.element).addClass('item-animate');
				setTimeout(function(){

					$('body .ftco-animate.item-animate').each(function(k){
						var el = $(this);
						setTimeout( function () {
							var effect = el.data('animate-effect');
							if ( effect === 'fadeIn') {
								el.addClass('fadeIn ftco-animated');
							} else if ( effect === 'fadeInLeft') {
								el.addClass('fadeInLeft ftco-animated');
							} else if ( effect === 'fadeInRight') {
								el.addClass('fadeInRight ftco-animated');
							} else {
								el.addClass('fadeInUp ftco-animated');
							}
							el.removeClass('item-animate');
						},  k * 50, 'easeInOutExpo' );
					});
					
				}, 100);
				
			}

		} , { offset: '95%' } );
	};
	contentWayPoint();

	$(".sidebar-dropdown > h4").click(function() {
		$(".sidebar-submenu").slideUp(200);
		if (
		  $(this)
			.parent()
			.hasClass("active")
		) {
		  $(".sidebar-dropdown").removeClass("active");
		  $(this)
			.parent()
			.removeClass("active");
		} else {
		  $(".sidebar-dropdown").removeClass("active");
		  $(this)
			.next(".sidebar-submenu")
			.slideDown(200);
		  $(this)
			.parent()
			.addClass("active");
		}
	  });

	/*  $('.fav-star').click(function(){
        $(this).toggleClass('fav-star-click');
	  });
*/
	  $('.fav-star').click(function() {
		$(this).find('.fa-star-o,.fa-star').toggleClass('fa-star-o').toggleClass('fa-star');
	  });

	  $("#checkAll").click(function () {
		$('input:checkbox').not(this).prop('checked', this.checked);
	});

	$(document).ready(function () { 
        if($(window).width() < 991) { 
           $("#collapseExample").removeClass("show");   
        }     
    }); 

	  
	  /*For total*/
		$(document).ready(function() {
			$(".checkout").on("input", ".quantity", function() {
			var price = +$(".price").data("price");
			var quantity = +$(this).val();
			$("#total").text("$" + price * quantity);
			})
		
			var $buttonPlus = $('.increase-btn');
			var $buttonMin = $('.decrease-btn');
			var $quantity = $('.quantity');
			
			/*For plus and minus buttons*/
			$buttonPlus.click(function() {
			$quantity.val(parseInt($quantity.val()) + 1).trigger('input');
			});
			
			$buttonMin.click(function() {
			$quantity.val(Math.max(parseInt($quantity.val()) - 1, 0)).trigger('input');
			});
		});

		$("body").on("click","input[name='why']",function() {
			if($("input[name='why']:checked").val()== 'other'){
				$("textarea[name='why_other']").css('display', 'block');
			} else {
				$("textarea[name='why_other']").css('display', 'none');
				$("textarea[name='why_other']").val('');
			}
		});


		
		var readMore = jQuery(document).ready(function () {

            $(".section .toggle").click(function () {
                var elem = $(this).text();
                if (elem == "أقرا المزيد") {
                    //Stuff to do when btn is in the read more state
                    $(this).text("أقرا اقل");
                    $(this).parent().find('.readmore').fadeIn();
                } else {
                    //Stuff to do when btn is in the read less state
                    $(this).text("أقرا المزيد");
                    $(this).parent().find('.readmore').fadeOut();
                }
            });
		});

		$(".choose-pack li.media").click(function() {
			$(".choose-pack li.media").css("background-color", "white");
			$(this).css("background-color", "#ebebeb");
		});
		

	const togglePassword = document.querySelector("#togglePassword");
        const password = document.querySelector("#password");

        togglePassword.addEventListener("click", function () {
            // toggle the type attribute
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);
            
            // toggle the icon
            this.classList.toggle("bi-eye");
        });

        // prevent form submit
        const form = document.querySelector("form");
        form.addEventListener('submit', function (e) {
            e.preventDefault();
		});

		

})(jQuery);

