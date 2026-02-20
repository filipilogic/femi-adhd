<?php
/**
 * Category Archive Template
 * 
 * Displays posts from a specific category with per-category ACF customization.
 * Falls back to Theme Options defaults when category-specific fields are empty.
 */

get_header();

$category = get_queried_object();
$category_id = $category->term_id;

// Get category-specific ACF fields (with fallbacks to Theme Options)
$category_before_title = get_field( 'category_before_title', 'category_' . $category_id );
if ( empty( $category_before_title ) ) {
	$category_before_title = get_field( 'archive_before_title', 'option' );
}

$category_title = $category->name;

// Optional header content from category
$category_header_content = get_field( 'category_header_content', 'category_' . $category_id );
$category_header_image = get_field( 'category_header_image', 'category_' . $category_id );

// Optional bottom content from category
$category_bottom_content = get_field( 'category_bottom_content', 'category_' . $category_id );

// CTA button - category override or fallback to option
$category_cta_button = get_field( 'category_cta_button', 'category_' . $category_id );
if ( empty( $category_cta_button ) ) {
	$category_cta_button = get_field( 'archive_cta_button_link', 'option' );
}
$cta_button_url = ! empty( $category_cta_button['url'] ) ? $category_cta_button['url'] : '';
$cta_button_title = ! empty( $category_cta_button['title'] ) ? $category_cta_button['title'] : '';

// Category color (from existing field group)
$category_color = get_field( 'category_color', 'category_' . $category_id );
if ( empty( $category_color ) ) {
	$category_color = '#1F9DD0';
}
?>

<main id="primary" class="site-main category-archive">
	<div class="archive-main-container">
		<div class="archive-main-container-inner">
			<div class="container">
				<!-- Header Section -->
				<div class="il_block_intro align-left">
					<?php if ( ! empty( $category_before_title ) ) : ?>
						<div class="intro_before_title before-title-style-3 before-title-size-1 before-title-weight-500" style="--before-title-size-1-ld: 20px;--before-title-size-1-mt: 16px;--before_title_margin_bottom_ld: 1.8rem;--before_title_margin_bottom_mt: 12px;"><?php echo esc_html( $category_before_title ); ?></div>
					<?php endif; ?>
					<h1 class="intro_title title-style-2 title-size-2 title-weight-700" style="--title_margin_bottom_ld: 3rem;--title_margin_bottom_mt: 20px;"><?php echo esc_html( $category_title ); ?></h1>
					
					<?php if ( ! empty( $category_header_content ) ) : ?>
						<div class="intro_text category-header-content" style="--text_margin_bottom_ld: 4rem;--text_margin_bottom_mt: 30px;">
							<?php echo wp_kses_post( $category_header_content ); ?>
						</div>
					<?php endif; ?>
				</div>

				<!-- Posts Grid -->
				<div class="archive-main-content">
					<div class="archive-main-content-posts">
						<?php
						$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

						$args = array(
							'post_type'      => 'post',
							'post_status'    => 'publish',
							'posts_per_page' => 6,
							'paged'          => $paged,
							'tax_query'      => array(
								array(
									'taxonomy' => 'category',
									'field'    => 'term_id',
									'terms'    => $category_id,
								),
							),
						);
						$posts = new WP_Query( $args );

						if ( $posts->have_posts() ) :
							while ( $posts->have_posts() ) :
								$posts->the_post();
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
							echo paginate_links( array(
								'total'     => $posts->max_num_pages,
								'current'   => max( 1, get_query_var( 'paged' ) ),
								'prev_text' => '&larr;',
								'next_text' => '&rarr;',
								'end_size'  => 1,
								'mid_size'  => 1,
							) );
							echo '</div>';

							wp_reset_postdata();
						else :
							?>
							<p class="no-posts-message"><?php esc_html_e( 'No posts found in this category.', 'fos-theme' ); ?></p>
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

		<?php if ( ! empty( $category_bottom_content ) ) : ?>
			<!-- Category Bottom Content -->
			<div class="il_block il_section category-bottom-content-section" style="--b-space-top-ld: 6rem; --b-space-bottom-ld: 6rem; --b-space-top-mt: 4rem; --b-space-bottom-mt: 4rem;">
				<div class="il_section_inner container" style="--custom-max-width-ld: var(--site-width);">
					<div class="category-bottom-content">
						<?php echo wp_kses_post( $category_bottom_content ); ?>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $cta_button_url ) ) : ?>
			<!-- Bottom CTA Section -->
			<div class="il_block il_section hp-helping-donate-now-section" style="--b-space-top-ld: 6.5rem; --b-space-bottom-ld: 8.1rem; --b-space-top-mt: 10rem; --b-space-bottom-mt: 32rem;">
				<div class="il_block_bg" style="background: linear-gradient(96deg, #053279 0%, #030B27 99.13%);">
					<img loading="lazy" decoding="async" width="670" height="360" src="/wp-content/uploads/2023/10/Image-18.png" class="bg_element" alt="" style="--bg-e-width-lg: auto; --bg-e-height-lg: 100%; --bg-e-left-lg: auto; --bg-e-right-lg: 0; --bg-e-top-lg: 0; --bg-e-bottom-lg: 0; --bg-e-width-mt: 33.5rem; --bg-e-height-mt: 18rem; --bg-e-left-mt: 0; --bg-e-right-mt: 0; --bg-e-top-mt: 0; --bg-e-bottom-mt: 0; --bg-e-display-mobile: none" srcset="/wp-content/uploads/2023/10/Image-18.png 670w, /wp-content/uploads/2023/10/Image-18-300x161.png 300w" sizes="(max-width: 670px) 100vw, 670px">
					<img loading="lazy" decoding="async" width="955" height="784" src="/wp-content/uploads/2023/12/Donate-now_image_mobile-2.png" class="bg_element" alt="" style="--bg-e-width-lg: 95.5rem; --bg-e-height-lg: 78.4rem; --bg-e-left-lg: 0; --bg-e-right-lg: 0; --bg-e-top-lg: 0; --bg-e-bottom-lg: 0; --bg-e-width-mt: 40rem; --bg-e-height-mt: auto; --bg-e-left-mt: auto; --bg-e-right-mt: 0; --bg-e-top-mt: auto; --bg-e-bottom-mt: 0; --bg-e-display-desktop: none" srcset="/wp-content/uploads/2023/12/Donate-now_image_mobile-2.png 955w, /wp-content/uploads/2023/11/Donate-now_image_mobile-2-300x246.png 300w, /wp-content/uploads/2023/11/Donate-now_image_mobile-2-768x630.png 768w" sizes="(max-width: 955px) 100vw, 955px">
				</div>
				<div class="il_section_inner container ib-fullwidth stack-mobile" style="--custom-max-width-ld: var(--site-width);">
					<div class="il_block_intro align-left">
						<h2 class="intro_title title-style-1 title-size-2 title-weight-700" style="--title-size-2-ld: 3.6rem;--title-size-2-mt: 25px;--title_margin_bottom_ld: 5rem;--title_margin_bottom_mt: 30px;">
							<span>Whether helping those most in need or advancing healthcare globally: </span><br>when you support Sheba, you are making a difference.
						</h2>
						<div class="buttons">
							<a class="il_btn button-color-blue button-hover-color-purple" href="<?php echo esc_url( $cta_button_url ); ?>" target="_self"><?php echo esc_html( $cta_button_title ); ?></a>
						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</div>

	<button id="backToTopButton"><img src="/wp-content/uploads/2026/02/Group-2755-1.png"></button>
</main><!-- #main -->

<?php
get_footer();
