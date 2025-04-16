<?php
$col_cont_use_bg = get_sub_field('use_background');
$col_cont_bg_color = get_sub_field('background_color');
$col_cont_blue_gradient = get_sub_field('blue_gradient');
$col_cont_bg_img = get_sub_field('background_image');
$col_cont_bg_img_mob = get_sub_field('background_image_mob');
$col_cont_size = 'full';

$col_cont_border_top_left_radius = get_field('col_cont_border_top_left_radius');
$col_cont_border_top_right_radius = get_field('col_cont_border_top_right_radius');
$col_cont_border_bottom_left_radius = get_field('col_cont_border_bottom_left_radius');
$col_cont_border_bottom_right_radius = get_field('col_cont_border_bottom_right_radius');

?>
<?php if($col_cont_use_bg) { ?>
<div class="il_block_bg" style="<?= $col_cont_blue_gradient ? 'background: radial-gradient(50% 50.00% at 50% 50.00%, #144A9D 0%, #132051 100%);' : 'background-color: ' . $col_cont_bg_color . ';' ?> <?php echo 'border-top-left-radius: ' . $col_cont_border_top_left_radius . 'px; border-top-right-radius: ' . $col_cont_border_top_right_radius . 'px; border-bottom-left-radius: ' . $col_cont_border_bottom_left_radius . 'px; border-bottom-right-radius: ' . $col_cont_border_bottom_right_radius . 'px; '?>">

<?php
$col_cont_bg_class = 'desk_bg';
if( $col_cont_bg_img_mob ) {
    $col_cont_bg_class .= ' hide_desk_bg_mob';
}
if( $col_cont_bg_img ) {
    echo wp_get_attachment_image( $col_cont_bg_img, $col_cont_size, "",array( 'class' => $col_cont_bg_class ) );
}
if( $col_cont_bg_img_mob ) {
    echo wp_get_attachment_image( $col_cont_bg_img_mob, $col_cont_size, "",array( 'class' => 'mob_bg' ) );
}

while( have_rows('elements') ) : the_row();

$col_cont_image = get_sub_field('element');
if ( $col_cont_image ) {
    $col_cont_width_ld = get_sub_field('width_ld');
    if( !$col_cont_width_ld ) {
        $col_cont_width_ld = $col_cont_image['width'] / 10 . 'rem';
    }
    $col_cont_height_ld = get_sub_field('height_ld');
    if( !$col_cont_height_ld ) {
        $col_cont_height_ld = $col_cont_image['height'] / 10 . 'rem';
    }
    $col_cont_left_ld = get_sub_field('left_ld');
    $col_cont_right_ld = get_sub_field('right_ld');
    $col_cont_top_ld = get_sub_field('top_ld');
    $col_cont_bottom_ld = get_sub_field('bottom_ld');
    
    $col_cont_width_mt = get_sub_field('width_mt');
    if( !$col_cont_width_mt ) {
        $col_cont_width_mt = $col_cont_image['width'] / 20 . 'rem';
    }
    $col_cont_height_mt = get_sub_field('height_mt');
    if( !$col_cont_height_mt ) {
        $col_cont_height_mt = $col_cont_image['height'] / 20 . 'rem';
    }
    $col_cont_left_mt = get_sub_field('left_mt');
    $col_cont_right_mt = get_sub_field('right_mt');
    $col_cont_top_mt = get_sub_field('top_mt');
    $col_cont_bottom_mt = get_sub_field('bottom_mt');
    
    $col_cont_bg_elem_style = '--bg-e-width-lg: ' . $col_cont_width_ld . '; --bg-e-height-lg: ' . $col_cont_height_ld . '; --bg-e-left-lg: ' . $col_cont_left_ld . '; --bg-e-right-lg: ' . $col_cont_right_ld . '; --bg-e-top-lg: ' . $col_cont_top_ld . '; --bg-e-bottom-lg: ' . $col_cont_bottom_ld . '; --bg-e-width-mt: ' . $col_cont_width_mt . '; --bg-e-height-mt: ' . $col_cont_height_mt . '; --bg-e-left-mt: ' . $col_cont_left_mt . '; --bg-e-right-mt: ' . $col_cont_right_mt . '; --bg-e-top-mt: ' . $col_cont_top_mt . '; --bg-e-bottom-mt: ' . $col_cont_bottom_mt;
    
    $col_cont_hide_on_desktop = get_sub_field('hide_on_laptop_and_desktop');
    
    if( $col_cont_hide_on_desktop ) {
        $col_cont_display_desktop = 'none';
        $col_cont_bg_elem_style  .= '; --bg-e-display-desktop: ' .  $col_cont_display_desktop;
    }
    
    $col_cont_show_on_mobile = get_sub_field('show_on_mobile_and_tablet');
    
    if( ! $col_cont_show_on_mobile ) {
        $col_cont_display_mobile = 'none';
        $col_cont_bg_elem_style  .= '; --bg-e-display-mobile: ' .  $col_cont_display_mobile;
    }
    
    $col_cont_image_atts = [ 'class' => 'bg_element', 'style' => $col_cont_bg_elem_style ];
    
    echo wp_get_attachment_image( $col_cont_image['id'], $col_cont_size, "", $col_cont_image_atts );
}

endwhile;

?>

</div>
<?php } ?>