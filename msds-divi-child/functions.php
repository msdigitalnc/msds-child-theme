<?php
/**
 * MSDS Divi Child Theme – Core
 * Enqueues parent/child styles and enables sensible theme supports.
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Enqueue parent + child styles
 */
add_action( 'wp_enqueue_scripts', 'msds_enqueue_child_theme_styles', 20 );
function msds_enqueue_child_theme_styles() {
	wp_enqueue_style(
		'divi-parent-style',
		get_template_directory_uri() . '/style.css',
		[],
		function_exists( 'et_get_theme_version' ) ? et_get_theme_version() : wp_get_theme( 'Divi' )->get( 'Version' )
	);

	wp_enqueue_style(
		'msds-child-style',
		get_stylesheet_uri(),
		[ 'divi-parent-style' ],
		file_exists( get_stylesheet_directory() . '/style.css' )
			? filemtime( get_stylesheet_directory() . '/style.css' )
			: wp_get_theme()->get( 'Version' )
	);
}

/**
 * Theme supports & small editor improvements
 */
add_action( 'after_setup_theme', 'msds_theme_setup' );
function msds_theme_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'script', 'style' ] );

	// Allow excerpts on pages (handy for SEO or custom layouts)
	add_post_type_support( 'page', 'excerpt' );
}

/**
 * Remove version query strings from enqueued styles/scripts for cleaner caching
 */
add_filter( 'style_loader_src', 'msds_remove_ver', 9999 );
add_filter( 'script_loader_src', 'msds_remove_ver', 9999 );
function msds_remove_ver( $src ) {
	if ( strpos( $src, 'ver=' ) ) {
		$src = remove_query_arg( 'ver', $src );
	}
	return $src;
}

/**
 * Add body class reflecting current theme version (helps with CSS cache busting)
 */
add_filter( 'body_class', function( $classes ) {
	$theme_version = str_replace( '.', '-', wp_get_theme()->get( 'Version' ) );
	$classes[] = 'theme-version-' . $theme_version;
	return $classes;
});

/**
 * Disable and remove WordPress comments entirely
 */
add_action( 'admin_init', 'msds_disable_comments_admin' );
function msds_disable_comments_admin() {
	global $pagenow;
	if ( $pagenow === 'edit-comments.php' ) {
		wp_safe_redirect( admin_url() );
		exit;
	}

	remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );

	foreach ( get_post_types() as $post_type ) {
		if ( post_type_supports( $post_type, 'comments' ) ) {
			remove_post_type_support( $post_type, 'comments' );
			remove_post_type_support( $post_type, 'trackbacks' );
		}
	}
}

add_filter( 'comments_open', '__return_false', 20, 2 );
add_filter( 'pings_open', '__return_false', 20, 2 );
add_filter( 'comments_array', '__return_empty_array', 10, 2 );

add_action( 'admin_menu', 'msds_cleanup_admin_menu', 999 );
function msds_cleanup_admin_menu() {
	remove_menu_page( 'edit-comments.php' );
	remove_submenu_page( 'options-general.php', 'options-discussion.php' );
}

add_action( 'wp_before_admin_bar_render', 'msds_admin_bar_cleanup' );
function msds_admin_bar_cleanup() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu( 'comments' );
}

/**
 * Divi-Specific Enhancements
 * --------------------------
 * Optional and active adjustments for Divi's native behavior.
 */

/**
 * Disable Divi Projects (removes unused 'project' post type)
 */
add_action( 'init', 'msds_remove_divi_projects', 11 );
function msds_remove_divi_projects() {
	unregister_post_type( 'project' );
}

/**
 * OPTIONAL: Disable Divi Google Fonts when local fonts exist
 * ----------------------------------------------------------
 * Uncomment this block to automatically disable Divi's external Google Fonts
 * when local font files are detected in your child theme's /fonts/ directory.
 * (Uses transient caching for minimal performance impact.)
 */
/*
add_filter( 'et_google_fonts_load', function( $load_fonts ) {
	$fonts_dir = get_stylesheet_directory() . '/fonts/';
	$cache_key = 'msds_local_fonts_found';
	$cached    = get_transient( $cache_key );

	if ( false === $cached ) {
		$found = false;
		if ( is_dir( $fonts_dir ) ) {
			$fonts = glob( $fonts_dir . '*.{ttf,otf,woff,woff2}', GLOB_BRACE );
			if ( ! empty( $fonts ) ) {
				$found = true;
			}
		}
		set_transient( $cache_key, $found, DAY_IN_SECONDS );
	} else {
		$found = $cached;
	}

	return $found ? false : $load_fonts;
});
*/

/**
 * OPTIONAL: Allow upload of font file types
 * -----------------------------------------
 * Uncomment this block to enable admin upload of .ttf, .otf, .woff, and .woff2 files.
 * (Useful if you prefer uploading fonts directly through Media Library.)
 */
/*
add_filter( 'upload_mimes', function( $mimes ) {
	$mimes['ttf']   = 'font/ttf';
	$mimes['otf']   = 'font/otf';
	$mimes['woff']  = 'font/woff';
	$mimes['woff2'] = 'font/woff2';
	return $mimes;
});
*/
?>
