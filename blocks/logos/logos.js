jQuery(document).ready(function ($) {
	
	// Init Logo Carousel

	$('.il_logos_inner').flickity({
		// options
		cellAlign: 'left',
		contain: true,
		pageDots: false,
		prevNextButtons: false,
		freeScroll: true,
		wrapAround: true,
		autoPlay: 2000,
		selectedAttraction: 0.009,
		watchCSS: true
		});

});