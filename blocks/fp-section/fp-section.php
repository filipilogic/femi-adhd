<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/public/js/vendor/fullpage.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/public/css/vendor/fullpage.css">
<?php

// Check rows existexists.
if( have_rows('full_screen_section') ): ?>
<div id="fullpage">

    <?php // Loop through rows.

    while( have_rows('full_screen_section') ) : the_row();

    $margin = get_sub_field_object('margin');
    $padding = get_sub_field_object('padding');

    $use_bg = get_sub_field('use_background');
    $bg_color = get_sub_field('background_color');
    $bg_img = get_sub_field('background_image');
    $bg_img_mob = get_sub_field('background_image_mob');
    $size = 'full';

    $title = get_sub_field('title');
    $tag = get_sub_field('heading_tag');
    $title_color = get_sub_field('title_color');
    $style = get_sub_field('title_style');

    $intro_text = get_sub_field('intro_text');
    $text_color = get_sub_field_object('intro_text_color');
    $alignment = get_sub_field_object('intro_alignment');

    $sec_text = get_sub_field('secondary_text');


    $class = 'il_block il_fp_section section';
    if ( ! empty( $block['className'] ) ) {
        $class .= ' ' . $block['className'];
    }

    if ( ! empty($text_color) ) {
        $class .=  ' ' . $text_color['value'];
    }
    if ( ! empty( $alignment) ) {
        $class .=  ' ' . $alignment['value'];
    } ?>

        <div class="<?php echo $class; ?>" data-tooltip="<?php echo $title; ?>" data-anchor="<?php echo str_replace(' ', '', $title); ?>">
        <?php if($use_bg) { ?>
        <div class="il_block_bg" style="background-color: <?php echo $bg_color; ?>">
        <?php
        if( $bg_img ) {
            echo wp_get_attachment_image( $bg_img, $size, "",array( 'class' => 'desk_bg' ) );
        }
        if( $bg_img_mob ) {
            echo wp_get_attachment_image( $bg_img_mob, $size, "",array( 'class' => 'mob_bg' ) );
        }

        ?>

        </div>
        <?php } ?>
            <div class="container">
            <?php if( $title ) { ?>
            <<?php echo esc_html($tag); ?> class="intro_title <?php echo $style; ?>" style="color: <?php echo $title_color; ?>;"><?php echo $title; ?></<?php echo esc_html($tag); ?>>
            <?php }

            if( $intro_text ) { ?>
                <div class="intro_text">
                    <?php echo $intro_text; ?>
                    <div class="il_hm">
                        <?php echo $sec_text; ?>
                    </div>
                </div>
            <?php } ?>
            </div>
        </div>

    <?php // End loop.
    endwhile; ?>
</div>

<?php endif;

?>

<script>
    let sections = document.querySelectorAll('[data-tooltip]');
    let tooltips = [];
    if(sections.length > 0) {
        sections.forEach((section) => {
            let tooltip = section.dataset.tooltip;
            if(tooltip) tooltips.push(tooltip);
        });
    }
	new fullpage('#fullpage', {
    navigation: true,
    navigationPosition: 'right',
    navigationTooltips: tooltips,
    showActiveTooltip: true
    });
</script>