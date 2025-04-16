<?php
$use_bg = get_sub_field('use_background');
$bg_color = get_sub_field('background_color');
$blue_gradient = get_sub_field('blue_gradient');
$bg_img = get_sub_field('background_image');
$bg_img_mob = get_sub_field('background_image_mob');
$size = 'full';

$intro_border_top_left_radius = get_field('intro_border_top_left_radius');
$intro_border_top_right_radius = get_field('intro_border_top_right_radius');
$intro_border_bottom_left_radius = get_field('intro_border_bottom_left_radius');
$intro_border_bottom_right_radius = get_field('intro_border_bottom_right_radius');

?>
<?php
$bg_class = 'desk_bg';
if( $bg_img_mob ) {
    $bg_class .= ' hide_desk_bg_mob';
}
if($use_bg) { ?>
<div class="il_block_bg" style="<?= $blue_gradient ? 'background: radial-gradient(50% 50.00% at 50% 50.00%, #144A9D 0%, #132051 100%);' : 'background-color: ' . $bg_color . ';' ?> <?php echo 'border-top-left-radius: ' . $intro_border_top_left_radius . 'px; border-top-right-radius: ' . $intro_border_top_right_radius . 'px; border-bottom-left-radius: ' . $intro_border_bottom_left_radius . 'px; border-bottom-right-radius: ' . $intro_border_bottom_right_radius . 'px; '?>">

<?php
if( $bg_img ) {
    echo wp_get_attachment_image( $bg_img, $size, "",array( 'class' => $bg_class ) );
}
if( $bg_img_mob ) {
    echo wp_get_attachment_image( $bg_img_mob, $size, "",array( 'class' => 'mob_bg' ) );
}

while( have_rows('elements') ) : the_row();

$image = get_sub_field('element');
if ( $image ) {
    $width_ld = get_sub_field('width_ld');
    if( !$width_ld ) {
        $width_ld = $image['width'] / 10 . 'rem';
    }
    $height_ld = get_sub_field('height_ld');
    if( !$height_ld ) {
        $height_ld = $image['height'] / 10 . 'rem';
    }
    $left_ld = get_sub_field('left_ld');
    $right_ld = get_sub_field('right_ld');
    $top_ld = get_sub_field('top_ld');
    $bottom_ld = get_sub_field('bottom_ld');
    
    $width_mt = get_sub_field('width_mt');
    if( !$width_mt ) {
        $width_mt = $image['width'] / 20 . 'rem';
    }
    $height_mt = get_sub_field('height_mt');
    if( !$height_mt ) {
        $height_mt = $image['height'] / 20 . 'rem';
    }
    $left_mt = get_sub_field('left_mt');
    $right_mt = get_sub_field('right_mt');
    $top_mt = get_sub_field('top_mt');
    $bottom_mt = get_sub_field('bottom_mt');
    
    $bg_elem_style = '--bg-e-width-lg: ' . $width_ld . '; --bg-e-height-lg: ' . $height_ld . '; --bg-e-left-lg: ' . $left_ld . '; --bg-e-right-lg: ' . $right_ld . '; --bg-e-top-lg: ' . $top_ld . '; --bg-e-bottom-lg: ' . $bottom_ld . '; --bg-e-width-mt: ' . $width_mt . '; --bg-e-height-mt: ' . $height_mt . '; --bg-e-left-mt: ' . $left_mt . '; --bg-e-right-mt: ' . $right_mt . '; --bg-e-top-mt: ' . $top_mt . '; --bg-e-bottom-mt: ' . $bottom_mt;
    
    $hide_on_desktop = get_sub_field('hide_on_laptop_and_desktop');
    
    if( $hide_on_desktop ) {
        $display_desktop = 'none';
        $bg_elem_style  .= '; --bg-e-display-desktop: ' .  $display_desktop;
    }
    
    $show_on_mobile = get_sub_field('show_on_mobile_and_tablet');
    
    if( ! $show_on_mobile ) {
        $display_mobile = 'none';
        $bg_elem_style  .= '; --bg-e-display-mobile: ' .  $display_mobile;
    }
    
    $image_atts = [ 'class' => 'bg_element', 'style' => $bg_elem_style ];
    
    echo wp_get_attachment_image( $image['id'], $size, "", $image_atts );
}

endwhile;

?>

</div>
<?php } ?>