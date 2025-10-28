<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package ilogic
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function ilogic_body_classes( $classes ) {

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}
	if( get_field('sticky', 'option' ) == 'stick-top') {
		$classes[] = 'stick-top';
	}
	if( get_field('sticky', 'option' ) == 'stick-main') {
		$classes[] = 'stick-main';
	}
	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'ilogic_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function ilogic_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'ilogic_pingback_header' );



// Plugin dependencies

require_once get_template_directory() . '/plugins/plugin-activation.php';

add_action( 'tgmpa_register', 'ilogic_register_required_plugins' );

function ilogic_register_required_plugins() {

	$plugins = array(

		// This is an example of how to include a plugin bundled with a theme.
		array(
			'name'               => 'Advanced Custom Fields PRO', // The plugin name.
			'slug'               => 'advanced-custom-fields-pro', // The plugin slug (typically the folder name).
			'source'             => get_template_directory() . '/plugins/advanced-custom-fields-pro.zip', // The plugin source.
			'required'           => true, // If false, the plugin is only 'recommended' instead of required.
			'version'            => '6.0.7', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
			'force_activation'   => true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
		),
		array(
			'name'               => 'Custom Fonts', // The plugin name.
			'slug'               => 'custom-fonts', // The plugin slug (typically the folder name).
			'source'             => 'https://wordpress.org/plugins/custom-fonts/', // The plugin source.
			'required'           => true, // If false, the plugin is only 'recommended' instead of required.
			'version'            => '1.3.7', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
			'force_activation'   => true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
		),
		array(
			'name'               => 'Safe SVG', // The plugin name.
			'slug'               => 'safe-svg', // The plugin slug (typically the folder name).
			'source'             => 'https://wordpress.org/plugins/safe-svg/', // The plugin source.
			'required'           => false, // If false, the plugin is only 'recommended' instead of required.
			'version'            => '2.0.3', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
		),

	);

	$config = array(
		'id'           => 'ilogic',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'themes.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => false,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );
}



// Custom login page

add_filter( 'login_headerurl', 'my_custom_login_url' );
function my_custom_login_url($url) {
    return 'https://lemon-mss.com/';
}

function theme_login_screen() { ?>
    <style type="text/css">
		body.login {
			background: #47d6ca;
		}
		div#login {
			width: 500px;
			max-width: 90%;
		}
		.login form#loginform {
			box-shadow: 0 30px 60px 0 rgba(0, 0, 0, 30%);
			border: none;
			border-radius: 20px;
			padding: 3rem 2rem;
		}
		.login form#loginform label {
			width: 100%;
			text-align: center;
		}
		.login form#loginform p.forgetmenot label {
			width: unset;
		}
		.login form input.input {
			background: #f6f6f6;
			padding: 1rem 2rem;
			text-align: center;
			border-color: transparent;
			transition: .5s all;
			outline: none;
		}
		.login form input.input:focus {
			background: #fff;
			border-bottom-color: #5fbae9;
			box-shadow: none;
		}
        #login h1 a, .login h1 a {
        background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/assets/public/images/lemon-logo.png');
        height:100px;
        width:300px;
        background-size: contain;
        background-repeat: no-repeat;
		background-position: center;
        padding-bottom: 10px;
        }
		.login form p.forgetmenot {
			width: 100%;
			text-align: center;
		}
		#login form p.submit {
			display: flex;
			justify-content: center;
			width: 100%;
		}
		.login .button-primary#wp-submit {
			background: #5fbae9;
			border: none;
			text-transform: uppercase;
			padding: .5rem 4rem;
			margin-top: 2rem;
			transition: .3s all;
		}
		.login .button-primary#wp-submit:hover {
			background-color: #39ace7;
		}
		#login #nav, #login #backtoblog {
			text-align: center;
		}
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'theme_login_screen' );


// Disable Comments

add_action('admin_init', function () {
    // Redirect any user trying to access comments page
    global $pagenow;

    if ($pagenow === 'edit-comments.php') {
        wp_redirect(admin_url());
        exit;
    }

    // Remove comments metabox from dashboard
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');

    // Disable support for comments and trackbacks in post types
    foreach (get_post_types() as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
});

// Close comments on the front-end
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);

// Hide existing comments
add_filter('comments_array', '__return_empty_array', 10, 2);

// Remove comments page in menu
add_action('admin_menu', function () {
    remove_menu_page('edit-comments.php');
});

// Remove comments links from admin bar
add_action('init', function () {
    if (is_admin_bar_showing()) {
        remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
    }
});


// Include ACF local.json

add_filter('acf/settings/save_json', 'my_acf_json_save_point');

function my_acf_json_save_point( $path ) {

    // update path
    $path = get_stylesheet_directory() . '/acf-json';


    // return
    return $path;

}

add_filter('acf/settings/load_json', 'my_acf_json_load_point');

function my_acf_json_load_point( $paths ) {

    // remove original path (optional)
    unset($paths[0]);


    // append path
    $paths[] = get_stylesheet_directory() . '/acf-json';


    // return
    return $paths;

}


// Register Widgets

// @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar



function theme_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Footer 1', 'ilogic' ),
		'id'            => 'footer-1',
		'description'   => __( 'Footer Area 1', 'ilogic' ),
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>',
	) );
    register_sidebar( array(
		'name'          => __( 'Footer 2', 'ilogic' ),
		'id'            => 'footer-2',
		'description'   => __( 'Footer Area 2', 'ilogic' ),
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>',
	) );
    register_sidebar( array(
		'name'          => __( 'Footer 3', 'ilogic' ),
		'id'            => 'footer-3',
		'description'   => __( 'Footer Area 3', 'ilogic' ),
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>',
	) );
    register_sidebar( array(
		'name'          => __( 'Footer 4', 'ilogic' ),
		'id'            => 'footer-4',
		'description'   => __( 'Footer Area 4', 'ilogic' ),
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>',
	) );
    register_sidebar( array(
		'name'          => __( 'Footer Bottom', 'ilogic' ),
		'id'            => 'footer-bottom',
		'description'   => __( 'Footer Bottom', 'ilogic' ),
		'before_widget' => '<div class="footer_bottom_inner container">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>',
	) );
    register_sidebar( array(
		'name'          => __( 'Blog Sidebar', 'ilogic' ),
		'id'            => 'blog-sidebar',
		'description'   => __( 'Blog Sidebar', 'ilogic' ),
		'before_widget' => '<div class="blog_sidebar">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'theme_widgets_init' );

// Theme Colors

add_action('acf/input/admin_head', 'admin_variables');
function admin_variables() {
    ?>
    <style type="text/css">
        :root {
			--color-1: <?php the_field('primary_color', 'option'); ?>;
			--color-2: <?php the_field('secondary_color', 'option'); ?>;
			--color-3: <?php the_field('third_color', 'option'); ?>;
			--color-text: <?php the_field('text_color', 'option'); ?>;
		}
    </style>
    <?php
}