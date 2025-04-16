<?php

if ( have_rows('timeline') ) :

	$margin = get_field_object('margin');
	$custom_padding = get_field('custom_padding');
	$padding = get_field_object('padding');

	$type = get_field_object('type');
	$layout = get_field_object('layout');
	$anchor = '';
	if ( ! empty( $block['anchor'] ) ) {
		$anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
	}
	$class = 'il_block il_timeline';
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
					$paddings .= ' --b-timeline-space-top-ld: ' . $padding_top . ';';
				}
				if( ! empty($padding_bottom) ) {
					$paddings .= ' --b-timeline-space-bottom-ld: ' . $padding_bottom . ';';
				}
				if( ! empty($padding_left) ) {
					$paddings .= ' --b-timeline-space-left-ld: ' . $padding_left . ';';
				}
				if( ! empty($padding_right) ) {
					$paddings .= ' --b-timeline-space-right-ld: ' . $padding_right . ';';
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
					$paddings .= ' --b-timeline-space-top-mt: ' . $padding_top . ';';
				}
				if( ! empty($padding_bottom) ) {
					$paddings .= ' --b-timeline-space-bottom-mt: ' . $padding_bottom . ';';
				}
				if( ! empty($padding_left) ) {
					$paddings .= ' --b-timeline-space-left-mt: ' . $padding_left . ';';
				}
				if( ! empty($padding_right) ) {
					$paddings .= ' --b-timeline-space-right-mt: ' . $padding_right . ';';
				}
			}
		}
	}

	if ( ! empty( $type) ) {
		$class .=  ' ' . $type['value'];
	}
	if ( ! empty( $layout) ) {
		$class .=  ' ' . $layout['value'];
	}

?>
<div id="<?php echo $anchor; ?>"class="<?php echo $class ?>" <?php if ( $custom_padding ) echo 'style="' . $paddings . '"'; ?>>
<?php get_template_part('components/background'); ?>
	<div class="container">
		<?php get_template_part('components/intro'); ?>
	</div>
	<?php $item=1;?>
	<?php if ( $type['value'] == 'type-arrows' ) { ?>
		<div class="il_timeline_inner container">
		<?php
		$timeline_last_item = count( get_field('timeline') );
		while( have_rows('timeline') ) : the_row();

		$tl_title = get_sub_field('tl_title');
		$tl_text = get_sub_field('tl_text');
			?>
			<div class="il_tl_item">
				<div class="il_tl_empty">

				</div>
				<div class="il_tl_arrow">
				<svg xmlns="http://www.w3.org/2000/svg" width="52.688" height="54.608" viewBox="0 0 52.688 54.608">
					<path id="Path_1466" data-name="Path 1466" d="M10.476,0,0,18.144H20.877L31.353,36.289h.075L41.9,18.144,31.427,0Z" transform="translate(31.106) rotate(59)" fill="<?php the_field('arrow_color') ?>"/>
				</svg>
				<?php if ( $item == $timeline_last_item ) : ?>
					<svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 11 11" class="il_tl_dot"><circle id="Ellipse_6" data-name="Ellipse 6" cx="5.5" cy="5.5" r="5.5" fill="<?php the_field('arrow_color') ?>"/></svg>
				<?php endif; ?>
				</div>
				<div class="il_tl_content">
					<?php if($tl_title) { ?>
					<h3 class="il_tl_header">
						<?php echo $tl_title; ?>
					</h3>
					<?php } ?>
					<div class="il_tl_body">
						<?php echo $tl_text; ?>
					</div>
				</div>
			</div>
		<?php $item++;?>
		<?php endwhile; ?>
		<figure class="il_tl_dot_mobile"><svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 11 11"><circle id="Ellipse_6" data-name="Ellipse 6" cx="5.5" cy="5.5" r="5.5" fill="<?php the_field('arrow_color') ?>"/></svg></figure>
		</div>
	<?php } ?>

	<?php if ( $type['value'] == 'type-numbers' ) { ?>
		<div class="ag-timeline-block">
			<section class="ag-section">
				<div class="ag-format-container">
				<div class="js-timeline ag-timeline">
					<div class="js-timeline_line ag-timeline_line">
					<div class="js-timeline_line-progress ag-timeline_line-progress"></div>
					</div>
					<div class="ag-timeline_list">
						<?php
						$timeline_last_item = count( get_field('timeline') );
						while( have_rows('timeline') ) : the_row();

						$tl_title = get_sub_field('tl_title');
						$tl_text = get_sub_field('tl_text');
						?>
							<div class="js-timeline_item ag-timeline_item">
								<div class="ag-timeline-card_box">
								<div class="js-timeline-card_point-box ag-timeline-card_point-box">
									<div class="ag-timeline-card_point"><?php echo $item; ?></div>
								</div>
								</div>
								<div class="ag-timeline-card_item">
								<div class="ag-timeline-card_inner">
									<div class="ag-timeline-card_info">
									<div class="ag-timeline-card_title"><?php if($tl_title) { ?><?php echo $tl_title; ?><?php } ?></div>
									<div class="ag-timeline-card_desc"></div>
									</div>
								</div>
								<div class="ag-timeline-card_arrow"></div>
								</div>
							</div>
						<?php $item++;?>
						<?php endwhile; ?>
					</div>
				</div>
				</div>
			</section>
		</div>
	<?php } ?>
</div>
<?php endif; ?>
