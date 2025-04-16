jQuery(document).ready(function ($) {
	
	// Init Logo Carousel

	$('.il_columns_inner').flickity({
		// options
		cellAlign: 'left',
		contain: true,
		pageDots: true,
		prevNextButtons: false,
		freeScroll: true,
		wrapAround: true,
		autoPlay: 2000,
		selectedAttraction: 0.009,
		watchCSS: true
		});

});

function animateCounter(element, targetValue, duration) {
	const startValue = parseInt(element.textContent);
	const startTime = new Date().getTime();
	
	function updateCounter() {
	  const currentTime = new Date().getTime();
	  const elapsedTime = currentTime - startTime;
	  const progress = Math.min(elapsedTime / duration, 1);
	  const currentValue = Math.floor(startValue + (targetValue - startValue) * progress);
	  element.textContent = currentValue.toLocaleString();
	  
	  if (progress < 1) {
		requestAnimationFrame(updateCounter);
	  }
	}
	
	updateCounter();
  }
  
  document.querySelectorAll('.counter').forEach(counter => {
	const targetValue = parseInt(counter.getAttribute('data-value'));
	animateCounter(counter, targetValue, 2500); // Animate to targetValue in 2000ms (2 seconds)
  });

  document.addEventListener('wpcf7mailsent', function(event) {
    // Change the content of .cf7-apply-section .intro_text
    var introText = document.querySelector('.cf7-apply-section .il_block_intro');
    if (introText) {
        introText.innerHTML = '<img src="/wp-content/uploads/2023/08/OBJECTS-1.png"><h3>Thank you</h3>';
    }
	
}, false);