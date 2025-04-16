<?php

$subtitle = get_field('subtitle');
$subtitle_font_size = get_field('subtitle_font_size');
$subtitle_font_weight = get_field('subtitle_font_weight');
$subtitle_color = get_field('subtitle_color');
$subtitle_custom_color = get_field('subtitle_custom_color');
$subtitle_font_size_ld = get_field('subtitle_font_size_ld');
$subtitle_font_size_mt = get_field('subtitle_font_size_mt');
$subtitle_margin_bottom_ld = get_field('subtitle_margin_bottom_ld');
$subtitle_margin_bottom_mt = get_field('subtitle_margin_bottom_mt');
$class = 'intro_subtitle ' . $subtitle_color . ' ' . $subtitle_font_size . ' ' . $subtitle_font_weight;

$subtitle_style = 'style="';

if ( ! empty($subtitle_custom_color) ) {
    $subtitle_style .= 'color: ' . $subtitle_custom_color . ';';
}
if ( ! empty($subtitle_font_size_ld) ) {
    $subtitle_style .= '--' . $subtitle_font_size . '-ld: ' . $subtitle_font_size_ld . ';';
}
if ( ! empty($subtitle_font_size_mt) ) {
    $subtitle_style .= '--' . $subtitle_font_size . '-mt: ' . $subtitle_font_size_mt . ';';
}
if ( ! empty($subtitle_margin_bottom_ld) ) {
    $subtitle_style .= '--subtitle_margin_bottom_ld: ' . $subtitle_margin_bottom_ld . ';';
}
if ( ! empty($subtitle_margin_bottom_mt) ) {
    $subtitle_style .= '--subtitle_margin_bottom_mt: ' . $subtitle_margin_bottom_mt . ';';
}

$subtitle_style .= '"';

if( $subtitle ) { ?>
<div class="<?php echo $class; ?>" <?php if ( ! empty($subtitle_custom_color) || ! empty($subtitle_font_size_ld) || ! empty($subtitle_font_size_mt) || ! empty($subtitle_margin_bottom_ld) || ! empty($subtitle_margin_bottom_mt) ) { echo $subtitle_style; } ?>><?php echo $subtitle; ?></div>
<?php } else { ?>
    <div class="<?php echo $class; ?>" <?php if ( ! empty($subtitle_custom_color) || ! empty($subtitle_font_size_ld) || ! empty($subtitle_font_size_mt) || ! empty($subtitle_margin_bottom_ld) || ! empty($subtitle_margin_bottom_mt) ) { echo $subtitle_style; } ?>><?php echo get_the_excerpt(); ?></div>
<?php } ?>