<?php
/**
 * ilogic functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package ilogic
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.1.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function ilogic_setup() {

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'ilogic' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);


	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 150,
			'width'       => 300,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'ilogic_setup' );

/**
 * Enqueue scripts and styles.
 */
function ilogic_scripts() {
	wp_enqueue_style( 'ilogic-style', get_stylesheet_uri(), array(), _S_VERSION );

	wp_enqueue_style( 'frontend-style', get_template_directory_uri() . '/assets/public/css/frontend.css', array(), _S_VERSION );
	wp_enqueue_script( 'ilogic-script', get_template_directory_uri() . '/assets/public/js/frontend.js', array('jquery'), _S_VERSION );

	wp_enqueue_script( 'fancybox', get_template_directory_uri() . '/assets/public/js/vendor/fancybox.js',array('jquery'),_S_VERSION,true);
	wp_enqueue_script( 'flickity', get_template_directory_uri() . '/assets/public/js/vendor/flickity.js',array('jquery'),_S_VERSION,true);

	if ( is_home() ) {
		wp_enqueue_script( 'blog-main-script', get_template_directory_uri() . '/assets/src/js/blog-main.js', array('jquery'), _S_VERSION );
	}

	if ( is_category() ) {
		wp_enqueue_script( 'archive-main-script', get_template_directory_uri() . '/assets/src/js/archive-main.js', array('jquery'), _S_VERSION );
	}

    // Add load-more script
    wp_enqueue_script( 'load-more', get_template_directory_uri() . '/assets/src/js/load-more.js', array('jquery'), _S_VERSION );
    wp_localize_script('load-more', 'ajaxVars', array(
        'ajaxurl' => admin_url('admin-ajax.php')
    ));
}
add_action( 'wp_enqueue_scripts', 'ilogic_scripts' );

function ilogic_admin_styles() {
	wp_enqueue_style( 'backend-styles', get_template_directory_uri() . '/assets/public/css/backend.css' );
}
add_action( 'admin_enqueue_scripts', 'ilogic_admin_styles' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/includes/theme-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/includes/theme-functions.php';

// Theme options

require get_template_directory() . '/includes/theme-options.php';

// Fun Facts

require get_template_directory() . '/includes/theme-facts.php';


// Load scripts for block


 require get_template_directory() . '/includes/blocks-js.php';


// Register Blocks

add_action( 'init', 'register_acf_blocks' );
function register_acf_blocks() {
	register_block_type( __DIR__ . '/blocks/hero' );
	register_block_type( __DIR__ . '/blocks/hero-si' );
    register_block_type( __DIR__ . '/blocks/section' );
	register_block_type( __DIR__ . '/blocks/accordion' );
	register_block_type( __DIR__ . '/blocks/gallery' );
	register_block_type( __DIR__ . '/blocks/team' );
	register_block_type( __DIR__ . '/blocks/columns' );
	register_block_type( __DIR__ . '/blocks/tabs' );
	register_block_type( __DIR__ . '/blocks/lb-carousel' );
	register_block_type( __DIR__ . '/blocks/timeline' );
	register_block_type( __DIR__ . '/blocks/inner-hero-1' );
	register_block_type( __DIR__ . '/blocks/inner-hero-2' );
	register_block_type( __DIR__ . '/blocks/fp-section' );
	register_block_type( __DIR__ . '/blocks/mini-gallery' );
	register_block_type( __DIR__ . '/blocks/video-popup-section' );
	register_block_type( __DIR__ . '/blocks/contact-us' );
	register_block_type( __DIR__ . '/blocks/exec-director-section' );
	register_block_type( __DIR__ . '/blocks/countdown' );
	register_block_type( __DIR__ . '/blocks/agenda' );
	register_block_type( __DIR__ . '/blocks/blog-block' );
	register_block_type( __DIR__ . '/blocks/logos' );
	register_block_type( __DIR__ . '/blocks/related-posts' );
	register_block_type( __DIR__ . '/blocks/content-and-sidebar' );
}


function filter_block_categories_when_post_provided( $block_categories, $editor_context ) {
    if ( ! empty( $editor_context->post ) ) {
        array_push(
            $block_categories,
            array(
                'slug'  => 'ilogic-category',
                'title' => __( 'iLogic Blocks', 'ilogic' ),
                'icon'  => null,
            )
        );
    }
    return $block_categories;
}

add_filter( 'block_categories_all', 'filter_block_categories_when_post_provided', 10, 2 );

function the_breadcrumb() {

	$page_for_posts_id = get_option( 'page_for_posts' );
	$blog_title = get_the_title($page_for_posts_id);

    $sep = ' > ';

    if (!is_front_page()) {
	
	// Start the breadcrumb with a link to your homepage
        echo '<div class="il_sp_breadcrumbs">';
        echo '<a href="';
        echo get_permalink( get_option( 'page_for_posts' ) );
        echo '">';
        echo $blog_title;
        echo '</a>' . $sep;
	
	
	// Check if the current page is a category, an archive or a single page. If so show the category or archive name.
        if (is_category() || is_single() ){
			echo '<span>Category</span>'. $sep;
            the_category(', ');
        } elseif (is_archive() || is_single()){
            if ( is_day() ) {
                printf( __( '%s', 'text_domain' ), get_the_date() );
            } elseif ( is_month() ) {
                printf( __( '%s', 'text_domain' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'text_domain' ) ) );
            } elseif ( is_year() ) {
                printf( __( '%s', 'text_domain' ), get_the_date( _x( 'Y', 'yearly archives date format', 'text_domain' ) ) );
            } else {
                _e( 'Blog Archives', 'text_domain' );
            }
        }
	
	// If the current page is a single post, show its title with the separator
        if (is_single()) {
            // echo $sep;
            // the_title();
        }
	
	// If the current page is a static page, show its title.
        if (is_page()) {
            echo the_title();
        }
	
	// if you have a static page assigned to be you posts list page. It will find the title of the static page and display it. i.e Home >> Blog
        if (is_home()){
            global $post;
            $page_for_posts_id = get_option('page_for_posts');
            if ( $page_for_posts_id ) { 
                $post = get_post($page_for_posts_id);
                setup_postdata($post);
                the_title();
                rewind_posts();
            }
        }

        echo '</div>';
    }
}

function custom_post_navigation_shortcode() {
    ob_start(); // Start output buffering
    ?>
    <div class="post_nav_container">
        <?php
        // Output the post navigation
        the_post_navigation(array(
            'prev_text' => '<b><</b> Previous',
            'next_text' => 'Next <b>></b>',
            'in_same_term' => true,
        ));
        ?>
    </div>
    <?php

    return ob_get_clean(); // End output buffering and return the buffered content
}

// Register the shortcode
add_shortcode('post_navigation_shortcode', 'custom_post_navigation_shortcode');

function load_more_posts_blog_block() {
    $page = $_POST['page'];
    $posts_per_page = $_POST['posts_per_page'];
    $categories = $_POST['categories'];
    $show_date = filter_var($_POST['show_date'], FILTER_VALIDATE_BOOLEAN);
    $learn_more_text = $_POST['learn_more_text'];
    $carousel = filter_var($_POST['carousel'], FILTER_VALIDATE_BOOLEAN);
    $show_homepage_image = filter_var($_POST['show_homepage_image'], FILTER_VALIDATE_BOOLEAN);

    $args = array(
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => $posts_per_page,
        'paged'          => $page,
        'tax_query'      => array(
            array(
                'taxonomy' => 'category',
                'field'    => 'term_id',
                'terms'    => $categories,
            ),
        ),
    );

    $posts = new WP_Query($args);

    if ($posts->have_posts()) :
        while ($posts->have_posts()) : $posts->the_post();
			include(locate_template('template-parts/content-blog-post.php', false));
        endwhile;
    endif;

    wp_die();
}
add_action('wp_ajax_load_more_posts_blog_block', 'load_more_posts_blog_block');
add_action('wp_ajax_nopriv_load_more_posts_blog_block', 'load_more_posts_blog_block');

function load_more_posts_related_block() {
    $page = $_POST['page'];
    $posts_per_page = $_POST['posts_per_page'];
    $categories = $_POST['categories'];
    $current_post_id = $_POST['current_post_id'];
    $show_date = filter_var($_POST['show_date'], FILTER_VALIDATE_BOOLEAN);
    $learn_more_text = $_POST['learn_more_text'];
    $carousel = filter_var($_POST['carousel'], FILTER_VALIDATE_BOOLEAN);

    $args = array(
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => $posts_per_page,
		'post__not_in'   => array($current_post_id),
        'paged'          => $page,
        'tax_query'      => array(
            array(
                'taxonomy' => 'category',
                'field'    => 'term_id',
                'terms'    => $categories,
            ),
        ),
    );

    $posts = new WP_Query($args);

    if ($posts->have_posts()) :
        while ($posts->have_posts()) : $posts->the_post();
			include(locate_template('template-parts/content-related-post.php', false));
        endwhile;
    endif;

    wp_die();
}
add_action('wp_ajax_load_more_posts_related_block', 'load_more_posts_related_block');
add_action('wp_ajax_nopriv_load_more_posts_related_block', 'load_more_posts_related_block');
