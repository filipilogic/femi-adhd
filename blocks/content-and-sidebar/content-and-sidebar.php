<?php
$margin = get_field_object('margin');
$custom_padding = get_field('custom_padding');
$padding = get_field_object('padding');

$post_content = get_field('post_content');
$show_excerpt = get_field('show_excerpt');

$class = 'il_block il_content-and-sidebar';
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
				$paddings .= ' --b-il_content-and-sidebar-space-top-ld: ' . $padding_top . ';';
			}
			if( ! empty($padding_bottom) ) {
				$paddings .= ' --b-il_content-and-sidebar-space-bottom-ld: ' . $padding_bottom . ';';
			}
			if( ! empty($padding_left) ) {
				$paddings .= ' --b-il_content-and-sidebar-space-left-ld: ' . $padding_left . ';';
			}
			if( ! empty($padding_right) ) {
				$paddings .= ' --b-il_content-and-sidebar-space-right-ld: ' . $padding_right . ';';
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
				$paddings .= ' --b-il_content-and-sidebar-space-top-mt: ' . $padding_top . ';';
			}
			if( ! empty($padding_bottom) ) {
				$paddings .= ' --b-il_content-and-sidebar-space-bottom-mt: ' . $padding_bottom . ';';
			}
			if( ! empty($padding_left) ) {
				$paddings .= ' --b-il_content-and-sidebar-space-left-mt: ' . $padding_left . ';';
			}
			if( ! empty($padding_right) ) {
				$paddings .= ' --b-il_content-and-sidebar-space-right-mt: ' . $padding_right . ';';
			}
		}
	}
}

?>

<div class="<?php echo $class; ?>" <?php if ( $custom_padding ) echo 'style="' . $paddings . '"'; ?>>
<?php get_template_part('components/background'); ?>
    <div class="container">
        <div class="cas-main-container-content">
            <?php get_template_part('components/post-title'); ?>
            <?php
			if ( $show_excerpt ) {
				get_template_part('components/post-excerpt');
			}
			?>
            <div class="entry-date"><?php echo get_the_date(); ?></div>
            <div class="social-share"><span>Share</span><?php echo il_social_share(); ?></div>
            <div class="post_content"><?php echo $post_content; ?></div>
        </div>
        <div class="cas-main-container-sidebar">
            <?php get_sidebar(); ?>
        </div>
    </div>
</div>
