<?php

$bg_color = get_field('background_color');
$bg_img = get_field('background_image');

$margin = get_field_object('margin');
$padding = get_field_object('padding');

$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
    $anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}

$class = 'il_block team';
if ( ! empty( $block['className'] ) ) {
    $class .= ' ' . $block['className'];
}
if ( ! empty( $cols ) ) {
    $class .=  ' ' . $cols['value'];
}
if ( ! empty( $tab_cols ) ) {
    $class .=  ' ' . $tab_cols['value'];
}
if ( ! empty( $mob_cols ) ) {
    $class .=  ' ' . $mob_cols['value'];
}
if ( ! empty( $margin ) ) {
    $class .=  ' ' . $margin['value'];
}

if ( ! empty( $padding) ) {
    $class .=  ' ' . $padding['value'];
}

$member_class = 'member';
if ( ! empty( $block['className'] ) ) {
    $member_class .= ' ' . $block['className'];
}

 ?>
<div <?php echo $anchor; ?> class="<?php echo $class ?>">
<?php get_template_part('components/background'); ?>
<div class="container">
<?php get_template_part('components/intro'); ?>
</div>

<?php
	if ( have_rows('team_row') ) :
	while( have_rows('team_row') ) : the_row();
	if ( have_rows('member') ) : ?>

		<div class="il_team_row">
			<?php
				$item = 1;
			?>
			<?php while( have_rows('member') ) : the_row();
				$image = get_sub_field('image');
				$size = 'full';
				$name = get_sub_field('name');
				$description = get_sub_field('description');
				$position = get_sub_field('position');
				$facebook = get_sub_field('facebook');
				$instagram = get_sub_field('instagram');
				$linkedin = get_sub_field('linkedin');
				$twitter = get_sub_field('twitter');
				$show_learn_more = get_sub_field('show_learn_more');
				$rand_id = uniqid();
				?>
					<div id="ilMember_<?php echo $rand_id ?>_id" data-member="ilMember_<?php echo $rand_id; ?>" class="il_team_member il_member_<?php echo $item; if( $show_learn_more ) { echo " il_member_has_learn_more"; }?>">
						<?php if( $image ) { ?>
							<figure class="member_image">
								<?php echo wp_get_attachment_image( $image, $size ); ?>
								<?php if($show_learn_more) { ?>
									<img src="/wp-content/uploads/2023/10/More.png" class="learn-more-plus-icon">
								<?php } ?>
							</figure>
						<?php } ?>
						<h4 class="member_name"><?php echo $name; ?></h4>
						<span class="member_position"><?php echo $position ?></span>
						<?php if( $facebook || $instagram || $linkedin || $twitter ) { ?>
							<div class="custom-social-icons">
								<?php if( $facebook ) { ?><a href="<?php echo $facebook; ?>"><img src="/wp-content/uploads/2023/10/SM-Facebook.png"/></a><?php } ?>
								<?php if( $instagram ) { ?><a href="<?php echo $instagram; ?>"><img src="/wp-content/uploads/2023/10/SM-instagram.png"/></a><?php } ?>
								<?php if( $linkedin ) { ?><a href="<?php echo $linkedin; ?>"><img src="/wp-content/uploads/2023/10/SM-Linkedin.png"/></a><?php } ?>
								<?php if( $twitter ) { ?><a href="<?php echo $twitter; ?>"><img src="/wp-content/uploads/2023/10/SM-Twitter.png"/></a><?php } ?>
							</div>
						<?php } ?>
					</div>
					<div id="ilMember_<?php echo $rand_id; ?>" class="member_text member_text_<?php echo $item; ?>">
						<div class="member_text_inner">
							<span class="close"><svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M13.295 2.115C13.6844 1.72564 13.6844 1.09436 13.295 0.705C12.9056 0.315639 12.2744 0.315639 11.885 0.705L7 5.59L2.115 0.705C1.72564 0.315639 1.09436 0.315639 0.705 0.705C0.315639 1.09436 0.315639 1.72564 0.705 2.115L5.59 7L0.705 11.885C0.315639 12.2744 0.315639 12.9056 0.705 13.295C1.09436 13.6844 1.72564 13.6844 2.115 13.295L7 8.41L11.885 13.295C12.2744 13.6844 12.9056 13.6844 13.295 13.295C13.6844 12.9056 13.6844 12.2744 13.295 11.885L8.41 7L13.295 2.115Z" fill="#E6317D"/></svg></span>
							<h2 class="member_box_name tg_title_1 tg_light"><?php echo $name; ?></h2>
							<span class="member_position"><?php echo $position ?></span>
							<div class="member_description"><?php echo $description; ?></div>
						</div>
					</div>
					<?php
						$item++;
					?>
			<?php endwhile; ?>
		</div>
		<?php endif; ?>
		<?php endwhile; ?>
		<?php endif; ?>
</div>
