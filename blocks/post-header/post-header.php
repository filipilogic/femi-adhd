<?php
/**
 * Post Header Block Template
 * 
 * Displays post header with breadcrumbs, title, date/reading time meta, and featured image
 */

// Get field values
$show_breadcrumbs = get_field('show_breadcrumbs');
$show_reading_time = get_field('show_reading_time');
$show_date = get_field('show_date');
$date_format = get_field('date_format') ?: 'd.m.y';
$breadcrumb_home_text = get_field('breadcrumb_home_text') ?: 'ראשי';
$breadcrumb_archive_text = get_field('breadcrumb_archive_text') ?: 'מרכז הידע';
$breadcrumb_archive_url = get_field('breadcrumb_archive_url');

// Styling fields
$image_border_radius = get_field('image_border_radius') ?: 16;
$title_color = get_field('title_color');
$meta_color = get_field('meta_color');

// Spacing fields
$margin = get_field_object('margin');
$padding = get_field_object('padding');
$custom_padding = get_field('custom_padding');

// Check if being used as a block or direct template
$is_block_context = isset($block);

// Build anchor - only for block context
$anchor = '';
if ( $is_block_context && ! empty( $block['anchor'] ) ) {
    $anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}

// Build classes - handle both contexts
$class = 'il_block il_post-header';
if ( $is_block_context && ! empty( $block['className'] ) ) {
    $class .= ' ' . $block['className'];
}
if ( ! empty( $margin ) && ! empty( $margin['value'] ) ) {
    $class .= ' ' . $margin['value'];
}
if ( ! empty( $padding ) && ! empty( $padding['value'] ) ) {
    $class .= ' ' . $padding['value'];
}

// Build custom styles
$custom_style = '';
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
                $paddings .= ' --b-space-top-ld: ' . $padding_top . ';';
            }
            if ( ! empty($padding_bottom) ) {
                $paddings .= ' --b-space-bottom-ld: ' . $padding_bottom . ';';
            }
            if ( ! empty($padding_left) ) {
                $paddings .= ' --b-space-left-ld: ' . $padding_left . ';';
            }
            if ( ! empty($padding_right) ) {
                $paddings .= ' --b-space-right-ld: ' . $padding_right . ';';
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
                $paddings .= ' --b-space-top-mt: ' . $padding_top . ';';
            }
            if ( ! empty($padding_bottom) ) {
                $paddings .= ' --b-space-bottom-mt: ' . $padding_bottom . ';';
            }
            if ( ! empty($padding_left) ) {
                $paddings .= ' --b-space-left-mt: ' . $padding_left . ';';
            }
            if ( ! empty($padding_right) ) {
                $paddings .= ' --b-space-right-mt: ' . $padding_right . ';';
            }
        }
    }
}

// Build inline styles for customizable colors
$inner_style = '';
if ( $title_color ) {
    $inner_style .= '--post-header-title-color: ' . esc_attr($title_color) . ';';
}
if ( $meta_color ) {
    $inner_style .= '--post-header-meta-color: ' . esc_attr($meta_color) . ';';
}
if ( $image_border_radius ) {
    $inner_style .= '--post-header-image-radius: ' . intval($image_border_radius) . 'px;';
}

// Default values for show fields (true if not set)
if ( $show_breadcrumbs === null ) {
    $show_breadcrumbs = true;
}
if ( $show_reading_time === null ) {
    $show_reading_time = true;
}
if ( $show_date === null ) {
    $show_date = true;
}

?>

<div <?php echo $anchor; ?>class="<?php echo esc_attr($class); ?>"<?php if ( $paddings ) echo ' style="' . esc_attr($paddings) . '"'; ?>>
    <div class="il_post-header_outer"<?php if ( $inner_style ) echo ' style="' . esc_attr($inner_style) . '"'; ?>>
        
        <!-- Narrow content container (1114px) -->
        <div class="il_post-header_content">
            <?php if ( $show_breadcrumbs ) : ?>
                <?php 
                $breadcrumbs = il_get_post_breadcrumbs($breadcrumb_home_text, $breadcrumb_archive_text, $breadcrumb_archive_url);
                if ( ! empty($breadcrumbs) ) : 
                ?>
                <nav class="il_post-header_breadcrumbs" aria-label="<?php esc_attr_e('Breadcrumb', 'ilogic'); ?>">
                    <?php 
                    $breadcrumb_count = count($breadcrumbs);
                    foreach ( $breadcrumbs as $index => $crumb ) :
                        $is_last = ($index === $breadcrumb_count - 1);
                        
                        if ( ! $is_last && ! empty($crumb['url']) ) : ?>
                            <a href="<?php echo esc_url($crumb['url']); ?>" class="il_post-header_breadcrumb-item">
                                <?php echo esc_html($crumb['text']); ?>
                            </a>
                            <span class="il_post-header_breadcrumb-separator"> > </span>
                        <?php else : ?>
                            <span class="il_post-header_breadcrumb-item il_post-header_breadcrumb-current">
                                <?php echo esc_html($crumb['text']); ?>
                            </span>
                        <?php endif;
                    endforeach; 
                    ?>
                </nav>
                <?php endif; ?>
            <?php endif; ?>

            <h1 class="il_post-header_title"><?php the_title(); ?></h1>

            <?php if ( $show_date || $show_reading_time ) : ?>
                <div class="il_post-header_meta">
                    <?php if ( $show_date ) : ?>
                        <span class="il_post-header_date"><?php echo esc_html(get_the_date($date_format)); ?></span>
                    <?php endif; ?>
                    
                    <?php if ( $show_date && $show_reading_time ) : ?>
                        <span class="il_post-header_separator">|</span>
                    <?php endif; ?>
                    
                    <?php if ( $show_reading_time ) : ?>
                        <span class="il_post-header_reading-time">
                            <span class="il_post-header_reading-time-icon">⏱️</span>
                            <?php echo esc_html(il_get_reading_time()); ?> <?php esc_html_e("דק' קריאה", 'ilogic'); ?>
                        </span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Full width image container (1394px) -->
        <?php if ( has_post_thumbnail() ) : ?>
            <div class="il_post-header_image">
                <?php the_post_thumbnail('full', ['class' => 'il_post-header_img']); ?>
            </div>
        <?php endif; ?>

    </div>
</div>
