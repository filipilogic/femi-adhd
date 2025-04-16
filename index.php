<?php

get_header();
$archive_background_class = '';
$category = false;

if ( is_home() ) :

	$blog_before_title = get_field('blog_before_title', 'option');
	$blog_title = get_field('blog_title', 'option');
	$slider_posts_categories = get_field('slider_posts_categories', 'option');
	$middle_posts_categories = get_field('middle_posts_categories', 'option');
	$blog_middle_title = get_field('blog_middle_title', 'option');
	$blog_bottom_title = get_field('blog_bottom_title', 'option');
	$bottom_posts_categories = get_field('bottom_posts_categories', 'option');
	$cta_button_link = get_field('cta_button_link', 'option');
	$cta_button_link_url = $cta_button_link['url'];
	$cta_button_link_title = $cta_button_link['title'];

endif;

if( is_category() ) :

	$category = get_queried_object();

	$archive_before_title = get_field('archive_before_title', 'option');
	$archive_title = $category->name;
	$archive_cta_button_link = get_field('archive_cta_button_link', 'option');
	$archive_cta_button_link_url = $archive_cta_button_link['url'];
	$archive_cta_button_link_title = $archive_cta_button_link['title'];

endif;
?>

	<main id="primary" class="site-main">
		<?php if ( is_home() ) : ?>
			<div class="blog-main-container">
				<div class="blog-main-container-inner">
					<div class="container">
						<div class="intro_before_title before-title-style-3 before-title-size-1 before-title-weight-700" style="--before-title-size-1-ld: 16px;--before-title-size-1-mt: 16px;--before_title_margin_bottom_ld: 1.8rem;--before_title_margin_bottom_mt: 10px;"><?php echo $blog_before_title; ?></div>
						<h2 class="intro_title title-style-2 title-size-2 title-weight-700" style="--title_margin_bottom_ld: 5rem;--title_margin_bottom_mt: 25px;"><?php echo $blog_title; ?></h2>

						<!-- Blog top posts -->
						<div class="blog-main-container-top-posts">
							<?php
								$args = array(
									'post_type'      => 'post',
									'post_status'    => 'publish',
									'posts_per_page' => 1,
									'tax_query'      => array(
										array(
											'taxonomy' => 'category',
											'field'    => 'term_id',
											'terms'    => $slider_posts_categories,
										),
									),
								);
								$posts = new WP_Query( $args );

								if ( $posts->have_posts() ) :
					
									while ( $posts->have_posts() ) :
										$posts->the_post(); ?>
				
										<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
											<a href="<?php the_permalink(); ?>">
												<?php
												the_post_thumbnail( array(1440, 500) );
												?>
												<div class="article-container">
													<header class="entry-header">
														<h3 class="entry-title"><?php the_title(); ?></h3>
														<div class="entry-date"><?php echo get_the_date(); ?></div>
													</header>
													<div class="entry-content">
														<p>
															<?php if (get_the_excerpt()) {
																echo get_the_excerpt();
															} else {
																echo wp_trim_words(get_the_content(), 25);
															} ?>
														</p> 
													</div>
												</div>
											</a>
										</article>
										<?php
									endwhile;
									wp_reset_query();
								endif;
							?>
						</div>

						<h2 class="intro_title title-style-2 title-size-2 title-weight-700" style="--title_margin_bottom_ld: 5rem;--title_margin_bottom_mt: 25px;"><?php echo $blog_middle_title; ?></h2>

						<!-- Blog middle posts -->
						<div class="blog-main-container-middle-posts">
							<?php
							$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

							$args2 = array(
								'post_type'      => 'post',
								'post_status'    => 'publish',
								'posts_per_page' => 3,
								'paged'          => $paged, // Add this line for pagination
								'tax_query'      => array(
									array(
										'taxonomy' => 'category',
										'field'    => 'term_id',
										'terms'    => $middle_posts_categories,
									),
								),
							);
							$posts2 = new WP_Query( $args2 );

							if ( $posts2->have_posts() ) :

								while ( $posts2->have_posts() ) :
									$posts2->the_post(); ?>

										<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
											<a href="<?php the_permalink(); ?>">
												<?php
												the_post_thumbnail( array(508, 250) );
												?>
												<div class="article-container">
													<header class="entry-header">
														<div class="entry-date"><?php echo get_the_date(); ?></div>
														<h3 class="entry-title"><?php the_title(); ?></h3>
													</header>
													<div class="entry-content">
														<p>
															<?php if (get_the_excerpt()) {
																echo get_the_excerpt();
															} else {
																echo wp_trim_words(get_the_content(), 25);
															} ?>
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
								echo paginate_links(array(
									'total' => $posts2->max_num_pages,
									'current' => max(1, get_query_var('paged')),
									'prev_text' => '&larr;',
									'next_text' => '&rarr;',
									'end_size' => 1,
									'mid_size' => 1,
								));
								echo '</div>';

								wp_reset_query();
							endif;
							?>
						</div>

						<h2 class="intro_title title-style-2 title-size-2 title-weight-700" style="--title_margin_bottom_ld: 5rem;--title_margin_bottom_mt: 25px;"><?php echo $blog_bottom_title; ?></h2>

						<!-- Blog bottom posts -->
						<div class="blog-main-container-bottom-posts">
							<?php
							$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

							$args3 = array(
								'post_type'      => 'post',
								'post_status'    => 'publish',
								'posts_per_page' => 3,
								'paged'          => $paged, // Add this line for pagination
								'tax_query'      => array(
									array(
										'taxonomy' => 'category',
										'field'    => 'term_id',
										'terms'    => $bottom_posts_categories,
									),
								),
							);
							$posts3 = new WP_Query( $args3 );

							if ( $posts3->have_posts() ) :

								while ( $posts3->have_posts() ) :
									$posts3->the_post(); ?>

										<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
											<a href="<?php the_permalink(); ?>">
												<?php
												the_post_thumbnail( array(508, 250) );
												?>
												<div class="article-container">
													<header class="entry-header">
														<div class="entry-date"><?php echo get_the_date(); ?></div>
														<h3 class="entry-title"><?php the_title(); ?></h3>
													</header>
													<div class="entry-content">
														<p>
															<?php if (get_the_excerpt()) {
																echo get_the_excerpt();
															} else {
																echo wp_trim_words(get_the_content(), 25);
															} ?>
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
								echo paginate_links(array(
									'total' => $posts3->max_num_pages,
									'current' => max(1, get_query_var('paged')),
									'prev_text' => '&larr;',
									'next_text' => '&rarr;',
									'end_size' => 1,
									'mid_size' => 1,
								));
								echo '</div>';

								wp_reset_query();
							endif;
							?>
						</div>
					</div>
				</div>

				<!-- Bottom CTA Section -->
				<div class="il_block il_section hp-helping-donate-now-section " style=" --b-space-top-ld: 6.5rem; --b-space-bottom-ld: 8.1rem; --b-space-top-mt: 10rem; --b-space-bottom-mt: 32rem;">
					<div class="il_block_bg" style="background: linear-gradient(96deg, #053279 0%, #030B27 99.13%);">
					<img loading="lazy" decoding="async" width="670" height="360" src="/wp-content/uploads/2023/10/Image-18.png" class="bg_element" alt="" style="--bg-e-width-lg: auto; --bg-e-height-lg: 100%; --bg-e-left-lg: auto; --bg-e-right-lg: 0; --bg-e-top-lg: 0; --bg-e-bottom-lg: 0; --bg-e-width-mt: 33.5rem; --bg-e-height-mt: 18rem; --bg-e-left-mt: 0; --bg-e-right-mt: 0; --bg-e-top-mt: 0; --bg-e-bottom-mt: 0; --bg-e-display-mobile: none" srcset="/wp-content/uploads/2023/10/Image-18.png 670w, /wp-content/uploads/2023/10/Image-18-300x161.png 300w" sizes="(max-width: 670px) 100vw, 670px"><img loading="lazy" decoding="async" width="955" height="784" src="/wp-content/uploads/2023/12/Donate-now_image_mobile-2.png" class="bg_element" alt="" style="--bg-e-width-lg: 95.5rem; --bg-e-height-lg: 78.4rem; --bg-e-left-lg: 0; --bg-e-right-lg: 0; --bg-e-top-lg: 0; --bg-e-bottom-lg: 0; --bg-e-width-mt: 40rem; --bg-e-height-mt: auto; --bg-e-left-mt: auto; --bg-e-right-mt: 0; --bg-e-top-mt: auto; --bg-e-bottom-mt: 0; --bg-e-display-desktop: none" srcset="/wp-content/uploads/2023/12/Donate-now_image_mobile-2.png 955w, /wp-content/uploads/2023/11/Donate-now_image_mobile-2-300x246.png 300w, /wp-content/uploads/2023/11/Donate-now_image_mobile-2-768x630.png 768w" sizes="(max-width: 955px) 100vw, 955px">
					</div>
					<div class="il_section_inner container ib-fullwidth stack-mobile " style="--custom-max-width-ld: var(--site-width);">
						<div class="il_block_intro align-left " style="">
							<h2 class="intro_title title-style-1 title-size-2 title-weight-700" style="--title-size-2-ld: 3.6rem;--title-size-2-mt: 25px;--title_margin_bottom_ld: 5rem;--title_margin_bottom_mt: 30px;"><span>Whether helping those most in need or advancing healthcare globally: </span><br>when you support Sheba, you are making a difference.</h2>
							<div class="buttons">
									<a class="il_btn  button-color-green button-hover-color-pink" href="<?php echo $cta_button_link_url; ?>" target="_self"><?php echo $cta_button_link_title; ?></a>
							</div>
						</div>	
					</div>
				</div>
			</div>
		<?php endif; ?>

		<?php if( is_category() ) : ?>
			<div class="archive-main-container">
				<div class="archive-main-container-inner">
					<div class="container">
						<div class="il_block_intro align-left">
							<div class="intro_before_title before-title-style-3 before-title-size-1 before-title-weight-500" style="--before-title-size-1-ld: 20px;--before-title-size-1-mt: 16px;--before_title_margin_bottom_ld: 1.8rem;--before_title_margin_bottom_mt: 12px;"><?php echo $archive_before_title; ?></div>
							<h2 class="intro_title title-style-2 title-size-2 title-weight-700" style="--title_margin_bottom_ld: 5rem;--title_margin_bottom_mt: 30px;"><?php echo $archive_title; ?></h2>
						</div>
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
											'field'    => 'id', // You can change 'id' to 'slug' if you're using category slugs
											'terms'    => get_queried_object_id(), // Gets the ID of the current category
										),
									),
								);
								$posts = new WP_Query( $args );

								if ( $posts->have_posts() ) :

									while ( $posts->have_posts() ) :
										$posts->the_post(); ?>

											<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
												<a href="<?php the_permalink(); ?>">
													<?php
													the_post_thumbnail( array(508, 250) );
													?>
													<div class="article-container">
														<header class="entry-header">
															<div class="entry-date"><?php echo get_the_date(); ?></div>
															<h3 class="entry-title"><?php the_title(); ?></h3>
														</header>
														<div class="entry-content">
															<p>
																<?php if (get_the_excerpt()) {
																	echo get_the_excerpt();
																} else {
																	echo wp_trim_words(get_the_content(), 25);
																} ?>
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
									echo paginate_links(array(
										'total' => $posts->max_num_pages,
										'current' => max(1, get_query_var('paged')),
										'prev_text' => '&larr;',
										'next_text' => '&rarr;',
										'end_size' => 1,
										'mid_size' => 1,
									));
									echo '</div>';

									wp_reset_query();
								endif;
								?>
							</div>
							<div class="archive-main-content-sidebar">
								<?php get_sidebar(); ?>
							</div>
						</div>
					</div>
				</div>

				<!-- Bottom Section First -->
				<div class="il_block il_video-popup-section info-box-width-60 " style=" --b-video-popup-space-top-ld: 10.4rem; --b-video-popup-space-bottom-ld: 10.4rem; --b-video-popup-space-top-mt: 10rem; --b-video-popup-space-bottom-mt: 10rem;">
					<div class="il_section_inner container ib-left stack-mobile " style="--custom-max-width-ld: var(--site-width);">
						<div class="il_block_intro align-left list-cols-1 " style="">
							<div class="intro_before_title before-title-style-3 before-title-size-2 before-title-weight-700" style="--before-title-size-2-ld: 16px;--before-title-size-2-mt: 16px;--before_title_margin_bottom_ld: 1.6rem;--before_title_margin_bottom_mt: 10px;">ABOUT US</div>
								<h2 class="intro_title title-style-2 title-size-2 title-weight-700" style="--title_margin_bottom_ld: 3.6rem;--title_margin_bottom_mt: 30px;">Why <span style="color: var(--color-3); font-weight: 400;">Sheba?</span></h2>
								<div class="intro_text text-theme-color" style="--text_margin_bottom_mt: 40px;">
									<p>The Canadian Friends of Sheba Medical Center is a registered charity based in Toronto committed to supporting the vital work of Sheba Medical Center, a global healthcare leader and the largest, most comprehensive hospital in Israel as well as the Middle East.</p>
									<p>In addition to raising awareness and philanthropic support for Sheba’s humanitarian initiatives, compassionate care, cutting-edge research, and medical education activities, we are proud to serve as the medical center’s Canadian ambassador, helping foster collaborations that <b>serve the people of Canada, Israel, and the world.</b></p>
									<p>It has been a privilege to contribute to Sheba’s transformative global efforts, and with your help, we will continue doing so for the benefit of patients everywhere.</p>
								</div>

								</div><div class="right">
									<div class="column">
									<a data-fancybox="video" data-type="iframe" data-preload="true" data-width="1270" data-height="720" href="https://www.youtube.com/watch?v=ge2hrlLL0qE" rel="lightbox">
									<img loading="lazy" decoding="async" width="488" height="420" src="/wp-content/uploads/2023/11/Group-221.png" class="sec_desk_img" alt="" style="--bg-e-width-lg: 48.8rem; --bg-e-height-lg: 42rem; --bg-e-left-lg: auto; --bg-e-right-lg: auto; --bg-e-top-lg: 0; --bg-e-bottom-lg: 0; --bg-e-width-mt: 60rem; --bg-e-height-mt: auto; --bg-e-left-mt: auto; --bg-e-right-mt: auto; --bg-e-top-mt: 0; --bg-e-bottom-mt: 0; border-top-left-radius: 36px; border-top-right-radius: 36px; border-bottom-left-radius: 0px; border-bottom-right-radius: 36px;" srcset="/wp-content/uploads/2023/11/Group-221.png 488w, /wp-content/uploads/2023/11/Group-221-300x258.png 300w" sizes="(max-width: 488px) 100vw, 488px"></a>
								</div>
						</div>
					</div>
				</div>


				<!-- Bottom CTA Section -->
				<div class="il_block il_section hp-helping-donate-now-section " style=" --b-space-top-ld: 6.5rem; --b-space-bottom-ld: 8.1rem; --b-space-top-mt: 10rem; --b-space-bottom-mt: 32rem;">
					<div class="il_block_bg" style="background: linear-gradient(96deg, #053279 0%, #030B27 99.13%);">
					<img loading="lazy" decoding="async" width="670" height="360" src="/wp-content/uploads/2023/10/Image-18.png" class="bg_element" alt="" style="--bg-e-width-lg: auto; --bg-e-height-lg: 100%; --bg-e-left-lg: auto; --bg-e-right-lg: 0; --bg-e-top-lg: 0; --bg-e-bottom-lg: 0; --bg-e-width-mt: 33.5rem; --bg-e-height-mt: 18rem; --bg-e-left-mt: 0; --bg-e-right-mt: 0; --bg-e-top-mt: 0; --bg-e-bottom-mt: 0; --bg-e-display-mobile: none" srcset="/wp-content/uploads/2023/10/Image-18.png 670w, /wp-content/uploads/2023/10/Image-18-300x161.png 300w" sizes="(max-width: 670px) 100vw, 670px"><img loading="lazy" decoding="async" width="955" height="784" src="/wp-content/uploads/2023/12/Donate-now_image_mobile-2.png" class="bg_element" alt="" style="--bg-e-width-lg: 95.5rem; --bg-e-height-lg: 78.4rem; --bg-e-left-lg: 0; --bg-e-right-lg: 0; --bg-e-top-lg: 0; --bg-e-bottom-lg: 0; --bg-e-width-mt: 40rem; --bg-e-height-mt: auto; --bg-e-left-mt: auto; --bg-e-right-mt: 0; --bg-e-top-mt: auto; --bg-e-bottom-mt: 0; --bg-e-display-desktop: none" srcset="/wp-content/uploads/2023/12/Donate-now_image_mobile-2.png 955w, /wp-content/uploads/2023/11/Donate-now_image_mobile-2-300x246.png 300w, /wp-content/uploads/2023/11/Donate-now_image_mobile-2-768x630.png 768w" sizes="(max-width: 955px) 100vw, 955px">
					</div>
					<div class="il_section_inner container ib-fullwidth stack-mobile " style="--custom-max-width-ld: var(--site-width);">
						<div class="il_block_intro align-left " style="">
							<h2 class="intro_title title-style-1 title-size-2 title-weight-700" style="--title-size-2-ld: 3.6rem;--title-size-2-mt: 25px;--title_margin_bottom_ld: 5rem;--title_margin_bottom_mt: 30px;"><span>Whether helping those most in need or advancing healthcare globally: </span><br>when you support Sheba, you are making a difference.</h2>
							<div class="buttons">
									<a class="il_btn  button-color-green button-hover-color-pink" href="<?php echo $archive_cta_button_link_url; ?>" target="_self"><?php echo $archive_cta_button_link_title; ?></a>
							</div>
						</div>	
					</div>
				</div>
			</div>
		<?php endif; ?>

		<button id="backToTopButton"><img src="/wp-content/uploads/2024/12/Group-2755.png"></button>
	</main><!-- #main -->

<?php
get_footer();
