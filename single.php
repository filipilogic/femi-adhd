<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package ilogic
 */

 $post_header_title = get_field('post_header_title', 'option');
 $post_header_title_color = get_field('post_header_title_color', 'option');
 $post_header_subtitle = get_field('post_header_subtitle', 'option');
 $post_header_subtitle_color = get_field('post_header_subtitle_color', 'option');
 $bg_img = get_field('post_header_background', 'option');
 $bg_img_mob = get_field('post_header_mobile_background', 'option');

 $categories = get_the_category();

get_header();

?>
	<main id="primary" class="site-main">
		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', get_post_type() );

		endwhile; // End of the loop.
		?>

	</main><!-- #main -->

<?php
get_footer();
