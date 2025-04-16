jQuery(document).ready(function ($) {

    // Select divs with class "right"
    $('.il_video-popup-section .right').each(function() {
      var $container = $(this);
      var $items = $container.find('.column');

      // Check if the div has more than one element
      if ($items.length > 1) {
        // Initialize Flickity on the selected div
        $container.flickity({
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
      }
    });

});