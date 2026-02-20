<?php
/**
 * Template Name: Blog Page
 * 
 * A fully block-editable blog page template.
 * Use ACF blocks (blog-block, section, etc.) in the editor to build the layout.
 */

get_header();
?>

<main id="primary" class="site-main blog-page-template">
	<?php
	while ( have_posts() ) :
		the_post();
		the_content();
	endwhile;
	?>
	
	<button id="backToTopButton"><img src="/wp-content/uploads/2026/02/Group-2755-1.png"></button>
</main><!-- #main -->

<?php
get_footer();
