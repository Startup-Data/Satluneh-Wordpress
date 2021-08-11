/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
 ---------------------------------------------------------------*/

(function ($) {

	"use strict";

	$('.open-popup').magnificPopup({
		type: 'inline',
		removalDelay: 500,
		callbacks: {
			beforeOpen: function () {
				this.st.mainClass = 'mfp-zoom-in';
			}
		},
		midClick: true
	});

	/* -------------------------------------------------------- */
	/* FUNCTIONS                                                */
	/* -------------------------------------------------------- */
	
	// jQuery Off-Canvas
	//-------------------------------------------------------

	var peThemeScroll;
	var PEoffcanvaslastScroll;

	function scrolledBar() {
		var body = $('body');
		var scroll = $(window).scrollTop();
		if (scroll >= 5) {
			body.addClass('scrolled');
		} else {
			body.removeClass('scrolled');
		}
	}

	function PEoffcanvasToggleNav() {
		var body = $('body');
		if (body.hasClass('off-canvas-opened')) {
			// Do things on Nav Close
			body.removeClass('off-canvas-opened');
			$('#pe-offcanvas').find('a').attr('tabindex', -1);
			setTimeout(function () {
				body.removeClass('overflow');
				body.scrollTop(PEoffcanvaslastScroll);
			}, 300);
		} else { // Do things on Nav Open
			PEoffcanvaslastScroll = $(window).scrollTop();
			body.addClass('off-canvas-opened');
			body.addClass('overflow');
			$('#pe-offcanvas').find('a').attr('tabindex', 0);
		}
	}

	// Sticky Bar
	//-------------------------------------------------------

	var peResizeTimer;

	function stickyResize() {
		var body = $('body');
		var container = $('#pe-header');

		if (body.hasClass('sticky-bar')) {
			var bar = $('#pe-logo-nav');
			if (bar.length) {
				var offset = bar.outerHeight();
				container.css('padding-top', (offset) + 'px');
			}
		}
	};

	// PE Main Menu
	//-------------------------------------------------------

	function PEtopMenu() {
		var navContainer = $('.pe-main-menu');
		var navMainDropdown = navContainer.find('ul > .menu-item-has-children');

		// Nav dropdown toggle
		navMainDropdown.on('click', function () {
			$(this).toggleClass('is-active').children('.nav-dropdown').toggleClass('is-visible');
		});

		// Prevent click events from firing on children of navDropdown
		navMainDropdown.on('click', '*', function (e) {
			if( $(this).attr('href')=='#' ) {
				e.preventDefault();
			}
			e.stopPropagation();
		});

	}

	// Change submenu position if it doesn't fit the screen (desktop view)
	function PEtopMenuDropdownTopBarRight() {
		var navContainer = $('#pe-bar-right .pe-main-menu');
		var navChildren = navContainer.find('.menu-item-has-children');
		var navDropdown = navChildren.find('.nav-dropdown');
		var screenWidth = $(window).width();

		navDropdown.each(function (e) {
			var dropDownPosition = $(this).offset();
			var dropDownWidth = $(this).width();

			if ($("body").hasClass("rtl")) {
				if (dropDownPosition.left < 0) {
					$(this).addClass('change-direction');
				} else {
					setTimeout(function () {
						$(this).removeClass('change-direction');
					}, 100);
				}
			} else {
				if ((dropDownPosition.left + dropDownWidth) > screenWidth) {
					$(this).addClass('change-direction');
				} else {
					setTimeout(function () {
						$(this).removeClass('change-direction');
					}, 100);
				}
			}
		});

	}
	
	function PEtopMenuDropdownHeader() {
		var navContainer = $('#pe-header-sidebar .pe-main-menu');
		var navChildren = navContainer.find('.menu-item-has-children');
		var navDropdown = navChildren.find('.nav-dropdown');
		var screenWidth = $(window).width();

		navDropdown.each(function (e) {
			var dropDownPosition = $(this).offset();
			var dropDownWidth = $(this).width();

			if ($("body").hasClass("rtl")) {
				if (dropDownPosition.left < 0) {
					$(this).addClass('change-direction');
				} else {
					setTimeout(function () {
						$(this).removeClass('change-direction');
					}, 100);
				}
			} else {
				if ((dropDownPosition.left + dropDownWidth) > screenWidth) {
					$(this).addClass('change-direction');
				} else {
					setTimeout(function () {
						$(this).removeClass('change-direction');
					}, 100);
				}
			}

		});

	}

	// Offcanvas menu
	function PEoffcanvasMenu() {
		var navContainer = $('.pe-offcanvas-menu');

		if (navContainer.length) {
			var navAllDropdowns = navContainer.find('.nav-dropdown');
			var navDropdown = navContainer.find('.menu-item-has-children');
			var navActiveDropdown = navContainer.find('.menu-item-has-children.current-menu-ancestor > .nav-dropdown');

			if (navActiveDropdown.length) {
				navActiveDropdown.slideDown(400);
				navActiveDropdown.prev().addClass('clicked');
			}

			//click
			var parentLink = navContainer.find('.menu-item-has-children > a');
			parentLink.click(function (e) {

				if ($(this).hasClass('clicked')) {
					if ($(this).attr('href') == '#') {
						$(this).next().slideUp(400);
						$(this).removeClass('clicked');
						return false;
					} else {
						return;
					}
				} else {
					$(this).next().slideDown(400);
					$(this).addClass('clicked');
					return false;
				}

			});
		}

	}

	// Search Form
	//-------------------------------------------------------

	function searchForm() {
		var searchModule = $('#pe-header #pe-search');

		var searchModuleInput = searchModule.find('.pe-search-input');
		var searchModuleInputField = searchModuleInput.find('.s');
		var searchModuleButton = searchModule.find('.button');

		var firstClick = true;

		function openSearch() {
			searchModuleInput.addClass('open');
			searchModuleInput.animate({width:'toggle'},400);
			searchModuleInputField.focus();
			firstClick = false;
		}

		function closeSearch() {
			searchModuleInput.removeClass('open');
			searchModuleInput.animate({width:'toggle'},400);
			firstClick = true;
		}

		if( searchModule.length ) {

			searchModuleInput.hide();

			searchModuleButton.click(function (e) {

				if( firstClick ) {
					openSearch();
					return false;
				} else {
					if( searchModuleInputField.val() ) {
						return;
					} else {
						closeSearch();
						return false;
					}
				}

			});

		}
	}
	
	// Slick Carousel
	//-------------------------------------------------------

	function slickCarousel() {
		$('.pe-carousel').each(function () {
			var slider = $(this).find('.pe-slick-content');
			var indicator = $(this).find('.pe-indicator');
			var anchor = slider.find('a');

			slider.slick({
				arrows: false,
				adaptiveHeight: true,
				pauseOnHover: true,
				accessibility: false
			});

			indicator.each(function () {
				$(this).on('keydown', function (event) {
					if (event.which == 13) { // enter key
						$(this).click();
					}
				});
			});

			indicator.click(function (e) {
				e.preventDefault();
				var slideIndex = $(this).attr('data-slick-goto');
				slider.slick('slickGoTo', slideIndex);
			});

			slider.on('afterChange', function (slick, currentSlide) {
				indicator.each(function () {
					var $this = $(this);
					if ($this.attr('data-slick-goto') == currentSlide.currentSlide) {
						$this.addClass('active');
					} else {
						$this.removeClass('active');
					}
				});
			});
		});
	}

	// WCAG Rev Slider
	//-------------------------------------------------------

	function wcagRevSlider() {

		var navi = $('.rev_slider_wrapper .tp-bullets .tp-bullet, .rev_slider_wrapper .tp-leftarrow, .rev_slider_wrapper .tp-rightarrow');

		if (navi.length) {
			navi.prop('tabindex', '0');
			navi.keypress(function (event) {
				if (event.which == 13) {
					$(this).trigger('click');
				}
			});
		}
	}

	/* -------------------------------------------------------- */
	/* READY state                                              */
	/* -------------------------------------------------------- */

	$(document).ready(function () {

		// Hide Main Menu in Top Bar Right if  Main Menu in Header is ON
		if($('#pe-header-sidebar #pe-main-menu-header .pe-main-menu').length > 0){
			$('#pe-header-sidebar #pe-main-menu-header .pe-main-menu .nav-menu').each(function(){
				// Is this element visible onscreen?
				var visible = $(this).visible();
				if(visible){
					$('#pe-bar-right').css("opacity","0").css("pointer-events","none");
				} else {
					$('#pe-bar-right').css("opacity","1").css("pointer-events","auto");
				}
			})
		}
		
		scrolledBar();

		// PE Section space
		//-------------------------------------------------------

		$('.pe-section-space').closest('.pe-container').parent().addClass('nospace');
		$('.pe-section-space-top').closest('.pe-container').parent().addClass('nospace-top');
		$('.pe-section-space-bottom').closest('.pe-container').parent().addClass('nospace-bottom');

		// First and Last class for widgets
		//-------------------------------------------------------

		var PEboxWidget = $('.row .pe-widget');
		PEboxWidget.first().addClass('first');
		PEboxWidget.last().addClass('last');

		// Contact Form Handling - send-email.php
		//-------------------------------------------------------

		if ($().validate && $().ajaxSubmit) {

			var pe_forms_contact = $('.pe-contact-form');

			pe_forms_contact.each(function () {

				var submitButton = $(this).find('.submit-button');
				var messageContainer = $(this).find('.pe-success');
				var errorContainer = $(this).find('.pe-alert');

				var formOptions = {
					beforeSubmit: function () {
						submitButton.attr('disabled', 'disabled');
						messageContainer.fadeOut('fast');
						errorContainer.fadeOut('fast');
					},
					success: function (ajax_response, statusText, xhr, $form) {
						var response = JSON.parse(ajax_response);
						submitButton.removeAttr('disabled');
						if (response.success) {
							$form.resetForm();
							messageContainer.html(response.message).fadeIn('fast');
						} else {
							errorContainer.html(response.message).fadeIn('fast');
						}
					}
				};

				$(this).validate({
					errorLabelContainer: errorContainer,
					submitHandler: function (form) {
						$(form).ajaxSubmit(formOptions);
					}
				});
			});

		}

		//jQuery 'Back to Top' script
		//-------------------------------------------------------

		// hide #pe-back-top first

		var PEbackTop = $('#pe-back-top');

		PEbackTop.hide();
		// fade in #pe-back-top
		$(window).scroll(function () {
			if ($(this).scrollTop() > 100) {
				PEbackTop.fadeIn();
			} else {
				PEbackTop.fadeOut();
			}
		});
		// scroll body to 0px on click
		PEbackTop.find('a').click(function () {
			$('body,html').animate({
				scrollTop: 0
			}, 800);
			return false;
		});

		// Modal
		//-------------------------------------------------------

		if (!!$.prototype.magnificPopup) {
			$('.pe-gallery').each(function() {
				$(this).find('.pe-gallery-modal').magnificPopup({
					type:'inline',
					midClick: true, // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
					gallery: {
						enabled: true
					}
				});
			});

			$('.pe-modal').magnificPopup({
				type:'inline',
				midClick: true, // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
			});

			$('.pe-modal, .pe-gallery-modal').keypress(function (e) {
				if (e.which == 13) {
					$(this).trigger('click');
				}
			});
		}
		
		// Off-Canvas sidebar
		//-------------------------------------------------------

		$(document).on('click', function (e) {
			if ($('body').hasClass('off-canvas-opened')) {
				PEoffcanvasToggleNav();
			}
		});

		$('#pe-offcanvas').find('a').attr('tabindex', -1);

		// Toggle Nav on Click
		$('.toggle-nav').click(function (e) {
			e.stopPropagation();
			e.preventDefault();
			$('.toggle-nav').toggleClass('active');
			// Calling a function
			PEoffcanvasToggleNav();
		});

		$('#pe-offcanvas').click(function (e) {
			e.stopPropagation();
		});


		slickCarousel();
		
		searchForm();

		PEoffcanvasMenu();

		$(window).scroll(function () {

			scrolledBar();

			// Check visibility of Main Menu in the Header
			//-------------------------------------------------------
			// Loop over each container, and check if it's visible.
			if($('#pe-header-sidebar #pe-main-menu-header .pe-main-menu').length > 0){
				$('#pe-header-sidebar #pe-main-menu-header .pe-main-menu .nav-menu').each(function(){
					// Is this element visible onscreen?
					var visible = $(this).visible();
					if(visible){
						$('#pe-bar-right').css("opacity","0").css("pointer-events","none");
					} else {
						$('#pe-bar-right').css("opacity","1").css("pointer-events","auto");
					}
				})
			}
		});

		/* -------------------------------------------------------- */
		/* end READY state                                          */
		/* -------------------------------------------------------- */

	});

	/* -------------------------------------------------------- */
	/* LOAD state                                               */
	/* -------------------------------------------------------- */

	$(window).on("load", function () {

		PEtopMenu();

		PEtopMenuDropdownTopBarRight();
		
		PEtopMenuDropdownHeader();

		stickyResize();

		$(window).resize(function () {

			if (peResizeTimer) {
				clearTimeout(peResizeTimer);
			}
			peResizeTimer = setTimeout(function () {

				stickyResize();

			}, 100);

		});

		// WCAG Rev Slider
		//-------------------------------------------------------

		setTimeout(function () {
			wcagRevSlider();
		}, 500);

		/* -------------------------------------------------------- */
		/* end LOAD state                                           */
		/* -------------------------------------------------------- */

	});
	    
})(jQuery);
