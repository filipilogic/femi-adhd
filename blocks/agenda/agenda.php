<?php

if ( have_rows('agenda') ) :

$margin = get_field_object('margin');
$custom_padding = get_field('custom_padding');
$padding = get_field_object('padding');

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
				$paddings .= ' --b-agenda-space-top-ld: ' . $padding_top . ';';
			}
			if( ! empty($padding_bottom) ) {
				$paddings .= ' --b-agenda-space-bottom-ld: ' . $padding_bottom . ';';
			}
			if( ! empty($padding_left) ) {
				$paddings .= ' --b-agenda-space-left-ld: ' . $padding_left . ';';
			}
			if( ! empty($padding_right) ) {
				$paddings .= ' --b-agenda-space-right-ld: ' . $padding_right . ';';
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
				$paddings .= ' --b-agenda-space-top-mt: ' . $padding_top . ';';
			}
			if( ! empty($padding_bottom) ) {
				$paddings .= ' --b-agenda-space-bottom-mt: ' . $padding_bottom . ';';
			}
			if( ! empty($padding_left) ) {
				$paddings .= ' --b-agenda-space-left-mt: ' . $padding_left . ';';
			}
			if( ! empty($padding_right) ) {
				$paddings .= ' --b-agenda-space-right-mt: ' . $padding_right . ';';
			}
		}
	}
}

$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
    $anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}

$class = 'il_block il_agenda ';
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
<div <?php echo $anchor; ?> class="<?php echo $class ?>" <?php if ( $custom_padding ) echo 'style="' . $paddings . '"'; ?>>
<?php get_template_part('components/background'); ?>
	<div class="container">
	<!-- Inner Section Background -->
	<?php if ( have_rows('inner_section_background_group')) {
		while (have_rows('inner_section_background_group')) {
			the_row();
			get_template_part('components/inner-section-background');
		}
	}
		$content_title = get_field('content_title');
		$content_text = get_field('content_text');
		?>
		<div class="il_agenda_wrap">
				<div class="il_agenda_wrap_inner_top">
					<?php if ( $content_title ) { ?>
						<h3 class="agenda_content_title"><?php echo $content_title; ?></h3>
					<?php } ?>
					<?php if ( $content_text ) { ?>
						<div class="agenda_content_text"><?php echo $content_text; ?></div>
					<?php } ?>
				</div>
				<div id="hp-lecturers" class="il_agenda_wrap_inner_bottom">
				<?php while( have_rows('agenda') ) : the_row();

						$agenda_time = get_sub_field('agenda_time');
						$agenda_title = get_sub_field('agenda_title');
						$speaker_name = get_sub_field('speaker_name');
						$speaker_title = get_sub_field('speaker_title');
						$agenda_content = get_sub_field('agenda_content');
						$speaker_image = get_sub_field('speaker_image');
						$size = 'full';
						 ?>

						<div class="il_agenda_content">
							<div class="il_ac_speaker_image">
								<?php echo wp_get_attachment_image( $speaker_image, $size, false ); ?>
							</div>
							<div class="il_ac_content_container">
								<div class="il_ac_content_container_top">
									<div class="il_ac_content_container_top_left">
										<?php if ( $speaker_name ) { ?>
											<div class="il_ac_speaker_name">
												<?php echo $speaker_name; ?>
											</div>
										<?php } ?>
										<?php if ( $speaker_title ) { ?>
											<div class="il_ac_speaker_title">
												<?php echo $speaker_title; ?>
											</div>
										<?php } ?>
									</div>
									<div class="il_ac_content_container_top_right">
										<?php if ( $agenda_time ) { ?>
											<div class="il_ac_agenda_time">
												<?php echo $agenda_time; ?>
											</div>
										<?php } ?>
										<?php if ( $agenda_title ) { ?>
											<div class="il_ac_agenda_title">
												<?php echo $agenda_title; ?>
											</div>
										<?php } ?>
									</div>
								</div>
								<div class="il_ac_content_container_bottom">
									<?php if ( $agenda_content ) { ?>
										<div class="il_ac_agenda_content">
											<?php echo $agenda_content; ?>
										</div>
									<?php } ?>
								</div>
							</div>
						</div>
				<?php endwhile; ?>
				</div>
				<?php get_template_part('components/intro'); ?>
		</div>
	</div>
</div>
<?php endif; ?>
