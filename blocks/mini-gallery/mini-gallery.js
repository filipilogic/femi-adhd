jQuery(document).ready(function ($) {

	$('.il_mini-gallery_inner').flickity({
		// options
		cellAlign: 'left',
		contain: true,
		pageDots: false,
		prevNextButtons: true,
		freeScroll: true,
		wrapAround: true,
		autoPlay: 2000,
		selectedAttraction: 0.009,
		watchCSS: true
		});

});