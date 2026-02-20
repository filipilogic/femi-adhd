<?php
$margin = get_field_object('margin');
$custom_padding = get_field('custom_padding');
$padding = get_field_object('padding');

$inner_container_max_width = get_field('inner_container_max_width');

$box_in_style = 'style="';
if ( ! empty( $inner_container_max_width ) ) {
	$box_in_style .= '--custom-max-width-ld: ' . esc_attr( $inner_container_max_width ) . ';';
} else {
	$box_in_style .= '--custom-max-width-ld: var(--site-width);';
}

$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
	$anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}

$class = 'il_block il_two-boxes';
if ( ! empty( $block['className'] ) ) {
	$class .= ' ' . esc_attr( $block['className'] );
}
if ( ! empty( $margin ) ) {
	$class .= ' ' . $margin['value'];
}
if ( ! empty( $padding ) ) {
	$class .= ' ' . $padding['value'];
}

$paddings = '';
if ( $custom_padding ) {
	if ( have_rows( 'custom_padding_ld' ) ) {
		while ( have_rows( 'custom_padding_ld' ) ) {
			the_row();
			$padding_top    = get_sub_field( 'padding_top' );
			$padding_bottom = get_sub_field( 'padding_bottom' );
			$padding_left   = get_sub_field( 'padding_left' );
			$padding_right  = get_sub_field( 'padding_right' );

			if ( ! empty( $padding_top ) ) {
				$paddings .= ' --b-two-boxes-space-top-ld: ' . $padding_top . ';';
			}
			if ( ! empty( $padding_bottom ) ) {
				$paddings .= ' --b-two-boxes-space-bottom-ld: ' . $padding_bottom . ';';
			}
			if ( ! empty( $padding_left ) ) {
				$paddings .= ' --b-two-boxes-space-left-ld: ' . $padding_left . ';';
			}
			if ( ! empty( $padding_right ) ) {
				$paddings .= ' --b-two-boxes-space-right-ld: ' . $padding_right . ';';
			}
		}
	}
	if ( have_rows( 'custom_padding_mt' ) ) {
		while ( have_rows( 'custom_padding_mt' ) ) {
			the_row();
			$padding_top    = get_sub_field( 'padding_top' );
			$padding_bottom = get_sub_field( 'padding_bottom' );
			$padding_left   = get_sub_field( 'padding_left' );
			$padding_right  = get_sub_field( 'padding_right' );

			if ( ! empty( $padding_top ) ) {
				$paddings .= ' --b-two-boxes-space-top-mt: ' . $padding_top . ';';
			}
			if ( ! empty( $padding_bottom ) ) {
				$paddings .= ' --b-two-boxes-space-bottom-mt: ' . $padding_bottom . ';';
			}
			if ( ! empty( $padding_left ) ) {
				$paddings .= ' --b-two-boxes-space-left-mt: ' . $padding_left . ';';
			}
			if ( ! empty( $padding_right ) ) {
				$paddings .= ' --b-two-boxes-space-right-mt: ' . $padding_right . ';';
			}
		}
	}
}

$column_alignment = get_field( 'column_alignment' );
$text_color       = get_field( 'text_color' );
$text_font_weight = get_field( 'text_font_weight' );
$inner_class      = ( $column_alignment ?: 'align-right' ) . ' ' . ( $text_color ?: 'text-theme-color' ) . ' ' . ( $text_font_weight ?: 'text-400' );
?>

<div <?php echo $anchor; ?> class="<?php echo esc_attr( $class ); ?>" <?php echo $custom_padding ? 'style="' . esc_attr( $paddings ) . '"' : ''; ?>>
	<?php get_template_part( 'components/background' ); ?>
	<div class="il_two-boxes_container container" <?php echo $box_in_style . '"'; ?>>
		<?php get_template_part( 'components/intro' ); ?>
		<div class="il_two-boxes_inner <?php echo esc_attr( $inner_class ); ?>">
			<?php
			if ( have_rows( 'boxes' ) ) :
				while ( have_rows( 'boxes' ) ) :
					the_row();
					$text  = get_sub_field( 'text' );
					$image = get_sub_field( 'image' );
					$size  = 'full';
					?>
					<div class="il_col column">
						<?php if ( $image ) { ?>
							<div class="il_col_image">
								<?php echo wp_get_attachment_image( $image, $size ); ?>
							</div>
						<?php } ?>
						<div class="il_col_content">
							<?php
							get_template_part( 'components/nested-before-title' );
							get_template_part( 'components/nested-title' );
							?>
							<?php if ( $text ) { ?>
								<div class="il_col_text">
									<?php echo $text; ?>
								</div>
							<?php } ?>
							<?php get_template_part( 'components/buttons' ); ?>
						</div>
					</div>
					<?php
				endwhile;
			endif;
			?>
		</div>
	</div>
</div>
