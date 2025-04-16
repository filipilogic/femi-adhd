<?php 
$margin = get_field_object('margin');
$custom_padding = get_field('custom_padding');
$padding = get_field_object('padding');

$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
    $anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}

$class = 'il_block il-countdown';

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
				$paddings .= ' --b-countdown-top-ld: ' . $padding_top . ';';
			}
			if( ! empty($padding_bottom) ) {
				$paddings .= ' --b-countdown-bottom-ld: ' . $padding_bottom . ';';
			}
			if( ! empty($padding_left) ) {
				$paddings .= ' --b-countdown-left-ld: ' . $padding_left . ';';
			}
			if( ! empty($padding_right) ) {
				$paddings .= ' --b-countdown-right-ld: ' . $padding_right . ';';
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
				$paddings .= ' --b-countdown-top-mt: ' . $padding_top . ';';
			}
			if( ! empty($padding_bottom) ) {
				$paddings .= ' --b-countdown-bottom-mt: ' . $padding_bottom . ';';
			}
			if( ! empty($padding_left) ) {
				$paddings .= ' --b-countdown-left-mt: ' . $padding_left . ';';
			}
			if( ! empty($padding_right) ) {
				$paddings .= ' --b-countdown-right-mt: ' . $padding_right . ';';
			}
		}
	}
}

$countdown_end_date = strval(get_field('countdown_end_date'));

$text_after_countdown = get_field('text_after_countdown');

if ( $countdown_end_date ) { ?>

<div <?php echo $anchor; ?> class="<?php echo $class; ?>" <?php if ( $custom_padding ) echo 'style="' . $paddings . '"'; ?>>
    <?php get_template_part('components/background'); ?>
    <div class="container">
    <?php get_template_part('components/intro'); ?>
        <div class="il-countdown-ticker" id="countdown" date="<?php echo $countdown_end_date; ?>">
            <div class="countdown-box">
                <div class="countdown-value" id="days-value"></div>
                <div class="countdown-label">days</div>
            </div>
            <div class="countdown-box">
                <div class="countdown-value" id="hours-value"></div>
                <div class="countdown-label">hours</div>
            </div>
            <div class="countdown-box">
                <div class="countdown-value" id="minutes-value"></div>
                <div class="countdown-label">min</div>
            </div>
            <div class="countdown-box">
                <div class="countdown-value" id="seconds-value"></div>
                <div class="countdown-label">sec</div>
            </div>
        </div>
        <?php if (! empty($text_after_countdown) ) { ?>
            <div class="text-after-countdown">
                <?php echo $text_after_countdown; ?>
            </div>
        <?php } ?>
    </div>
</div>

<?php } ?>
