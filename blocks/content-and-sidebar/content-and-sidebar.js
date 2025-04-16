jQuery(document).ready(function ($) {
	
    $(document).on('click', '.archive-main-content-sidebar-category-heading', function (e) {
		$('.wp-block-categories-list').toggle(300);
		$('.cas-main-container-sidebar').toggleClass('active-list');
	  });
	  
});