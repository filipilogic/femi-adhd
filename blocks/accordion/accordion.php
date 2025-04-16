<?php

if ( have_rows('accordion') ) :

	$margin = get_field_object('margin');
	$custom_padding = get_field('custom_padding');
	$padding = get_field_object('padding');

	$anchor = 'il_accordion';
	if ( ! empty( $block['anchor'] ) ) {
		$anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
	}
	$class = 'il_block il_accordion';
	if ( ! empty( $block['className'] ) ) {
		$class .= ' ' . $block['className'];
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
					$paddings .= ' --b-accordion-space-top-ld: ' . $padding_top . ';';
				}
				if( ! empty($padding_bottom) ) {
					$paddings .= ' --b-accordion-space-bottom-ld: ' . $padding_bottom . ';';
				}
				if( ! empty($padding_left) ) {
					$paddings .= ' --b-accordion-space-left-ld: ' . $padding_left . ';';
				}
				if( ! empty($padding_right) ) {
					$paddings .= ' --b-accordion-space-right-ld: ' . $padding_right . ';';
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
					$paddings .= ' --b-accordion-space-top-mt: ' . $padding_top . ';';
				}
				if( ! empty($padding_bottom) ) {
					$paddings .= ' --b-accordion-space-bottom-mt: ' . $padding_bottom . ';';
				}
				if( ! empty($padding_left) ) {
					$paddings .= ' --b-accordion-space-left-mt: ' . $padding_left . ';';
				}
				if( ! empty($padding_right) ) {
					$paddings .= ' --b-accordion-space-right-mt: ' . $padding_right . ';';
				}
			}
		}
	}

?>
<div id="<?php echo $anchor; ?>"class="<?php echo $class ?>" <?php if ( $custom_padding ) echo 'style="' . $paddings . '"'; ?>>
<?php get_template_part('components/background'); ?>
	<div class="il_accordion_inner container">
	<?php get_template_part('components/intro');

		$accordion_header_title_color = get_field('accordion_header_title_color');
		if ( empty($accordion_header_title_color) ) {
			$accordion_header_title_color = '#fff';
		}
		$accordion_body_color = get_field('accordion_body_color');
		if ( empty($accordion_body_color) ) {
			$accordion_body_color = '#fff';
		}

		$item=1;?>
		<?php while( have_rows('accordion') ) : the_row();

		$accordion_title = get_sub_field('title');
		$accordion_content = get_sub_field('content');
		$size = 'full';

		if($item == 1 && get_field('first_open') ){

			$open = 'open';
			$display = 'display: flex;';

			}else{
				$open = '';
				$display = 'display: none;';
			}
			?>
			<div class="il_accordion-item <?php echo $open ?>">
				<h3 class="il_accordion-header" style="color: <?php echo $accordion_header_title_color; ?>">
					<?php echo $accordion_title; ?>
				</h3>
				<div class="il_accordion-body" style="<?php echo $display; ?>">
					<div class="il_accordion-body-left" style="color: <?php echo $accordion_body_color; ?>">
					<?php echo $accordion_content; ?>
					</div>
				</div>
			</div>

		<?php $item++;?>
		<?php endwhile; ?>
		</div>
	</div>
<?php endif; ?>
