(function ($) {
	"use strict";
  
	// Initialize carousels
	function initCarousels() {
	  $('.owl-men-item').owlCarousel({
		items: 5,
		loop: true,
		dots: true,
		nav: true,
		margin: 30,
		responsive: {
		  0: {
			items: 1
		  },
		  600: {
			items: 2
		  },
		  1000: {
			items: 3
		  }
		}
	  });
  
	  $('.owl-women-item').owlCarousel({
		items: 5,
		loop: true,
		dots: true,
		nav: true,
		margin: 30,
		responsive: {
		  0: {
			items: 1
		  },
		  600: {
			items: 2
		  },
		  1000: {
			items: 3
		  }
		}
	  });
  
	  $('.owl-kid-item').owlCarousel({
		items: 5,
		loop: true,
		dots: true,
		nav: true,
		margin: 30,
		responsive: {
		  0: {
			items: 1
		  },
		  600: {
			items: 2
		  },
		  1000: {
			items: 3
		  }
		}
	  });
	}
  
	// Handle scroll events
	function handleScroll() {
	  var scroll = $(window).scrollTop();
	  var box = $('#top').height();
	  var header = $('header').height();
  
	  if (scroll >= box - header) {
		$("header").addClass("background-header");
	  } else {
		$("header").removeClass("background-header");
	  }
	}
  
	// Menu behavior
	function handleMenu() {
	  if ($('.menu-trigger').length) {
		$(".menu-trigger").on('click', function () {
		  $(this).toggleClass('active');
		  $('.header-area .nav').slideToggle(200);
		});
	  }
	}
  
	// Smooth scrolling
	function smoothScroll() {
	  // Handle smooth scrolling logic
	  $('.scroll-to-section a[href^="#"]:not([href="#"])').on('click', function () {
		if (
		  location.pathname.replace(/^\//, '') ==
			this.pathname.replace(/^\//, '') &&
		  location.hostname == this.hostname
		) {
		  var target = $(this.hash);
		  target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
		  if (target.length) {
			var width = $(window).width();
			if (width < 991) {
			  $('.menu-trigger').removeClass('active');
			  $('.header-area .nav').slideUp(200);
			}
			$('html,body').animate(
			  {
				scrollTop: target.offset().top - 80
			  },
			  700
			);
			return false;
		  }
		}
	  });
	}
  
	// Page loading animation
	function pageLoadingAnimation() {
	  if ($('.cover').length) {
		$('.cover').parallax({
		  imageSrc: $('.cover').data('image'),
		  zIndex: '1'
		});
	  }
  
	  $("#preloader").animate(
		{
		  opacity: '0'
		},
		600,
		function () {
		  setTimeout(function () {
			$("#preloader").css("visibility", "hidden").fadeOut();
		  }, 300);
		}
	  );
	}
  
	// Handle window resize
	function handleResize() {
	  var width = $(window).width();
	  $('.submenu').on('click', function () {
		if (width < 767) {
		  $('.submenu ul').removeClass('active');
		  $(this).find('ul').toggleClass('active');
		}
	  });
	}
  
	// Initialize everything when the document is ready
	$(document).ready(function () {
	  initCarousels();
	  handleScroll();
	  handleMenu();
	  smoothScroll();
	  pageLoadingAnimation();
	  handleResize();
	});
  })(window.jQuery);
  