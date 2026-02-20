<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * 
 * For the blog page: Use the "Blog Page" template on a Page and edit with blocks.
 * For category archives: Uses category.php with per-category ACF customization.
 * 
 * This file serves as a fallback for any archive types not covered by more specific templates.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

get_header();
?>

<main id="primary" class="site-main">
	<div class="archive-main-container">
		<div class="archive-main-container-inner">
			<div class="container">
				<?php if ( is_home() && ! is_front_page() ) : ?>
					<header class="page-header">
						<h1 class="intro_title title-style-2 title-size-2 title-weight-700">
							<?php single_post_title(); ?>
						</h1>
					</header>
				<?php endif; ?>

				<?php if ( is_archive() ) : ?>
					<header class="page-header">
						<?php
						the_archive_title( '<h1 class="intro_title title-style-2 title-size-2 title-weight-700">', '</h1>' );
						the_archive_description( '<div class="archive-description">', '</div>' );
						?>
					</header>
				<?php endif; ?>

				<?php if ( is_search() ) : ?>
					<header class="page-header">
						<h1 class="intro_title title-style-2 title-size-2 title-weight-700">
							<?php
							/* translators: %s: search query. */
							printf( esc_html__( 'Search Results for: %s', 'fos-theme' ), '<span>' . get_search_query() . '</span>' );
							?>
						</h1>
					</header>
				<?php endif; ?>

				<div class="archive-main-content">
					<div class="archive-main-content-posts">
						<?php
						if ( have_posts() ) :
							while ( have_posts() ) :
								the_post();
								?>
								<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
									<a href="<?php the_permalink(); ?>">
										<?php the_post_thumbnail( array( 508, 250 ) ); ?>
										<div class="article-container">
											<header class="entry-header">
												<div class="entry-date"><?php echo esc_html( get_the_date() ); ?></div>
												<h3 class="entry-title"><?php the_title(); ?></h3>
											</header>
											<div class="entry-content">
												<p>
													<?php
													if ( get_the_excerpt() ) {
														echo esc_html( get_the_excerpt() );
													} else {
														echo esc_html( wp_trim_words( get_the_content(), 25 ) );
													}
													?>
												</p>
											</div>
											<span class="entry_btn">Learn more</span>
										</div>
									</a>
								</article>
								<?php
							endwhile;

							// Pagination
							echo '<div class="pagination">';
							the_posts_pagination( array(
								'prev_text' => '&larr;',
								'next_text' => '&rarr;',
								'end_size'  => 1,
								'mid_size'  => 1,
							) );
							echo '</div>';

						else :
							?>
							<p class="no-posts-message"><?php esc_html_e( 'No posts found.', 'fos-theme' ); ?></p>
							<?php
						endif;
						?>
					</div>
					<div class="archive-main-content-sidebar">
						<?php get_sidebar(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<button id="backToTopButton"><img src="/wp-content/uploads/2026/02/Group-2755-1.png"></button>
</main><!-- #main -->

<?php
get_footer();
