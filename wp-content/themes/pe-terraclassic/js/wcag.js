/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
 ---------------------------------------------------------------*/

jQuery(document).ready(function () {
	var NormalButton = jQuery('.pe-normal');
	var NightVersionButton = jQuery('.pe-night');
	var HighContrastButton = jQuery('.pe-highcontrast');
	var HighContrastButton2 = jQuery('.pe-highcontrast2');
	var HighContrastButton3 = jQuery('.pe-highcontrast3');
	var FixedButton = jQuery('.pe-fixed');
	var WideButton = jQuery('.pe-wide');

	var font_normal = jQuery('.pe-font-normal');
	var font_larger = jQuery('.pe-font-larger');
	var font_smaller = jQuery('.pe-font-smaller');

	var body = jQuery('body');

	// Contrast
	//-------------------------------------------------------

	var cookieContrast = Cookies.get('contrast');
	if (cookieContrast == 'night' || cookieContrast == 'highcontrast' || cookieContrast == 'highcontrast2' || cookieContrast == 'highcontrast3') {
		if (!body.hasClass(cookieContrast)) {
			body.addClass(cookieContrast);
		}
	} else {
		body.removeClass('night highcontrast highcontrast2 highcontrast3');
	}

	NormalButton.click(function (event) {
		event.preventDefault();
		Cookies.remove('contrast', {path: pe_wcag_vars.cookiePath});
		body.removeClass('night highcontrast highcontrast2 highcontrast3');
	});

	NightVersionButton.click(function (event) {
		event.preventDefault();
		Cookies.set('contrast', 'night', {expires: 7, path: pe_wcag_vars.cookiePath});
		body.removeClass('highcontrast highcontrast2 highcontrast3');
		body.addClass('night');
	});

	HighContrastButton.click(function (event) {
		event.preventDefault();
		Cookies.set('contrast', 'highcontrast', {expires: 7, path: pe_wcag_vars.cookiePath});
		body.removeClass('night highcontrast2 highcontrast3');
		body.addClass('highcontrast');
	});

	HighContrastButton2.click(function (event) {
		event.preventDefault();
		Cookies.set('contrast', 'highcontrast2', {expires: 7, path: pe_wcag_vars.cookiePath});
		body.removeClass('night highcontrast highcontrast3');
		body.addClass('highcontrast2');
	});

	HighContrastButton3.click(function (event) {
		event.preventDefault();
		Cookies.set('contrast', 'highcontrast3', {expires: 7, path: pe_wcag_vars.cookiePath});
		body.removeClass('night highcontrast highcontrast2');
		body.addClass('highcontrast3');
	});

	// Wide page
	//-------------------------------------------------------

	var cookieWide = Cookies.get('pagewidth');
	if (cookieWide == 'wide') {
		if (!body.hasClass('wide-page')) {
			body.addClass('wide-page');
		}
	} else {
		body.removeClass('wide-page');
	}

	FixedButton.click(function (event) {
		event.preventDefault();
		Cookies.remove('pagewidth', {path: pe_wcag_vars.cookiePath});
		body.removeClass('wide-page');
	});

	WideButton.click(function (event) {
		event.preventDefault();
		Cookies.set('pagewidth', 'wide', {expires: 7, path: pe_wcag_vars.cookiePath});
		if (!body.hasClass('wide-page')) {
			body.addClass('wide-page');
		}
	});

	// Font Sizer
	//-------------------------------------------------------

	var fsCount = 100;
	var cookieFont = Cookies.get('pe-font-size');

	if (cookieFont) {
		fsCount = parseInt(cookieFont);
		if (!body.hasClass('fsize' + fsCount)) {
			body.addClass('fsize' + fsCount);
		}
	} else {
		body.removeClass('fsize70 fsize80 fsize90 fsize100 fsize110 fsize120 fsize130');
	}

	font_larger.click(function (event) {
		event.preventDefault();
		if (fsCount < 130) {
			body.removeClass('fsize' + fsCount);
			fsCount = fsCount + 10;
			body.addClass('fsize' + fsCount);
			Cookies.set('pe-font-size', fsCount, {expires: 7, path: pe_wcag_vars.cookiePath});
		}
	});

	font_smaller.click(function (event) {
		event.preventDefault();
		if (fsCount > 70) {
			body.removeClass('fsize' + fsCount);
			fsCount = fsCount - 10;
			body.addClass('fsize' + fsCount);
			Cookies.set('pe-font-size', fsCount, {expires: 7, path: pe_wcag_vars.cookiePath});
		}
	});

	font_normal.click(function (event) {
		event.preventDefault();
		body.removeClass('fsize70 fsize80 fsize90 fsize100 fsize110 fsize120 fsize130');
		fsCount = 100;
		Cookies.remove('pe-font-size', {path: pe_wcag_vars.cookiePath});
	});

});
