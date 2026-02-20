<?php
$margin = get_field_object('margin');
$custom_padding = get_field('custom_padding');
$padding = get_field_object('padding');

$categories_list = get_field('pick_a_category_blog_block');
$show_categories_list = get_field('show_categories_list');

$posts_per_page = get_field('posts_per_page');
$carousel = get_field('carousel');
$show_date = get_field('show_date');
$pagination_type = get_field('pagination_type');
$show_homepage_image = get_field('show_homepage_image');
$show_category_badge = get_field('show_category_badge');
$show_learn_more = get_field('show_learn_more');

$learn_more_text = get_field('learn_more_text');

$block_id = 'blog_block_' . uniqid();
$block_type = 'blog'; // Identify this as a blog block

$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
    $anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}

$class = 'il_block il_blog-block-section';
if ( ! empty( $block['className'] ) ) {
    $class .= ' ' . $block['className'];
}
if ( ! empty( $margin ) ) {
    $class .=  ' ' . $margin['value'];
}
if ( ! empty( $padding) ) {
    $class .=  ' ' . $padding['value'];
}
if ( ! empty( $carousel) ) {
    $class .=  ' blog-carousel-enabled';
} else {
    $class .=  ' blog-carousel-disabled';
}
if( $custom_padding ) {
	$paddings = '';

	if ( have_rows('custom_padding_ld')) {
		while (have_rows('custom_padding_ld')) {
			the_row();
			$padding_top = get_sub_field('padding_top');
			$padding_bottom = get_sub_field('padding_bottom');
			$padding_left = get_sub_field('padding_left');
			$padding_right = get_sub_field('padding_right');

			if( ! empty($padding_top) ) {
				$paddings .= ' --b-blog-block-space-top-ld: ' . $padding_top . ';';
			}
			if( ! empty($padding_bottom) ) {
				$paddings .= ' --b-blog-block-space-bottom-ld: ' . $padding_bottom . ';';
			}
			if( ! empty($padding_left) ) {
				$paddings .= ' --b-blog-block-space-left-ld: ' . $padding_left . ';';
			}
			if( ! empty($padding_right) ) {
				$paddings .= ' --b-blog-block-space-right-ld: ' . $padding_right . ';';
			}
		}
	}
	if ( have_rows('custom_padding_mt')) {
		while (have_rows('custom_padding_mt')) {
			the_row();
			$padding_top = get_sub_field('padding_top');
			$padding_bottom = get_sub_field('padding_bottom');
			$padding_left = get_sub_field('padding_left');
			$padding_right = get_sub_field('padding_right');

			if( ! empty($padding_top) ) {
				$paddings .= ' --b-blog-block-space-top-mt: ' . $padding_top . ';';
			}
			if( ! empty($padding_bottom) ) {
				$paddings .= ' --b-blog-block-space-bottom-mt: ' . $padding_bottom . ';';
			}
			if( ! empty($padding_left) ) {
				$paddings .= ' --b-blog-block-space-left-mt: ' . $padding_left . ';';
			}
			if( ! empty($padding_right) ) {
				$paddings .= ' --b-blog-block-space-right-mt: ' . $padding_right . ';';
			}
		}
	}
}

// Categories for filter bar when "Show categories list" is on
$filter_categories = array();
if ( $show_categories_list ) {
    $filter_categories = get_categories(array(
        'taxonomy'   => 'category',
        'hide_empty' => true,
        'orderby'    => 'name',
        'order'      => 'ASC',
        'number'     => 0,
    ));
}

?>

<div <?php echo $anchor; ?> class="<?php echo $class; ?>" data-block-id="<?php echo $block_id; ?>" data-block-type="<?php echo $block_type; ?>" <?php if ( $custom_padding ) echo 'style="' . $paddings . '"'; ?>>
    <?php get_template_part('components/background'); ?>
    <div class="container">
        <?php get_template_part('components/intro'); ?>
        <?php if ( $show_categories_list ) : ?>
        <div class="blog-block-filters">
            <button type="button" class="filter-btn active" data-category="0">הכל</button>
            <?php foreach ( $filter_categories as $category ) : ?>
                <button type="button" class="filter-btn" data-category="<?php echo esc_attr( $category->term_id ); ?>"><?php echo esc_html( $category->name ); ?></button>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <div class="il_inner_posts_container">
            <?php 
            // Check if categories are selected
            if ($categories_list) {
                $args = array(
                    'post_type'      => 'post',
                    'post_status'    => 'publish',
                    'posts_per_page' => $posts_per_page,
                    'tax_query'      => array(
                        array(
                            'taxonomy' => 'category',
                            'field'    => 'term_id',
                            'terms'    => $categories_list,
                        ),
                    ),
                );
            } else {
                // No categories selected, show all posts
                $args = array(
                    'post_type'      => 'post',
                    'post_status'    => 'publish',
                    'posts_per_page' => $posts_per_page,
                );
            }
                
                $posts = new WP_Query( $args );
                $total_posts = $posts->found_posts;
                
                if ( $posts->have_posts() ) :
                
                    while ( $posts->have_posts() ) :
                        $posts->the_post(); ?>

                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                            <a href="<?php the_permalink(); ?>">
                                <?php
                                $homepage_image = get_field('homepage_image', get_the_ID());
                                $event_time = get_field('event_time', get_the_ID());
                                $event_location = get_field('event_location', get_the_ID());
                                $event_date = get_field('event_date', get_the_ID());
                                
                                // Get category and color for badge
                                $post_categories = get_the_category();
                                $cat_color = '#1F9DD0'; // Default color
                                $cat_name = '';
                                if ( $post_categories ) {
                                    $first_category = $post_categories[0];
                                    $cat_name = $first_category->name;
                                    $cat_color_field = get_field('category_color', 'category_' . $first_category->term_id);
                                    if ( $cat_color_field ) {
                                        $cat_color = $cat_color_field;
                                    }
                                }
                                ?>
                                <div class="image-wrapper">
                                    <?php
                                    if ( $show_homepage_image && $homepage_image ) {
                                        $size = 'full';
                                        echo wp_get_attachment_image( $homepage_image, $size, false );
                                    } else {
                                        the_post_thumbnail( array(508, 250) );
                                    }
                                    ?>
                                    <?php if ( $show_category_badge && $cat_name ) : ?>
                                        <span class="category-badge" style="background-color: <?php echo esc_attr($cat_color); ?>">
                                            <?php echo esc_html($cat_name); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <div class="article-container">
                                    <?php if( $show_date ) { ?>
                                        <div class="entry-date"><?php echo get_the_date(); ?></div>
                                    <?php } ?>
                                    <header class="entry-header">
                                        <h3 class="entry-title"><?php the_title(); ?></h3>
                                    </header>
                                    <?php if ( $event_time || $event_location || $event_date ) : ?>
                                        <div class="event-details">
                                            <?php if ( $event_time ) : ?>
                                                <p class="event-time"><?php echo $event_time; ?><span class="sep-event-time">|</span></p>
                                            <?php endif; ?>

                                            <?php if ( $event_location ) : ?>
                                                <p class="event-location"><?php echo $event_location; ?><span class="sep-event-location">|</span></p>
                                            <?php endif; ?>

                                            <?php if ( $event_date ) : ?>
                                                <p class="event-date"><?php echo $event_date; ?></p>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ( empty( $carousel) ) { ?>
                                        <div class="entry-content">
                                            <p>
                                                <?php 
                                                if ( has_excerpt() ) {
                                                    echo esc_html(get_the_excerpt());
                                                } else {
                                                    $content = wp_strip_all_tags(get_the_content());
                                                    echo esc_html(mb_strimwidth($content, 0, 126, '...'));
                                                }
                                                ?>
                                            </p> 
                                        </div>
                                    <?php } ?>
                                    <?php if ( $show_learn_more && $learn_more_text ) { ?>
                                        <span class="entry_btn" style="--blog-category-color: <?php echo esc_attr($cat_color); ?>">
                                            <?php echo $learn_more_text; ?>
                                            <?php if ( ! empty( $carousel) ) { ?>
                                                <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="14" cy="14" r="14" fill="#2FB297"/><path fill-rule="evenodd" clip-rule="evenodd" d="M14.7053 6.70532C14.3158 6.31578 13.6842 6.31578 13.2947 6.70532C12.9054 7.0946 12.9051 7.72568 13.2941 8.11531L18.17 13H7C6.44771 13 6 13.4477 6 14C6 14.5523 6.44772 15 7 15H18.17L13.2941 19.8847C12.9051 20.2743 12.9054 20.9054 13.2947 21.2947C13.6842 21.6842 14.3158 21.6842 14.7053 21.2947L22 14L14.7053 6.70532Z" fill="white"/><mask id="mask0_276_1421" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="6" y="6" width="16" height="16"><path fill-rule="evenodd" clip-rule="evenodd" d="M14.7053 6.70532C14.3158 6.31578 13.6842 6.31578 13.2947 6.70532C12.9054 7.0946 12.9051 7.72568 13.2941 8.11531L18.17 13H7C6.44771 13 6 13.4477 6 14C6 14.5523 6.44772 15 7 15H18.17L13.2941 19.8847C12.9051 20.2743 12.9054 20.9054 13.2947 21.2947C13.6842 21.6842 14.3158 21.6842 14.7053 21.2947L22 14L14.7053 6.70532Z" fill="white"/></mask><g mask="url(#mask0_276_1421)"><rect x="2" y="2" width="24" height="24" fill="white"/></g></svg>
                                            <?php } ?>
                                        </span>
                                    <?php } ?>
                                </div>
                            </a>
                        </article>
                        <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
            ?>

            <?php if ( have_rows('buttons_after_blog_group') && get_field('buttons_after_blog_group')['buttons'] !== false) { ?>
                
                <div class="buttons-after-blog">
                    <?php while (have_rows('buttons_after_blog_group')) {
                        the_row();
                        get_template_part('components/buttons');
                    } ?>
                </div>
            <?php } ?>
        </div>

        <?php
        $total_pages = $total_posts > 0 ? (int) ceil( $total_posts / $posts_per_page ) : 0;
        $has_pagination = $pagination_type && $pagination_type !== 'none' && $total_posts > $posts_per_page;
        $output_load_more_data = $has_pagination || $show_categories_list;
        if ( $output_load_more_data ) :
        ?>
            <?php if ( $has_pagination && $pagination_type === 'load_more' ) : ?>
                <div class="load-more-container">
                    <button class="load-more-button" data-block-id="<?php echo esc_attr($block_id); ?>" data-block-type="<?php echo esc_attr($block_type); ?>">Load More</button>
                </div>
            <?php elseif ( $has_pagination && $pagination_type === 'numbered' ) : ?>
                <div class="numbered-pagination-container" data-block-id="<?php echo esc_attr($block_id); ?>" data-current-page="1" data-total-pages="<?php echo esc_attr($total_pages); ?>">
                    <button class="pagination-prev" disabled aria-label="Previous page">
                        <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7 1L1 7L7 13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                    <div class="pagination-numbers">
                        <?php for ( $i = 1; $i <= $total_pages; $i++ ) : ?>
                            <button class="pagination-number<?php echo $i === 1 ? ' active' : ''; ?>" data-page="<?php echo esc_attr($i); ?>"><?php echo esc_html($i); ?></button>
                        <?php endfor; ?>
                    </div>
                    <button class="pagination-next" aria-label="Next page">
                        <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 1L7 7L1 13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>
            <?php endif; ?>

            <script>
                window.loadMoreData_<?php echo $block_id; ?> = {
                    totalPosts: <?php echo $total_posts; ?>,
                    postsPerPage: <?php echo $posts_per_page; ?>,
                    totalPages: <?php echo $total_pages; ?>,
                    paginationType: <?php echo json_encode($pagination_type); ?>,
                    showCategoriesList: <?php echo $show_categories_list ? 'true' : 'false'; ?>,
                    filterCategoryIds: <?php echo json_encode( array_map( function( $c ) { return (int) $c->term_id; }, $filter_categories ) ); ?>,
                    extraData: {
                        categories: <?php echo json_encode($categories_list); ?>,
                        show_date: <?php echo json_encode($show_date); ?>,
                        learn_more_text: <?php echo json_encode($learn_more_text); ?>,
                        carousel: <?php echo json_encode($carousel); ?>,
                        show_homepage_image: <?php echo json_encode($show_homepage_image); ?>,
                        show_category_badge: <?php echo json_encode($show_category_badge); ?>,
                        show_learn_more: <?php echo json_encode($show_learn_more); ?>
                    }
                };
            </script>
        <?php endif; ?>
    </div>
</div>
