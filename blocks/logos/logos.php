<?php
if ( have_rows('images') ) :

$learn_more = get_field('learn_more');

$cols = get_field_object('columns');
$tab_cols = get_field_object('tab_columns');
$mob_cols = get_field_object('mob_columns');

$margin = get_field_object('margin');
$custom_padding = get_field('custom_padding');
$padding = get_field_object('padding');

$style = get_field('style');


$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
    $anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}

$class = 'il_block il_logos';
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
				$paddings .= ' --b-logos-space-top-ld: ' . $padding_top . ';';
			}
			if( ! empty($padding_bottom) ) {
				$paddings .= ' --b-logos-space-bottom-ld: ' . $padding_bottom . ';';
			}
			if( ! empty($padding_left) ) {
				$paddings .= ' --b-logos-space-left-ld: ' . $padding_left . ';';
			}
			if( ! empty($padding_right) ) {
				$paddings .= ' --b-logos-space-right-ld: ' . $padding_right . ';';
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
				$paddings .= ' --b-logos-space-top-mt: ' . $padding_top . ';';
			}
			if( ! empty($padding_bottom) ) {
				$paddings .= ' --b-logos-space-bottom-mt: ' . $padding_bottom . ';';
			}
			if( ! empty($padding_left) ) {
				$paddings .= ' --b-logos-space-left-mt: ' . $padding_left . ';';
			}
			if( ! empty($padding_right) ) {
				$paddings .= ' --b-logos-space-right-mt: ' . $padding_right . ';';
			}
		}
	}
}

if ( ! empty( $style ) ) {
    $class .=  ' ' . $style;
}


 ?>
<div <?php echo $anchor; ?> class="<?php echo $class; ?>" <?php if ( $custom_padding ) echo 'style="' . $paddings . '"'; ?>>
<?php get_template_part('components/background'); ?>
	<div class="container">
		<?php get_template_part('components/intro'); ?>
		<div class="il_logos_inner">
			<?php while( have_rows('images') ) : the_row();
				$image = get_sub_field('image');

				$url = $image['url'];
				$title = $image['title'];
				$alt = $image['alt'];
				$caption = $image['caption']; ?>
				<div class="column">
					<figure class="il_logo">
						<img src="<?php echo esc_url($url); ?>" alt="<?php echo esc_attr($alt); ?>" />
					</figure>
				</div>
			<?php endwhile; ?>
		</div>
			<div class="column btn_column">
			<?php if( $learn_more ):
			$learn_more_url = $learn_more['url'];
			$learn_more_title = $learn_more['title'];
			$learn_more_target = $learn_more['target'] ? $learn_more['target'] : '_self';
			?>
			<a class="il_btn" href="<?php echo esc_url( $learn_more_url ); ?>" target="<?php echo esc_attr( $learn_more_target ); ?>"><span class="il_btn_text"><?php echo esc_html( $learn_more_title ); ?></span><span class="il_btn_icon"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="27.109" height="29.565" viewBox="0 0 27.109 29.565"><defs><clipPath id="a"><rect width="24.1" height="17.388" fill="#fec000"/></clipPath></defs><g transform="translate(12.05 29.565) rotate(-120)" style="isolation:isolate"><g transform="translate(0 0)" style="mix-blend-mode:multiply;isolation:isolate"><g clip-path="url(#a)"><path d="M23.773,11.863H9.918L3.069,0,0,5.316,6.97,17.388h13.94l3.19-5.525h-.326Z" transform="translate(0 0)" fill="#fec000"/></g></g></g></svg></span></a>
			<?php endif; ?>
			</div>
	</div>
</div>
<?php endif; ?>
