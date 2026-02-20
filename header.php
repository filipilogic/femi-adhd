<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ilogic
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php echo get_field('head_script', 'option') ?> <!-- Head(er) External Code -->
	<?php wp_head(); ?>
	<meta name="theme-color" content="<?php the_field('primary_color', 'option'); ?>" />
	<style>
		:root {
			--color-1: <?php the_field('primary_color', 'option'); ?>;
			--color-2: <?php the_field('secondary_color', 'option'); ?>;
			--color-3: <?php the_field('third_color', 'option'); ?>;
			--color-text: <?php the_field('text_color', 'option'); ?>;
			--title-size-1-ld: <?php the_field('title_size_1_ld', 'option'); ?>;
			--title-size-2-ld: <?php the_field('title_size_2_ld', 'option'); ?>;
			--title-size-3-ld: <?php the_field('title_size_3_ld', 'option'); ?>;
			--title-size-4-ld: <?php the_field('title_size_4_ld', 'option'); ?>;
			--title-size-5-ld: <?php the_field('title_size_5_ld', 'option'); ?>;
			--title-size-1-mt: <?php the_field('title_size_1_mt', 'option'); ?>;
			--title-size-2-mt: <?php the_field('title_size_2_mt', 'option'); ?>;
			--title-size-3-mt: <?php the_field('title_size_3_mt', 'option'); ?>;
			--title-size-4-mt: <?php the_field('title_size_4_mt', 'option'); ?>;
			--title-size-5-mt: <?php the_field('title_size_5_mt', 'option'); ?>;
			--subtitle-size-1-ld: <?php the_field('subtitle_size_1_ld', 'option'); ?>;
			--subtitle-size-2-ld: <?php the_field('subtitle_size_2_ld', 'option'); ?>;
			--subtitle-size-3-ld: <?php the_field('subtitle_size_3_ld', 'option'); ?>;
			--subtitle-size-1-mt: <?php the_field('subtitle_size_1_mt', 'option'); ?>;
			--subtitle-size-2-mt: <?php the_field('subtitle_size_2_mt', 'option'); ?>;
			--subtitle-size-3-mt: <?php the_field('subtitle_size_3_mt', 'option'); ?>;
			--b-space-1-ld: <?php the_field('padding-xs-ld', 'option'); ?>;
			--b-space-2-ld: <?php the_field('padding-s-ld', 'option'); ?>;
			--b-space-3-ld: <?php the_field('padding-m-ld', 'option'); ?>;
			--b-space-4-ld: <?php the_field('padding-l-ld', 'option'); ?>;
			--b-space-5-ld: <?php the_field('padding-xl-ld', 'option'); ?>;
			--b-space-1-mt: <?php the_field('padding-xs-mt', 'option'); ?>;
			--b-space-2-mt: <?php the_field('padding-s-mt', 'option'); ?>;
			--b-space-3-mt: <?php the_field('padding-m-mt', 'option'); ?>;
			--b-space-4-mt: <?php the_field('padding-l-mt', 'option'); ?>;
			--b-space-5-mt: <?php the_field('padding-xl-mt', 'option'); ?>;
		}
	</style>
</head>

<body <?php body_class(); ?>>
<?php echo get_field('body_top_script', 'option') ?> <!-- Body Top External Script -->
<?php wp_body_open(); ?>
<div id="page" class="site header-version-1">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'ilogic' ); ?></a>
		<?php
			// Check rows existexists.
			if( have_rows('top_buttons', 'option') ): ?>
			<div class="header-top <?php the_field('buttons_position', 'option') ?>">
				<div class="section_inner">

				<?php while( have_rows('top_buttons', 'option') ) : the_row();

					$top_button = get_sub_field('top_button');
					$tb_url = $top_button['url'];
					$tb_title = $top_button['title'];
					$tb_target = $top_button['target'] ? $top_button['target'] : '_self'; ?>

					<a class="il_btn" href="<?php echo esc_url( $tb_url ); ?>" target="<?php echo esc_attr( $tb_target ); ?>"><?php echo esc_html( $tb_title ); ?></a>

				<?php endwhile; ?>
				</div>
			</div>
			<?php endif; ?>

	<header id="masthead" class="header-main">
		<div class="container header-main-inner">
			<?php
			$nav_btn_1 = get_field('button_1_after_nav', 'option');
			$nav_btn_2 = get_field('button_2_after_nav', 'option');
			$nav_btn_3 = get_field('button_3_after_nav', 'option');
			
			if( $nav_btn_1 || $nav_btn_2 || $nav_btn_3 ): ?>
				<div class="header-cta-buttons">
					<?php
					if( $nav_btn_1 ):
						$nav_btn_1_url = $nav_btn_1['url'];
						$nav_btn_1_title = $nav_btn_1['title'];
						$nav_btn_1_target = $nav_btn_1['target'] ? $nav_btn_1['target'] : '_self';
						?>
						<a class="nav-button il_btn" href="<?php echo esc_url( $nav_btn_1_url ); ?>" target="<?php echo esc_attr( $nav_btn_1_target ); ?>"><?php echo esc_html( $nav_btn_1_title ); ?></a>
					<?php endif;
					
					if( $nav_btn_2 ):
						$nav_btn_2_url = $nav_btn_2['url'];
						$nav_btn_2_title = $nav_btn_2['title'];
						$nav_btn_2_target = $nav_btn_2['target'] ? $nav_btn_2['target'] : '_self';
						?>
						<a class="nav-button-2 il_btn" href="<?php echo esc_url( $nav_btn_2_url ); ?>" target="<?php echo esc_attr( $nav_btn_2_target ); ?>"><?php echo esc_html( $nav_btn_2_title ); ?></a>
					<?php endif;
					
					if( $nav_btn_3 ):
						$nav_btn_3_url = $nav_btn_3['url'];
						$nav_btn_3_title = $nav_btn_3['title'];
						$nav_btn_3_target = $nav_btn_3['target'] ? $nav_btn_3['target'] : '_self';
						?>
						<a class="nav-button-3 il_btn" href="<?php echo esc_url( $nav_btn_3_url ); ?>" target="<?php echo esc_attr( $nav_btn_3_target ); ?>"><span><?php echo esc_html( $nav_btn_3_title ); ?></span></a>
					<?php endif; ?>
				</div>
			<?php endif; ?>
			<nav id="site-navigation" class="main-navigation">
			<!-- Mobile Nav Button -->
			<input type="checkbox" class="menu-toggle" id="menu_trigger">
			<label for="menu_trigger">
				<span></span>
				<span></span>
				<span></span>
			</label>
			<!-- Mobile Nav Button -->
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'menu-1',
						'menu_id'        => 'primary-menu',
					)
				);
				?>
			</nav><!-- #site-navigation -->
			<div class="logo-wrap">
				<?php
				the_custom_logo(); ?>
			</div><!-- .site-branding -->
		</div>
	</header><!-- #masthead -->
