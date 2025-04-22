jQuery(document).ready(function ($) {

    // Mobile navigation

    $(".menu-toggle").click(function () {
        $("#primary-menu").toggleClass('mobile-menu-visible'); // Toggles mobile-menu-visible class and fades the menu in/out
        $(this).toggleClass('menu-open');
    });

    $("#primary-menu li").click(function() {
      // Get the first <a> element within the clicked li
      var ulElement = $(this).find("ul");
  
      // Check if the href attribute doesn't only contain "#"
      if (! ulElement.hasClass('sub-menu')) {
          var windowsize = $(window).width();
          if (windowsize < 1200) {
              $("#primary-menu").fadeToggle();
              $(".menu-toggle").toggleClass('menu-open');
          }
      }
    });
    
    // Sub Menu Trigger

    $( "#primary-menu li.menu-item-has-children > a" ).after('<span class="sub-menu-trigger"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></span>');
    
    $( ".menu-item-has-children" ).click(function() {
      var windowsize = $(window).width();
      if (windowsize < 1200) {
          $( this ).toggleClass('sub-menu-open')
          $( this ).find(".sub-menu").slideToggle();
      }
	  });

    // AJAX Load More bttn
    $(document).on('click', '.ilLoadMore', function (e) {
        e.preventDefault() //prevent default action
        
        const category = $(this).data('category')
        let postCategory = 'all'

        if (category) {
          postCategory = category
        }

        if (!window.countPosts) {
          window.countPosts = 4
        }

        $.ajax({
          type: 'GET',
          url: '/wp-admin/admin-ajax.php',
          data: {
            countPosts: window.countPosts,
            postCategory,
            action: 'blog_load_more',
          },
        }).done(function (resp) {
          window.countPosts += 4
         
          $('.il_archive_more').html(resp)
        })
      })
      
});

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {
	scrollFunction();
	
	document.getElementById("backToTopButton").addEventListener("click", function() {
		document.body.scrollTop = 0;
		document.documentElement.scrollTop = 0;
	});
};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    document.getElementById("backToTopButton").style.opacity = "1";
  } else {
    document.getElementById("backToTopButton").style.opacity = "0";
  }

  if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
    document.getElementById("masthead").className = "header-main sticky";
  } else {
    document.getElementById("masthead").className = "header-main";
  }
}