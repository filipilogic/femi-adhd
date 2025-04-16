<?php
if ( have_rows('images') ) :

$margin = get_field_object('margin');
$padding = get_field_object('padding');
$blue_gradient = get_field('blue_gradient');

$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
    $anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}

$class = 'il_block il_mini-gallery';
if ( ! empty( $block['className'] ) ) {
    $class .= ' ' . $block['className'];
}
if ( $blue_gradient ) {
    $class .= ' ' . 'has-blue-gradient';
}
if ( ! empty( $margin ) ) {
    $class .=  ' ' . $margin['value'];
}

if ( ! empty( $padding ) ) {
    $class .=  ' ' . $padding['value'];
}


 ?>
<div <?php echo $anchor; ?> class="<?php echo $class ?>">
<?php get_template_part('components/background'); ?>
	<div class="container">
		<?php get_template_part('components/intro'); ?>
		<div class="il_mini-gallery_inner">
			<?php while( have_rows('images') ) : the_row();
				$image = get_sub_field('image');

				$url = $image['url'];
				$title = $image['title'];
				$alt = $image['alt'];
				$caption = $image['caption']; ?>
				<div class="column">
					<figure class="il_mini-gallery-image">
						<img src="<?php echo esc_url($url); ?>" alt="<?php echo esc_attr($alt); ?>" data-fancybox='gallery' rel="lightbox" />
					</figure>
				</div>
			<?php endwhile; ?>
		</div>
	</div>
</div>
<?php endif; ?>
