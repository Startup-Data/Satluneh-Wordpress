// This pagination plugin is created based on the tutorial showed on http://tutorialzine.com/2010/05/sweet-pages-a-jquery-pagination-solution/

(function($){

$.fn.peIndicatorPages = function(opts){

	if(!opts) opts = {};

	var resultsPerPage = opts.perPage || 4;

	var mainElement = $('div.pe-title-block');
	var elements = mainElement.find('div.pe-indicator');

	elements.each(function(){

		var el = $(this);
		el.data('height',el.outerHeight(true));
	});

	var pagesNumber = Math.ceil(elements.length/resultsPerPage);


	if(pagesNumber<2) return this;

	var peControls = $('<div class="peControls">');

	for(var i=0;i<pagesNumber;i++)
	{

		elements.slice(i*resultsPerPage,(i+1)*resultsPerPage).wrapAll('<div class="pePage" />');

		peControls.append('<a href="" class="peShowPage">'+(i+1)+'</a>');
	}

	mainElement.append(peControls);

	var maxHeight = 0;
	var totalWidth = 0;

	var pePage = mainElement.find('.pePage');
	pePage.each(function(){

		var elem = $(this);

		var tmpHeight = 0;
		elem.find('div.pe-indicator').each(function(){tmpHeight+=$(this).data('height');});

		if(tmpHeight>maxHeight)
			maxHeight = tmpHeight;

		totalWidth+=elem.outerWidth();

		elem.css('float','left').width(mainElement.width());
	});

	pePage.wrapAll('<div class="peSlider" />');

	mainElement.height(maxHeight);

	var peSlider = mainElement.find('div.peSlider');
	peSlider.append('<div class="clear" />').width(totalWidth);

	var hyperLinks = mainElement.find('a.peShowPage');

	hyperLinks.click(function(e){

		$(this).addClass('active').siblings().removeClass('active');

		peSlider.stop().animate({'margin-left': -(parseInt($(this).text())-1)*mainElement.width()},'slow');
		e.preventDefault();
	});

	hyperLinks.eq(0).addClass('active');

	peControls.css({

		'left':'50%',
		'margin-left':-peControls.width()/2
	});

	return this;

}})(jQuery);