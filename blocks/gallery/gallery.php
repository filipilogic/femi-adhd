<?php
$cols = get_field_object('columns');
$tab_cols = get_field_object('tab_columns');
$mob_cols = get_field_object('mob_columns');
$team_layout = get_field_object('layout');

$margin = get_field_object('margin');
$custom_padding = get_field('custom_padding');
$padding = get_field_object('padding');

$inner_columns_container_max_width = get_field('inner_columns_container_max_width');

$slider_on_mobile_and_tablet = get_field('slider_on_mobile_and_tablet');
$prev_next_buttons_below_gallery = get_field('prev_next_buttons_below_gallery');

$open_images_in_lightbox = get_field('open_images_in_lightbox');

$col_in_style = 'style="';

if( ! empty($inner_columns_container_max_width) ) {
	$col_in_style .= '--custom-max-width-ld: ' . $inner_columns_container_max_width . ';';
} else {
	$col_in_style .= '--custom-max-width-ld: var(--site-width);';
}


$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
    $anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}

$class = 'il_block il_gallery';
if ( ! empty( $block['className'] ) ) {
    $class .= ' ' . $block['className'];
}

if ( ! empty( $cols ) ) {
    $class .=  ' ' . $cols['value'];
}
if ( ! empty( $tab_cols ) ) {
    $class .=  ' ' . $tab_cols['value'];
}
if ( ! empty( $mob_cols ) ) {
    $class .=  ' ' . $mob_cols['value'];
}

if ( ! empty( $margin ) ) {
    $class .=  ' ' . $margin['value'];
}

if ( ! empty( $padding) ) {
    $class .=  ' ' . $padding['value'];
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
				$paddings .= ' --b-columns-space-top-ld: ' . $padding_top . ';';
			}
			if( ! empty($padding_bottom) ) {
				$paddings .= ' --b-columns-space-bottom-ld: ' . $padding_bottom . ';';
			}
			if( ! empty($padding_left) ) {
				$paddings .= ' --b-columns-space-left-ld: ' . $padding_left . ';';
			}
			if( ! empty($padding_right) ) {
				$paddings .= ' --b-columns-space-right-ld: ' . $padding_right . ';';
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
				$paddings .= ' --b-columns-space-top-mt: ' . $padding_top . ';';
			}
			if( ! empty($padding_bottom) ) {
				$paddings .= ' --b-columns-space-bottom-mt: ' . $padding_bottom . ';';
			}
			if( ! empty($padding_left) ) {
				$paddings .= ' --b-columns-space-left-mt: ' . $padding_left . ';';
			}
			if( ! empty($padding_right) ) {
				$paddings .= ' --b-columns-space-right-mt: ' . $padding_right . ';';
			}
		}
	}
}

$col_in_class = 'il_gallery_container container';

if ( ! empty( $slider_on_mobile_and_tablet) ) {
    $class .=  ' flickity-on-smaller';
}

?>

<!-- Inner Section Spacing -->
<?php if ( have_rows('inner_columns_container_spacing_group')) {
	while (have_rows('inner_columns_container_spacing_group')) {
		the_row();
		$col_inner_cont_custom_padding = get_sub_field('custom_padding');
		$col_inner_cont_padding = get_sub_field_object('padding');
		$col_inner_cont_paddings = '';
		
		if( $col_inner_cont_custom_padding ) {
		
			if ( have_rows('custom_padding_ld')) {
				while (have_rows('custom_padding_ld')) {
					the_row();
					$col_inner_cont_padding_top = get_sub_field('padding_top');
					$col_inner_cont_padding_bottom = get_sub_field('padding_bottom');
					$col_inner_cont_padding_left = get_sub_field('padding_left');
					$col_inner_cont_padding_right = get_sub_field('padding_right');
		
					if( ! empty($col_inner_cont_padding_top) ) {
						$col_inner_cont_paddings .= ' --b-col-inner-cont-space-top-ld: ' . $col_inner_cont_padding_top . ';';
					}
					if( ! empty($col_inner_cont_padding_bottom) ) {
						$col_inner_cont_paddings .= ' --b-col-inner-cont-space-bottom-ld: ' . $col_inner_cont_padding_bottom . ';';
					}
					if( ! empty($col_inner_cont_padding_left) ) {
						$col_inner_cont_paddings .= ' --b-col-inner-cont-space-left-ld: ' . $col_inner_cont_padding_left . ';';
					}
					if( ! empty($col_inner_cont_padding_right) ) {
						$col_inner_cont_paddings .= ' --b-col-inner-cont-space-right-ld: ' . $col_inner_cont_padding_right . ';';
					}
				}
			}
			if ( have_rows('custom_padding_mt')) {
				while (have_rows('custom_padding_mt')) {
					the_row();
					$col_inner_cont_padding_top = get_sub_field('padding_top');
					$col_inner_cont_padding_bottom = get_sub_field('padding_bottom');
					$col_inner_cont_padding_left = get_sub_field('padding_left');
					$col_inner_cont_padding_right = get_sub_field('padding_right');
		
					if( ! empty($col_inner_cont_padding_top) ) {
						$col_inner_cont_paddings .= ' --b-col-inner-cont-space-top-mt: ' . $col_inner_cont_padding_top . ';';
					}
					if( ! empty($col_inner_cont_padding_bottom) ) {
						$col_inner_cont_paddings .= ' --b-col-inner-cont-space-bottom-mt: ' . $col_inner_cont_padding_bottom . ';';
					}
					if( ! empty($col_inner_cont_padding_left) ) {
						$col_inner_cont_paddings .= ' --b-col-inner-cont-space-left-mt: ' . $col_inner_cont_padding_left . ';';
					}
					if( ! empty($col_inner_cont_padding_right) ) {
						$col_inner_cont_paddings .= ' --b-col-inner-cont-space-right-mt: ' . $col_inner_cont_padding_right . ';';
					}
				}
			}
		}
	}
	$col_in_style .= $col_inner_cont_paddings;
	
	if ( ! empty( $col_inner_cont_padding) ) {
		$col_in_class .=  ' ' . $col_inner_cont_padding['value'];
	}
}

?>

<div <?php echo $anchor; ?> class="<?php echo $class ?>" <?php if ( $custom_padding ) echo 'style="' . $paddings . '"'; ?>>
<?php get_template_part('components/background'); ?>
	<div class="<?php echo $col_in_class ?>" <?php if ( ! empty(get_field('inner_columns_container_spacing_group')) || ! empty($inner_columns_container_max_width) ) { echo $col_in_style . '"'; } ?>>
	<!-- Inner Section Background -->
	<?php if ( have_rows('columns_container_background_group')) {
		while (have_rows('columns_container_background_group')) {
			the_row();
			get_template_part('components/columns-container-background');
		}
	}
	?>
		<?php get_template_part('components/intro');
        ?>
        <div class="il_gallery_inner <?php if($open_images_in_lightbox) { echo 'images-lightbox'; } ?>">
        <?php
            // Columns repeater
            if( have_rows('columns_block') ):

                while( have_rows('columns_block') ) : the_row();

                $image = get_sub_field('image');
				$url = $image['url'];
				$title = $image['title'];
				$alt = $image['alt'];
				$caption = $image['caption'];
                $name = get_sub_field('name');
                $position = get_sub_field('position');
				
				?>
                <div class="il_col column">
					<?php if($open_images_in_lightbox) { ?>
						<img src="<?php echo esc_url($url); ?>" data-fancybox="il_gallery" title="<?php echo esc_attr($title); ?>"  data-fancybox data-caption="<?php echo esc_attr($caption); ?>" alt="<?php echo esc_attr($alt); ?>">
					<?php }
						else { ?>
							<img src="<?php echo esc_url($url); ?>" alt="<?php echo esc_attr($alt); ?>" />
					<?php } ?>
					<?php if( $name || $position ) { ?>
						<div class="gallery-text-container">
							<?php if( $name ) { ?>
								<div class="gallery-text-container-name">
									<?php echo $name; ?>
								</div>
							<?php } ?>
							<?php if( $name ) { ?>
								<div class="gallery-text-container-position">
									<?php echo $position; ?>
								</div>
							<?php } ?>
						</div>
					<?php } ?>
                </div>
                <?php endwhile;
            endif; ?>
        </div>

		<?php if ( $prev_next_buttons_below_gallery ) { ?>
			<div class="prev-next-container">
				<img decoding="async" src="/wp-content/uploads/2023/10/Previous_bttn.png" class="carousel-previous-button"><br>
				<img decoding="async" src="/wp-content/uploads/2023/10/Next_bttn.png" class="carousel-next-button">
			</div>
		<?php } ?>
	</div>
</div>