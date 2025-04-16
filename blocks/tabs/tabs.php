<?php
if ( have_rows('tabs') ) :

$cols = get_field_object('columns');
$tab_cols = get_field_object('tab_columns');
$mob_cols = get_field_object('mob_columns');

$margin = get_field_object('margin');
$padding = get_field_object('padding');


$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
    $anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}

$class = 'il_block il_tabs';
if ( ! empty( $block['className'] ) ) {
    $class .= ' ' . $block['className'];
}
if( get_field('stack_tabs') ) {
    $class .= ' ' . 'stack_tabs';
}
if ( ! empty( $margin ) ) {
    $class .=  ' ' . $margin['value'];
}

if ( ! empty( $padding) ) {
    $class .=  ' ' . $padding['value'];
}

 ?>
<div <?php echo $anchor; ?> class="<?php echo $class ?>">
<?php get_template_part('components/background'); ?>
<div class="container">
	<?php get_template_part('components/intro'); ?>
	<?php $item=1; ?>
		<header class="il_tabs_nav">
			<ul>
		<?php while( have_rows('tabs') ) : the_row();
			$title = get_sub_field('tab_title');
		?>
			<li><a data-tab = "<?php echo $item; ?>" href="#"><?php echo $title; ?></a></li>
			<?php $item++;?>
		<?php endwhile; ?>
		</ul>
		</header>
		<section class="il_tabs_content">
			<?php $item=1; ?>
			<?php while( have_rows('tabs') ) : the_row();
				$title = get_sub_field('tab_title');
				$content = get_sub_field('tab_content');

				?>
				<div data-tab="<?php echo $item; ?>" class="il_tab">
				<?php if( get_field('tab_title') ) { ?>
				<h3><?php echo $title; ?></h3>
				<?php } ?>
					<div class="il_tab_text"><?php echo $content ?></div>
				</div>
			<?php $item++;?>
			<?php endwhile; ?>
		</section>
	</div>
</div>
<?php endif; ?>
