jQuery(document).ready(function ($) {
	
	// Init Logo Carousel

	$('.hp-hero-three-images-container').imagesLoaded(function() {
		$('.hp-hero-three-images-container').flickity({
			// options
			cellAlign: 'right',
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
	
	// Init Logo Carousel

	$('.ty-hero-three-images-container').imagesLoaded(function() {
		$('.ty-hero-three-images-container').flickity({
			// options
			cellAlign: 'right',
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

});

