<?php

$title = get_field('inner_hero_title');
$subtitle = get_field('inner_hero_subtitle');

$class = 'il_inner_hero-1 il_block';
if ( ! empty( $block['className'] ) ) {
    $class .= ' ' . $block['className'];
}

?>
<div class="<?php echo $class; ?>">
<div class="il_inner_hero_bg">
<?php

if ( has_post_thumbnail() ) {
	the_post_thumbnail();
}
else {
	$bg = get_field('default_hero', 'option');
	$size = 'full';
	if( $bg ) {
		echo wp_get_attachment_image( $bg, $size );
	}
} ?>
</div>

	<div class="il_inner_hero_inner container">
		<h1 class="il_inner_hero_title">
		<?php if($title):
			echo $title;
		else:
			the_title();

		endif; ?>
		</h1>
		<div class="il_inner_hero_text">
			<?php echo $subtitle; ?>
		</div>
	</div>


</div>
