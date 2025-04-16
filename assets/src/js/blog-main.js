jQuery(document).ready(function ($) {

        $('.blog-main-container-middle-posts').on('click', '.pagination a', function(e) {
          e.preventDefault();
          var link = $(this).attr('href');
  
          $.ajax({
              type: 'GET',
              url: link,
              success: function(response) {
                  var $html = $(response);
                  var $newContent = $html.find('.blog-main-container-middle-posts').html();
                  $('.blog-main-container-middle-posts').html($newContent);
                  
                var windowsize = $(window).width();
                if (windowsize < 1200) {
                    // Scroll to the top of the parent div of .pagination
                    var parentDivTop = $('.blog-main-container-middle-posts').offset().top - 150;
                    $('html, body').animate({
                        scrollTop: parentDivTop
                    }, 100); // You can adjust the animation speed if needed
                }
              }
          });
      });

      $('.blog-main-container-bottom-posts').on('click', '.pagination a', function(e) {
        e.preventDefault();
        var link = $(this).attr('href');

        $.ajax({
            type: 'GET',
            url: link,
            success: function(response) {
                var $html = $(response);
                var $newContent = $html.find('.blog-main-container-bottom-posts').html();
                $('.blog-main-container-bottom-posts').html($newContent);

                var windowsize = $(window).width();
                if (windowsize < 1200) {
                    // Scroll to the top of the parent div of .pagination
                    var parentDivTop = $('.blog-main-container-bottom-posts').offset().top - 150;
                    $('html, body').animate({
                        scrollTop: parentDivTop
                    }, 100); // You can adjust the animation speed if needed
                }
            }
        });
    });
      
});
