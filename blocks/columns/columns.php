<?php
$cols = get_field_object('columns');
$tab_cols = get_field_object('tab_columns');
$mob_cols = get_field_object('mob_columns');

$margin = get_field_object('margin');
$custom_padding = get_field('custom_padding');
$padding = get_field_object('padding');

$inner_columns_container_max_width = get_field('inner_columns_container_max_width');

$slider_on_mobile_and_tablet = get_field('slider_on_mobile_and_tablet');

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

$class = 'il_block il_columns';
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

$col_in_class = 'il_columns_container container';

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

<div <?php echo $anchor; ?> class="<?php echo $class; ?>" <?php if ( $custom_padding ) echo 'style="' . $paddings . '"'; ?>>
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
        $column_alignment = get_field('column_alignment');
        $text_color = get_field('text_color');
        $text_font_weight = get_field('text_font_weight');
        $inner_class = $column_alignment . ' ' . $text_color . ' ' . $text_font_weight;
        ?>
        <div class="il_columns_inner <?php echo $inner_class; ?>">
        <?php
            // Columns repeater
            if( have_rows('columns_block') ):

                while( have_rows('columns_block') ) : the_row();

                $text = get_sub_field('text');
                $image = get_sub_field('image');
                $size = 'full';

                // Title ?>
                <div class="il_col column">
                    <?php if( $image ) {
                        echo wp_get_attachment_image( $image, $size );
                    }
                    get_template_part('components/nested-before-title');
                    get_template_part('components/nested-title');

                    ?>

					<?php if ($text) { ?>
						<div class="il_col_text">
							<?php echo $text; ?>
						</div>
					<?php } ?>
                    <?php get_template_part('components/buttons'); ?>
                </div>
                <?php endwhile;
            endif; ?>
        </div>
	</div>
</div>