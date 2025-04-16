<?php
$inner_sec_use_bg = get_sub_field('use_background');
$inner_sec_bg_color = get_sub_field('background_color');
$inner_sec_blue_gradient = get_sub_field('blue_gradient');
$inner_sec_bg_img = get_sub_field('background_image');
$inner_sec_bg_img_mob = get_sub_field('background_image_mob');
$inner_sec_size = 'full';

$inner_sec_border_top_left_radius = get_field('inner_section_border_top_left_radius');
$inner_sec_border_top_right_radius = get_field('inner_section_border_top_right_radius');
$inner_sec_border_bottom_left_radius = get_field('inner_section_border_bottom_left_radius');
$inner_sec_border_bottom_right_radius = get_field('inner_section_border_bottom_right_radius');

?>
<?php if($inner_sec_use_bg) { ?>
<div class="il_block_bg" style="<?= $inner_sec_blue_gradient ? 'background: linear-gradient(96deg, #053279 0%, #030B27 99.13%);' : 'background-color: ' . $inner_sec_bg_color . ';' ?> <?php echo 'border-top-left-radius: ' . $inner_sec_border_top_left_radius . 'px; border-top-right-radius: ' . $inner_sec_border_top_right_radius . 'px; border-bottom-left-radius: ' . $inner_sec_border_bottom_left_radius . 'px; border-bottom-right-radius: ' . $inner_sec_border_bottom_right_radius . 'px; '?>">

<?php
$inner_sec_bg_class = 'desk_bg';
if( $inner_sec_bg_img_mob ) {
    $inner_sec_bg_class .= ' hide_desk_bg_mob';
}
if( $inner_sec_bg_img ) {
    echo wp_get_attachment_image( $inner_sec_bg_img, $inner_sec_size, "",array( 'class' => $inner_sec_bg_class ) );
}
if( $inner_sec_bg_img_mob ) {
    echo wp_get_attachment_image( $inner_sec_bg_img_mob, $inner_sec_size, "",array( 'class' => 'mob_bg' ) );
}

while( have_rows('elements') ) : the_row();

$inner_sec_image = get_sub_field('element');
if ( $inner_sec_image ) {
    $inner_sec_width_ld = get_sub_field('width_ld');
    if( !$inner_sec_width_ld ) {
        $inner_sec_width_ld = $inner_sec_image['width'] / 10 . 'rem';
    }
    $inner_sec_height_ld = get_sub_field('height_ld');
    if( !$inner_sec_height_ld ) {
        $inner_sec_height_ld = $inner_sec_image['height'] / 10 . 'rem';
    }
    $inner_sec_left_ld = get_sub_field('left_ld');
    $inner_sec_right_ld = get_sub_field('right_ld');
    $inner_sec_top_ld = get_sub_field('top_ld');
    $inner_sec_bottom_ld = get_sub_field('bottom_ld');
    
    $inner_sec_width_mt = get_sub_field('width_mt');
    if( !$inner_sec_width_mt ) {
        $inner_sec_width_mt = $inner_sec_image['width'] / 20 . 'rem';
    }
    $inner_sec_height_mt = get_sub_field('height_mt');
    if( !$inner_sec_height_mt ) {
        $inner_sec_height_mt = $inner_sec_image['height'] / 20 . 'rem';
    }
    $inner_sec_left_mt = get_sub_field('left_mt');
    $inner_sec_right_mt = get_sub_field('right_mt');
    $inner_sec_top_mt = get_sub_field('top_mt');
    $inner_sec_bottom_mt = get_sub_field('bottom_mt');
    
    $inner_sec_bg_elem_style = '--bg-e-width-lg: ' . $inner_sec_width_ld . '; --bg-e-height-lg: ' . $inner_sec_height_ld . '; --bg-e-left-lg: ' . $inner_sec_left_ld . '; --bg-e-right-lg: ' . $inner_sec_right_ld . '; --bg-e-top-lg: ' . $inner_sec_top_ld . '; --bg-e-bottom-lg: ' . $inner_sec_bottom_ld . '; --bg-e-width-mt: ' . $inner_sec_width_mt . '; --bg-e-height-mt: ' . $inner_sec_height_mt . '; --bg-e-left-mt: ' . $inner_sec_left_mt . '; --bg-e-right-mt: ' . $inner_sec_right_mt . '; --bg-e-top-mt: ' . $inner_sec_top_mt . '; --bg-e-bottom-mt: ' . $inner_sec_bottom_mt;
    
    $inner_sec_hide_on_desktop = get_sub_field('hide_on_laptop_and_desktop');
    
    if( $inner_sec_hide_on_desktop ) {
        $inner_sec_display_desktop = 'none';
        $inner_sec_bg_elem_style  .= '; --bg-e-display-desktop: ' .  $inner_sec_display_desktop;
    }
    
    $inner_sec_show_on_mobile = get_sub_field('show_on_mobile_and_tablet');
    
    if( ! $inner_sec_show_on_mobile ) {
        $inner_sec_display_mobile = 'none';
        $inner_sec_bg_elem_style  .= '; --bg-e-display-mobile: ' .  $inner_sec_display_mobile;
    }
    
    $inner_sec_image_atts = [ 'class' => 'bg_element', 'style' => $inner_sec_bg_elem_style ];
    
    echo wp_get_attachment_image( $inner_sec_image['id'], $inner_sec_size, "", $inner_sec_image_atts );
}

endwhile;

?>

</div>
<?php } ?>