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

$class = 'il_block il_section il_exec-dir-section';
$sec_in_style = 'style="';

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

<div class="<?php echo $class; ?>" <?php if ( $custom_padding ) echo 'style="' . $paddings . '"'; ?>>
<?php get_template_part('components/background'); ?>
<!-- Title Before Inner -->
<div class="container">
	<?php
		if ( have_rows('title_before_inner_group')) {
			while (have_rows('title_before_inner_group')) {
				the_row();
				get_template_part('components/executive-director-title');
			}
		}  
	?>
</div>
<div class="<?php echo $sec_in_class ?>" <?php if ( ! empty(get_field('inner_section_spacing_group')) ) { echo $sec_in_style . '"'; } ?>>
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
	$size = 'full';
	$img_style = [ 'style' => 'border-top-left-radius: ' . $image_border_top_left_radius . 'px; border-top-right-radius: ' . $image_border_top_right_radius . 'px; border-bottom-left-radius: ' . $image_border_bottom_left_radius . 'px; border-bottom-right-radius: ' . $image_border_bottom_right_radius . 'px;' ];
	if( $image ) {
		?> <div class="right">
		<?php echo wp_get_attachment_image( $image, $size, false, $img_style ); ?>
		</div>
	<?php } ?>

</div>
</div>
