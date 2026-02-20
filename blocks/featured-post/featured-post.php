<?php
/**
 * Featured Post Block - Shows latest post by category with filter buttons
 */

// Get spacing fields
$margin = get_field_object('margin');
$custom_padding = get_field('custom_padding');
$padding = get_field_object('padding');

// Get settings
$read_more_text = get_field('read_more_text') ?: 'קרא עוד >';
$show_read_time = get_field('show_read_time');
$show_category_badge = get_field('show_category_badge');

// Block ID for JS
$block_id = 'featured_post_' . uniqid();

// Anchor support
$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
    $anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}

// Build classes
$class = 'il_block il_featured-post';
if ( ! empty( $block['className'] ) ) {
    $class .= ' ' . $block['className'];
}
if ( ! empty( $margin ) ) {
    $class .= ' ' . $margin['value'];
}
if ( ! empty( $padding ) ) {
    $class .= ' ' . $padding['value'];
}

// Build custom padding styles
$paddings = '';
if ( $custom_padding ) {
    if ( have_rows('custom_padding_ld') ) {
        while ( have_rows('custom_padding_ld') ) {
            the_row();
            $padding_top = get_sub_field('padding_top');
            $padding_bottom = get_sub_field('padding_bottom');
            $padding_left = get_sub_field('padding_left');
            $padding_right = get_sub_field('padding_right');

            if ( ! empty($padding_top) ) {
                $paddings .= ' --b-featured-post-space-top-ld: ' . $padding_top . ';';
            }
            if ( ! empty($padding_bottom) ) {
                $paddings .= ' --b-featured-post-space-bottom-ld: ' . $padding_bottom . ';';
            }
            if ( ! empty($padding_left) ) {
                $paddings .= ' --b-featured-post-space-left-ld: ' . $padding_left . ';';
            }
            if ( ! empty($padding_right) ) {
                $paddings .= ' --b-featured-post-space-right-ld: ' . $padding_right . ';';
            }
        }
    }
    if ( have_rows('custom_padding_mt') ) {
        while ( have_rows('custom_padding_mt') ) {
            the_row();
            $padding_top = get_sub_field('padding_top');
            $padding_bottom = get_sub_field('padding_bottom');
            $padding_left = get_sub_field('padding_left');
            $padding_right = get_sub_field('padding_right');

            if ( ! empty($padding_top) ) {
                $paddings .= ' --b-featured-post-space-top-mt: ' . $padding_top . ';';
            }
            if ( ! empty($padding_bottom) ) {
                $paddings .= ' --b-featured-post-space-bottom-mt: ' . $padding_bottom . ';';
            }
            if ( ! empty($padding_left) ) {
                $paddings .= ' --b-featured-post-space-left-mt: ' . $padding_left . ';';
            }
            if ( ! empty($padding_right) ) {
                $paddings .= ' --b-featured-post-space-right-mt: ' . $padding_right . ';';
            }
        }
    }
}

// Query latest post (excluding uncategorized)
$args = array(
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => 1,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'category__not_in' => array(1),
);

$latest_post = new WP_Query($args);
?>

<div <?php echo $anchor; ?> class="<?php echo esc_attr($class); ?>" data-block-id="<?php echo esc_attr($block_id); ?>" <?php if ( $custom_padding ) echo 'style="' . esc_attr($paddings) . '"'; ?>>
    <?php get_template_part('components/background'); ?>
    <div class="container">
        <?php get_template_part('components/intro'); ?>

        <!-- Post Card Container -->
        <div class="featured-post-card-container" data-post-container>
            <?php if ( $latest_post->have_posts() ) : ?>
                <?php while ( $latest_post->have_posts() ) : $latest_post->the_post(); ?>
                    <?php
                    // Get post data
                    $post_id = get_the_ID();
                    $homepage_image = get_field('homepage_image', $post_id);
                    $read_time = il_get_reading_time($post_id);
                    
                    // Get category and color
                    $post_categories = get_the_category();
                    $cat_color = '#32A596'; // Default green
                    $cat_name = '';
                    if ( $post_categories ) {
                        // Get first non-uncategorized category
                        foreach ( $post_categories as $cat ) {
                            if ( $cat->term_id !== 1 ) {
                                $cat_name = $cat->name;
                                $cat_color_field = get_field('category_color', 'category_' . $cat->term_id);
                                if ( $cat_color_field ) {
                                    $cat_color = $cat_color_field;
                                }
                                break;
                            }
                        }
                    }
                    ?>
                    <a href="<?php the_permalink(); ?>" class="featured-post-card">
                        <div class="featured-post-content">
                            <?php if ( $show_category_badge && $cat_name ) : ?>
                                <span class="featured-post-badge" style="background-color: <?php echo esc_attr($cat_color); ?>">
                                    <?php echo esc_html($cat_name); ?>
                                </span>
                            <?php endif; ?>
                            
                            <div class="featured-post-text">
                                <h3 class="featured-post-title"><?php the_title(); ?></h3>
                                <div class="featured-post-excerpt">
                                    <?php 
                                    if ( has_excerpt() ) {
                                        echo esc_html(get_the_excerpt());
                                    } else {
                                        $content = wp_strip_all_tags(get_the_content());
                                        echo esc_html(mb_strimwidth($content, 0, 200, '...'));
                                    }
                                    ?>
                                </div>
                            </div>
                            
                            <div class="featured-post-footer">
                                <span class="featured-post-link"><?php echo esc_html($read_more_text); ?></span>
                                <?php if ( $show_read_time ) : ?>
                                    <span class="featured-post-read-time"><?php echo esc_html($read_time); ?> <?php esc_html_e("דק' קריאה", 'ilogic'); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="featured-post-image">
                            <?php
                            if ( $homepage_image ) {
                                echo wp_get_attachment_image($homepage_image, 'large', false, array('class' => 'featured-post-img'));
                            } elseif ( has_post_thumbnail() ) {
                                the_post_thumbnail('large', array('class' => 'featured-post-img'));
                            }
                            ?>
                        </div>
                    </a>
                <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>
            <?php else : ?>
                <div class="featured-post-no-posts">
                    <p>לא נמצאו פוסטים</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
