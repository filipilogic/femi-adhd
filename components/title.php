<?php

$title = get_field('title');
$tag = get_field('heading_tag');
$title_font_size = get_field('title_font_size');
$title_font_weight = get_field('title_font_weight');
$title_color = get_field('title_color');
$title_custom_color = get_field('title_custom_color');
$title_font_size_ld = get_field('title_font_size_ld');
$title_font_size_mt = get_field('title_font_size_mt');
$title_margin_bottom_ld = get_field('title_margin_bottom_ld');
$title_margin_bottom_mt = get_field('title_margin_bottom_mt');
$class = 'intro_title ' . $title_color . ' ' . $title_font_size . ' ' . $title_font_weight;

$title_style = 'style="';

if ( ! empty($title_custom_color) ) {
    $title_style .= 'color: ' . $title_custom_color . ';';
}
if ( ! empty($title_font_size_ld) ) {
    $title_style .= '--' . $title_font_size . '-ld: ' . $title_font_size_ld . ';';
}
if ( ! empty($title_font_size_mt) ) {
    $title_style .= '--' . $title_font_size . '-mt: ' . $title_font_size_mt . ';';
}
if ( ! empty($title_margin_bottom_ld) ) {
    $title_style .= '--title_margin_bottom_ld: ' . $title_margin_bottom_ld . ';';
}
if ( ! empty($title_margin_bottom_mt) ) {
    $title_style .= '--title_margin_bottom_mt: ' . $title_margin_bottom_mt . ';';
}

$title_style .= '"';

if( $title ) { ?>
<<?php echo esc_html($tag); ?> class="<?php echo $class; ?>" <?php if ( ! empty($title_custom_color) || ! empty($title_font_size_ld) || ! empty($title_font_size_mt) || ! empty($title_margin_bottom_ld) || ! empty($title_margin_bottom_mt) ) { echo $title_style; } ?>><?php echo $title; ?></<?php echo esc_html($tag); ?>>
<?php } ?>