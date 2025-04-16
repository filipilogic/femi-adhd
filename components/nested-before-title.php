<?php

$before_title = get_sub_field('before_title');
$before_title_font_size = get_sub_field('before_title_font_size');
$before_title_font_weight = get_sub_field('before_title_font_weight');
$before_title_color = get_sub_field('before_title_color');
$before_title_custom_color = get_sub_field('before_title_custom_color');
$before_title_font_size_ld = get_sub_field('before_title_font_size_ld');
$before_title_font_size_mt = get_sub_field('before_title_font_size_mt');
$before_title_margin_bottom_ld = get_sub_field('before_title_margin_bottom_ld');
$before_title_margin_bottom_mt = get_sub_field('before_title_margin_bottom_mt');
$class = 'intro_before_title ' . $before_title_color . ' ' . $before_title_font_size . ' ' . $before_title_font_weight;

$before_title_style = 'style="';

if ( ! empty($before_title_custom_color) ) {
    $before_title_style .= 'color: ' . $before_title_custom_color . ';';
}
if ( ! empty($before_title_font_size_ld) ) {
    $before_title_style .= '--' . $before_title_font_size . '-ld: ' . $before_title_font_size_ld . ';';
}
if ( ! empty($before_title_font_size_mt) ) {
    $before_title_style .= '--' . $before_title_font_size . '-mt: ' . $before_title_font_size_mt . ';';
}
if ( ! empty($before_title_margin_bottom_ld) ) {
    $before_title_style .= '--before_title_margin_bottom_ld: ' . $before_title_margin_bottom_ld . ';';
}
if ( ! empty($before_title_margin_bottom_mt) ) {
    $before_title_style .= '--before_title_margin_bottom_mt: ' . $before_title_margin_bottom_mt . ';';
}

$before_title_style .= '"';

if( $before_title ) { ?>
<div class="<?php echo $class; ?>" <?php if ( ! empty($before_title_custom_color) || ! empty($before_title_font_size_ld) || ! empty($before_title_font_size_mt) || ! empty($before_title_margin_bottom_ld) || ! empty($before_title_margin_bottom_mt) ) { echo $before_title_style; } ?>><?php echo $before_title; ?></div>
<?php }