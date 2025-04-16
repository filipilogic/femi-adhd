<?php
$subtitle = get_field('subtitle');
$content = get_field('content');
$height = get_field_object('height');
$margin = get_field_object('margin');
$padding = get_field_object('padding');

$class = 'il_block il_hero_slidein';
if ( ! empty( $block['className'] ) ) {
    $class .= ' ' . $block['className'];
}
if ( ! empty( $height ) ) {
    $class .=  ' ' . $height['value'];
}

if ( ! empty( $margin ) ) {
    $class .=  ' ' . $margin['value'];
}

if ( ! empty( $padding) ) {
    $class .=  ' ' . $padding['value'];
}
?>

<div class="<?php echo $class; ?>">
	<div class="il_hero_inner_wrap">
	<div class="il_block_bg">
		<video autoplay muted loop id="myVideo">
			<source src="<?php the_field('background_video'); ?>" type="video/mp4">
		</video>
	</div>
		<div class="container il_hero_inner">
		<?php get_template_part('components/title'); ?>
		<h2 class="il_hero_subtitle"><?php echo $subtitle ?></h2>
		<?php get_template_part('components/buttons'); ?>
		</div>
	</div>
	<div class="si_container">
		<div class="si_container_inner">
			<div class="si_triggers">
			<div class="il_block_bg">
			<?php
				$trigger_background = get_field('trigger_background');
				$size = 'full';
				if( $trigger_background ) {
					echo wp_get_attachment_image( $trigger_background, $size );
				} ?>
			</div>
			<div class="container">
			<?php
				// Check rows existexists.
				if( have_rows('slide_in_trigger') ):
					$item=1;
					// Loop through rows.
					while( have_rows('slide_in_trigger') ) : the_row();

						// Load sub field value.
						$trigger_text = get_sub_field('trigger_text'); ?>
						<div class="trigger-wrap">
							<a data-index="<?php echo $item; ?>" class="si_trigger si-<?php echo $item; ?>"><span class="si_tt"><?php echo $trigger_text; ?></span><span class="si_ti"></span></a>
							<a class="close-trigger"></a>
						</div>
						<?php $item++;?>
						<?php endwhile;
				endif; ?>
				</div>
			</div>

				<?php
					// Check rows existexists.
					if( have_rows('hero_slide_in') ):
						$item2=1;
						// Loop through rows. ?>

						<?php while( have_rows('hero_slide_in') ) : the_row();
						$si_title = get_sub_field('si_title');
						?>
							<a data-index="<?php echo $item2;?>" class="mobile_trigger si_trigger si-<?php echo $item2; ?>"><span class="si_tt"><?php echo $si_title; ?></span><span class="si_ti"></span></a>
						<div data-index="<?php echo $item2; ?>" class="il_slidein block_space_1 si-<?php echo $item2; ?>">
						<?php $si_title = get_sub_field('si_title');
						$si_content = get_sub_field('si_content');
						$si_bg = get_sub_field('si_bg');
						$si_bg_mob = get_sub_field('si_bg_mob');
						$size = 'full';
						 ?>
						<div class="si_bg il_block_bg">
						<?php if( $si_bg ) {
							echo wp_get_attachment_image( $si_bg, $size, "",array( 'class' => 'desk_bg' ) );
						} ?>
						<?php if( $si_bg_mob ) {
							echo wp_get_attachment_image( $si_bg_mob, $size, "",array( 'class' => 'mob_bg' ) );
						} ?>
						</div>
						<div class="si_inner container">
							<span class="si_close">x</span>
							<div class="si_content">
								<h2 class="si_title"><?php echo $si_title; ?></h2>
								<div class="si_text"><?php echo $si_content; ?></div>
								<?php get_template_part('components/buttons'); ?>
							</div>
						</div>
						<?php $item2++; ?>
					</div>
					<?php endwhile; ?>

				<?php endif; ?>

		</div>
	</div>
</div>
