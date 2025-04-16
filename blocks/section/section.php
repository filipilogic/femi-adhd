<?php
$style = get_field_object('choose_style');
$layout = get_field_object('layout');
$stack = get_field_object('stack');

$margin = get_field_object('margin');
$custom_padding = get_field('custom_padding');
$padding = get_field_object('padding');

$image_border_top_left_radius = get_field('image_border_top_left_radius');
$image_border_top_right_radius = get_field('image_border_top_right_radius');
$image_border_bottom_left_radius = get_field('image_border_bottom_left_radius');
$image_border_bottom_right_radius = get_field('image_border_bottom_right_radius');

$content_align = get_field('content_align');

$inner_section_max_width = get_field('inner_section_max_width');

$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
    $anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}

$class = 'il_block il_section';
$sec_in_style = 'style="';

if( ! empty($inner_section_max_width) ) {
	$sec_in_style .= '--custom-max-width-ld: ' . $inner_section_max_width . ';';
} else {
	$sec_in_style .= '--custom-max-width-ld: var(--site-width);';
}

if ( ! empty( $block['className'] ) ) {
    $class .= ' ' . $block['className'];
}
if ( ! empty( $style ) ) {
    $class .=  ' ' . $style['value'];
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
				$paddings .= ' --b-space-top-ld: ' . $padding_top . ';';
			}
			if( ! empty($padding_bottom) ) {
				$paddings .= ' --b-space-bottom-ld: ' . $padding_bottom . ';';
			}
			if( ! empty($padding_left) ) {
				$paddings .= ' --b-space-left-ld: ' . $padding_left . ';';
			}
			if( ! empty($padding_right) ) {
				$paddings .= ' --b-space-right-ld: ' . $padding_right . ';';
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
				$paddings .= ' --b-space-top-mt: ' . $padding_top . ';';
			}
			if( ! empty($padding_bottom) ) {
				$paddings .= ' --b-space-bottom-mt: ' . $padding_bottom . ';';
			}
			if( ! empty($padding_left) ) {
				$paddings .= ' --b-space-left-mt: ' . $padding_left . ';';
			}
			if( ! empty($padding_right) ) {
				$paddings .= ' --b-space-right-mt: ' . $padding_right . ';';
			}
		}
	}
}

$sec_in_class = 'il_section_inner container';
if ( ! empty( $layout ) ) {
    $sec_in_class .=  ' ' . $layout['value'];
}
if ( ! empty( $stack ) ) {
    $sec_in_class .=  ' ' . $stack['value'];
}
if ( ! empty( $content_align ) ) {
    $sec_in_class .=  ' ' . $content_align;
}

?>

<!-- Inner Section Spacing -->
<?php if ( have_rows('inner_section_spacing_group')) {
	while (have_rows('inner_section_spacing_group')) {
		the_row();
		$inner_sec_custom_padding = get_sub_field('custom_padding');
		$inner_sec_padding = get_sub_field_object('padding');
		$inner_sec_paddings = '';
		
		if( $inner_sec_custom_padding ) {
		
			if ( have_rows('custom_padding_ld')) {
				while (have_rows('custom_padding_ld')) {
					the_row();
					$inner_sec_padding_top = get_sub_field('padding_top');
					$inner_sec_padding_bottom = get_sub_field('padding_bottom');
					$inner_sec_padding_left = get_sub_field('padding_left');
					$inner_sec_padding_right = get_sub_field('padding_right');
		
					if( ! empty($inner_sec_padding_top) ) {
						$inner_sec_paddings .= ' --b-inner-sec-space-top-ld: ' . $inner_sec_padding_top . ';';
					}
					if( ! empty($inner_sec_padding_bottom) ) {
						$inner_sec_paddings .= ' --b-inner-sec-space-bottom-ld: ' . $inner_sec_padding_bottom . ';';
					}
					if( ! empty($inner_sec_padding_left) ) {
						$inner_sec_paddings .= ' --b-inner-sec-space-left-ld: ' . $inner_sec_padding_left . ';';
					}
					if( ! empty($inner_sec_padding_right) ) {
						$inner_sec_paddings .= ' --b-inner-sec-space-right-ld: ' . $inner_sec_padding_right . ';';
					}
				}
			}
			if ( have_rows('custom_padding_mt')) {
				while (have_rows('custom_padding_mt')) {
					the_row();
					$inner_sec_padding_top = get_sub_field('padding_top');
					$inner_sec_padding_bottom = get_sub_field('padding_bottom');
					$inner_sec_padding_left = get_sub_field('padding_left');
					$inner_sec_padding_right = get_sub_field('padding_right');
		
					if( ! empty($inner_sec_padding_top) ) {
						$inner_sec_paddings .= ' --b-inner-sec-space-top-mt: ' . $inner_sec_padding_top . ';';
					}
					if( ! empty($inner_sec_padding_bottom) ) {
						$inner_sec_paddings .= ' --b-inner-sec-space-bottom-mt: ' . $inner_sec_padding_bottom . ';';
					}
					if( ! empty($inner_sec_padding_left) ) {
						$inner_sec_paddings .= ' --b-inner-sec-space-left-mt: ' . $inner_sec_padding_left . ';';
					}
					if( ! empty($inner_sec_padding_right) ) {
						$inner_sec_paddings .= ' --b-inner-sec-space-right-mt: ' . $inner_sec_padding_right . ';';
					}
				}
			}
		}
	}
	$sec_in_style .= $inner_sec_paddings;
	
	if ( ! empty( $inner_sec_padding) ) {
		$sec_in_class .=  ' ' . $inner_sec_padding['value'];
	}
}

?>

<div <?php echo $anchor; ?> class="<?php echo $class; ?>" <?php if ( $custom_padding ) echo 'style="' . $paddings . '"'; ?>>
<?php get_template_part('components/background'); ?>
<div class="<?php echo $sec_in_class ?>" <?php if ( ! empty(get_field('inner_section_spacing_group')) || ! empty($inner_section_max_width) ) { echo $sec_in_style . '"'; } ?>>
<!-- Inner Section Background -->
<?php if ( have_rows('inner_section_background_group')) {
	while (have_rows('inner_section_background_group')) {
		the_row();
		get_template_part('components/inner-section-background');
	}
}
?>
<?php get_template_part('components/intro'); ?>
	<?php
	$image = get_field('media');
	$image_mobile = get_field('media_mobile');
	$size = 'full';
	if ( $image || $image_mobile ) {
		$width_ld_sec_img = get_field('width_ld_sec_img');
		if( !$width_ld_sec_img && $image ) {
			$width_ld_sec_img = $image['width'] / 10 . 'rem';
		}
		$height_ld_sec_img = get_field('height_ld_sec_img');
		if( !$height_ld_sec_img && $image ) {
			$height_ld_sec_img = $image['height'] / 10 . 'rem';
		}
		$left_ld_sec_img = get_field('left_ld_sec_img');
		$right_ld_sec_img = get_field('right_ld_sec_img');
		$top_ld_sec_img = get_field('top_ld_sec_img');
		$bottom_ld_sec_img = get_field('bottom_ld_sec_img');
		
		$width_mt_sec_img = get_field('width_mt_sec_img');
		if( !$width_mt_sec_img ) {
			if ( $image_mobile ) {
				$width_mt_sec_img = $image_mobile['width'] / 10 . 'rem';
			}
			if ( !$image_mobile && $image ) {
				$width_mt_sec_img = $image['width'] / 10 . 'rem';
			}
		}
		$height_mt_sec_img = get_field('height_mt_sec_img');
		if( !$height_mt_sec_img ) {
			if ( $image_mobile ) {
				$height_mt_sec_img = $image_mobile['height'] / 10 . 'rem';
			}
			if ( !$image_mobile && $image ) {
				$height_mt_sec_img = $image['height'] / 10 . 'rem';
			}
		}
		$left_mt_sec_img = get_field('left_mt_sec_img');
		$right_mt_sec_img = get_field('right_mt_sec_img');
		$top_mt_sec_img = get_field('top_mt_sec_img');
		$bottom_mt_sec_img = get_field('bottom_mt_sec_img');
		$img_style = '--bg-e-width-lg: ' . $width_ld_sec_img . '; --bg-e-height-lg: ' . $height_ld_sec_img . '; --bg-e-left-lg: ' . $left_ld_sec_img . '; --bg-e-right-lg: ' . $right_ld_sec_img . '; --bg-e-top-lg: ' . $top_ld_sec_img . '; --bg-e-bottom-lg: ' . $bottom_ld_sec_img . '; --bg-e-width-mt: ' . $width_mt_sec_img . '; --bg-e-height-mt: ' . $height_mt_sec_img . '; --bg-e-left-mt: ' . $left_mt_sec_img . '; --bg-e-right-mt: ' . $right_mt_sec_img . '; --bg-e-top-mt: ' . $top_mt_sec_img . '; --bg-e-bottom-mt: ' . $bottom_mt_sec_img . '; border-top-left-radius: ' . $image_border_top_left_radius . 'px; border-top-right-radius: ' . $image_border_top_right_radius . 'px; border-bottom-left-radius: ' . $image_border_bottom_left_radius . 'px; border-bottom-right-radius: ' . $image_border_bottom_right_radius . 'px;';
		
		$image_opens_in_lightbox = get_field('image_opens_in_lightbox');
		?>
		<div class="right">
			<?php
				if ( $image ) {
					$img_class = 'sec_desk_img';
					if( $image_mobile ) {
						$img_class .= ' hide_sec_desk_img_mob';
					}
					if ($image_opens_in_lightbox) {
						$img_atts = [ 'class' => $img_class, 'style' => $img_style, 'data-fancybox' => 'image-single', 'rel' => 'lightbox'];
					} else {
						$img_atts = [ 'class' => $img_class, 'style' => $img_style];
					}
					echo wp_get_attachment_image( $image['id'], $size, false, $img_atts );
				}
				if ( $image_mobile ) {
					if ($image_opens_in_lightbox) {
						$img_atts_mobile = [ 'class' => 'sec_mob_img', 'style' => $img_style, 'data-fancybox' => 'image-single', 'rel' => 'lightbox'];
					} else {
						$img_atts_mobile = [ 'class' => 'sec_mob_img', 'style' => $img_style];
					}
					echo wp_get_attachment_image( $image_mobile['id'], $size, false, $img_atts_mobile );
				}
			?>
		</div>
	<?php } ?>

</div>
</div>
