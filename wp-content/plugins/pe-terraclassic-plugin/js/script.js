/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
 ---------------------------------------------------------------*/

(function ($) {

	"use strict";

	/* -------------------------------------------------------- */
	/* FUNCTIONS                                                */
	/* -------------------------------------------------------- */

	// Animated Headlines
	//-------------------------------------------------------

	//set animation timing
	var animationDelay = 2500,
		//loading bar effect
		barAnimationDelay = 3800,
		barWaiting = barAnimationDelay - 3000, //3000 is the duration of the transition on the loading bar - set in the scss/css file
		//letters effect
		lettersDelay = 50,
		//type effect
		typeLettersDelay = 150,
		selectionDuration = 500,
		typeAnimationDelay = selectionDuration + 800,
		//clip effect
		revealDuration = 600,
		revealAnimationDelay = 1500;

	function initHeadline() {
		//insert <i> element for each letter of a changing word
		singleLetters($('.cd-headline.letters').find('strong'));
		//initialise headline animation
		animateHeadline($('.cd-headline'));
	}

	function singleLetters($words) {
		$words.each(function () {
			var word = $(this),
				letters = word.text().split(''),
				selected = word.hasClass('is-visible');
			for (i in letters) {
				if (word.parents('.rotate-2').length > 0) letters[i] = '<em>' + letters[i] + '</em>';
				letters[i] = (selected) ? '<i class="in">' + letters[i] + '</i>' : '<i>' + letters[i] + '</i>';
			}
			var newLetters = letters.join('');
			word.html(newLetters).css('opacity', 1);
		});
	}

	function animateHeadline($headlines) {
		var duration = animationDelay;
		$headlines.each(function () {
			var headline = $(this);

			if (headline.hasClass('loading-bar')) {
				duration = barAnimationDelay;
				setTimeout(function () {
					headline.find('.cd-words-wrapper').addClass('is-loading')
				}, barWaiting);
			} else if (headline.hasClass('clip')) {
				var spanWrapper = headline.find('.cd-words-wrapper'),
					newWidth = spanWrapper.width() + 10
				spanWrapper.css('width', newWidth);
			} else if (!headline.hasClass('type')) {
				//assign to .cd-words-wrapper the width of its longest word
				var words = headline.find('.cd-words-wrapper strong'),
					width = 0;
				words.each(function () {
					var wordWidth = $(this).width();
					if (wordWidth > width) width = wordWidth;
				});
				headline.find('.cd-words-wrapper').css('width', width);
			}
			;

			//trigger animation
			setTimeout(function () {
				hideWord(headline.find('.is-visible').eq(0))
			}, duration);
		});
	}

	function hideWord($word) {
		var nextWord = takeNext($word);

		if ($word.parents('.cd-headline').hasClass('type')) {
			var parentSpan = $word.parent('.cd-words-wrapper');
			parentSpan.addClass('selected').removeClass('waiting');
			setTimeout(function () {
				parentSpan.removeClass('selected');
				$word.removeClass('is-visible').addClass('is-hidden').children('i').removeClass('in').addClass('out');
			}, selectionDuration);
			setTimeout(function () {
				showWord(nextWord, typeLettersDelay)
			}, typeAnimationDelay);

		} else if ($word.parents('.cd-headline').hasClass('letters')) {
			var bool = ($word.children('i').length >= nextWord.children('i').length) ? true : false;
			hideLetter($word.find('i').eq(0), $word, bool, lettersDelay);
			showLetter(nextWord.find('i').eq(0), nextWord, bool, lettersDelay);

		} else if ($word.parents('.cd-headline').hasClass('clip')) {
			$word.parents('.cd-words-wrapper').animate({width: '2px'}, revealDuration, function () {
				switchWord($word, nextWord);
				showWord(nextWord);
			});

		} else if ($word.parents('.cd-headline').hasClass('loading-bar')) {
			$word.parents('.cd-words-wrapper').removeClass('is-loading');
			switchWord($word, nextWord);
			setTimeout(function () {
				hideWord(nextWord)
			}, barAnimationDelay);
			setTimeout(function () {
				$word.parents('.cd-words-wrapper').addClass('is-loading')
			}, barWaiting);

		} else {
			switchWord($word, nextWord);
			setTimeout(function () {
				hideWord(nextWord)
			}, animationDelay);
		}
	}

	function showWord($word, $duration) {
		if ($word.parents('.cd-headline').hasClass('type')) {
			showLetter($word.find('i').eq(0), $word, false, $duration);
			$word.addClass('is-visible').removeClass('is-hidden');

		} else if ($word.parents('.cd-headline').hasClass('clip')) {
			$word.parents('.cd-words-wrapper').animate({'width': $word.width() + 10}, revealDuration, function () {
				setTimeout(function () {
					hideWord($word)
				}, revealAnimationDelay);
			});
		}
	}

	function hideLetter($letter, $word, $bool, $duration) {
		$letter.removeClass('in').addClass('out');

		if (!$letter.is(':last-child')) {
			setTimeout(function () {
				hideLetter($letter.next(), $word, $bool, $duration);
			}, $duration);
		} else if ($bool) {
			setTimeout(function () {
				hideWord(takeNext($word))
			}, animationDelay);
		}

		if ($letter.is(':last-child') && $('html').hasClass('no-csstransitions')) {
			var nextWord = takeNext($word);
			switchWord($word, nextWord);
		}
	}

	function showLetter($letter, $word, $bool, $duration) {
		$letter.addClass('in').removeClass('out');

		if (!$letter.is(':last-child')) {
			setTimeout(function () {
				showLetter($letter.next(), $word, $bool, $duration);
			}, $duration);
		} else {
			if ($word.parents('.cd-headline').hasClass('type')) {
				setTimeout(function () {
					$word.parents('.cd-words-wrapper').addClass('waiting');
				}, 200);
			}
			if (!$bool) {
				setTimeout(function () {
					hideWord($word)
				}, animationDelay)
			}
		}
	}

	function takeNext($word) {
		return (!$word.is(':last-child')) ? $word.next() : $word.parent().children().eq(0);
	}

	function takePrev($word) {
		return (!$word.is(':first-child')) ? $word.prev() : $word.parent().children().last();
	}

	function switchWord($oldWord, $newWord) {
		$oldWord.removeClass('is-visible').addClass('is-hidden');
		$newWord.removeClass('is-hidden').addClass('is-visible');
	}
	
	// refresh Google Map
	//-------------------------------------------------------
	function refreshGoogleMap( element ) {
		var map = $(element).find('.pe_map_canvas');
		if( map.length ) {
				var maps = window.pemaps;
				map.each(function() {
						var self = maps[ $(this).attr('id') ];
						if( typeof self != 'undefined' ) {
								google.maps.event.trigger( self.map,'resize' );
								self.map.setCenter( self.marker.getPosition() );
								if( typeof self.infoWindow != 'undefined' ) {
										self.infoWindow.setContent( self.tooltip );
								}
						}
				});
		}
	}

	// Widget height suffix
	//-------------------------------------------------------

	function PEsetWidgetHeight() {
		var regexp = new RegExp("height([0-9]+)");
		var widgets = $(document).find('.pe-widget') || [];
		if (widgets.length) {
			widgets.each(function (index, element) {
				var match = regexp.exec(element.className) || [];
				if (match.length > 1) {
					var widgetHeight = parseInt(match[1]);
					$(element).css('min-height', widgetHeight + 'px');
				}
			});
		}
	}

	// Counter shortcode
	//-------------------------------------------------------

	var peScrollTimer;

	function countnow() {
		var widget = $('.pe-counter');
		if (!widget.length) return;

		widget.each(function () {

			var counted = ( $(this).hasClass('counted') ) ? true : false;

			if (!counted) {
				var scrollWindow = $(window).scrollTop();
				var screenHeight = $(window).height();

				var number = $(this).find('.pe-number');

				var objectPosition = $(this).offset();

				if (objectPosition.top < (scrollWindow + screenHeight)) {
					number.countTo();
					$(this).addClass('counted');
				}
			}
		});
	};

	/* -------------------------------------------------------- */
	/* READY state                                              */
	/* -------------------------------------------------------- */

	$(document).ready(function () {

		initHeadline();

		PEsetWidgetHeight();


		// Tabs
		//-------------------------------------------------------

		$('.pe-tabs .pe-tab-links a').on('click', function (e) {
			e.preventDefault();
			var currentAttrValue = $(this).attr('href');
			var tabContent = $('.pe-tabs .pe-tabs-content').find(currentAttrValue);

			$(this).parent('li').addClass('active').siblings().removeClass('active');

			// Show / hide tab content
			tabContent.slideDown(400).siblings().slideUp(400);

			// Change active state
			setTimeout(function () {
				tabContent.addClass('active').siblings().removeClass('active');
				// refresh google maps
				refreshGoogleMap(tabContent);
			}, 400);

		});

		// Accordion
		//-------------------------------------------------------

		$('.pe-accordion-container').each(function () {
			//check multiselect
			if ($(this).attr('aria-multiselectable')) {
				var multiSelect = true;
			} else {
				var multiSelect = false;
			}

			var allTitles = $(this).find('.pe-accordion-heading');
			var allContents = $(this).find('.pe-accordion-content');

			//hide content
			allContents.each(function () {
				if (!$(this).hasClass('active')) {
					$(this).hide();
				}
			});

			//on click
			allTitles.find('a').click(function (e) {
				e.preventDefault();

				var thisTitle = $(this).parent();
				var thisContent = $(this).parent().next();

				if (!thisContent.hasClass('active')) {
					//if item NOT active
					if (!multiSelect) {
						//hide all panels
						allContents.slideUp(400).removeClass('active');
						allContents.attr('aria-expanded', 'false');
						allTitles.removeClass('active');
					}
					//show current panel
					thisContent.slideDown(400).addClass('active');
					thisContent.attr('aria-expanded', 'true');
					thisTitle.addClass('active');
				} else {
					//if item ACTIVE
					if (!multiSelect) {
						//hide all panels
						allContents.slideUp(400).removeClass('active');
						allContents.attr('aria-expanded', 'false');
						allTitles.removeClass('active');
					} else {
						//hide current panel
						thisContent.slideUp(400).removeClass('active');
						thisContent.attr('aria-expanded', 'false');
						thisTitle.removeClass('active');
					}

				}
				
				setTimeout(function () {
					// refresh google maps
					refreshGoogleMap(thisContent);
				}, 400);
			});

		});

		countnow();

		$(window).scroll(function () {

			if (peScrollTimer) {
				clearTimeout(peScrollTimer);
			}
			peScrollTimer = setTimeout(function () {

				countnow();

			}, 200);

		});

		/* -------------------------------------------------------- */
		/* end READY state                                          */
		/* -------------------------------------------------------- */

	});

})(jQuery);
