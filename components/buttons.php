<?php
if( have_rows('buttons') ): ?>
	<div class="buttons">
		<?php while( have_rows('buttons') ) : the_row();

			$button = get_sub_field('button');
			$button_color = get_sub_field('button_color');
			$button_hover_color = get_sub_field('button_hover_color');
			if( $button ):
				$button_url = $button['url'];
				$button_title = $button['title'];
				$button_target = $button['target'] ? $button['target'] : '_self';
				$class = ' ' . $button_color . ' ' . $button_hover_color;
				?>
				<a class="il_btn <?php echo $class; ?>" href="<?php echo esc_url( $button_url ); ?>" target="<?php echo esc_attr( $button_target ); ?>"><?php echo esc_html( $button_title ); ?></a>
			<?php endif;

		endwhile; ?>
	</div>
<?php endif; ?>
