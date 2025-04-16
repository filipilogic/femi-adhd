<?php
$link_url = get_field('link_url');

$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
    $anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}

$class = 'il_block il_contact-us';

?>


<div <?php echo $anchor; ?> class="<?php echo $class ?>">
	<a href="<?php echo esc_html($link_url); ?>">
		<?php get_template_part('components/background'); ?>
		<div class="il_contact-us_inner container">
			<div class="il_contact-us_content">
				<?php get_template_part('components/title'); ?>
			</div>
		</div>
	</a>
</div>