<?php

/* Theme config params */

// defines
//define ('GOOGLEMAPS', TRUE);
define( 'WPE_POPUP_DISABLED', true );
define( 'HOME_PAGE_ID', get_option( 'page_on_front' ) );
define( 'BLOG_ID', get_option( 'page_for_posts' ) );
define( 'POSTS_PER_PAGE', get_option( 'posts_per_page' ) );
// prevent file modifications
if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
	define( 'DISALLOW_FILE_EDIT', true );
}

// recommended plugins installer
require_once 'plugins/installer.php';

// include custom assets
require_once( 'assets.php' );

// custom admin area functions
require_once( 'admin-area/admin-area.php' );

// custom shortcodes
require_once( 'shortcodes.php' );

// ACF settings
require_once( 'acf.php' );


// custom post types & taxonomies
//require_once('cpt.php');

// custom ajax functions
require_once('ajax.php');

// custom theme URL
function theme( $filepath = null ) {
	return preg_replace( '(https?://)', '//', get_stylesheet_directory_uri() . ( $filepath ? '/' . $filepath : '' ) );
}

// get alt or image name
function get_alt( $id ) {
	$c_alt = get_post_meta( $id, '_wp_attachment_image_alt', true );
	$c_tit = get_the_title( $id );

	return $c_alt ? $c_alt : $c_tit;
}

// run this code on 'after_theme_setup', when plugins have already been loaded
add_action( 'after_setup_theme', 'wpa_activate_theme' );
// this function loads the plugins & updates some WordPress options
function wpa_activate_theme() {
	update_option( 'image_default_link_type', 'none' );
	// comment this before the build if uploads from the old website is being migrated with default year-month structure
	update_option( 'uploads_use_yearmonth_folders', 0 );
}

// remove default menu classes + new custom classes
function wpa_discard_menu_classes( $classes, $item ) {
	$classes = array_filter(
		$classes, function ( $class ) {
		return in_array( $class, array(
			"current-menu-item",
			"current-menu-parent",
			"current_page_parent",
			"menu-item-has-children"
		) );
	}
	);

	return array_merge(
		$classes,
		(array) get_post_meta( $item->ID, '_menu_item_classes', true )
	);
}

// new body classes
function wpa_body_classes( $classes ) {
	if ( is_page() ) {
		global $post;
		$temp = get_page_template();
		if ( $temp != null ) {
			$path      = pathinfo( $temp );
			$tmp       = $path['filename'] . "." . $path['extension'];
			$tn        = str_replace( ".php", "", $tmp );
			$classes[] = $tn;
		}
//		if (is_active_sidebar('sidebar')) {
//			$classes[] = 'with_sidebar';
//		}
		foreach ( $classes as $k => $v ) {
			if (
				$v == 'page-template' ||
				$v == 'page-id-' . $post->ID ||
				$v == 'page-template-default' ||
				$v == 'woocommerce-page' ||
				($temp != null?($v == 'page-template-'.$tn.'-php' || $v == 'page-template-'.$tn):'')) unset($classes[$k]);
		}
	}
	if ( is_single() ) {
		global $post;
		$f = get_post_format( $post->ID );
		foreach($classes as $k => $v) {
			if($v == 'postid-'.$post->ID || $v == 'single-format-'.(!$f?'standard':$f)) unset($classes[$k]);
		}
	}

	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

	$browser = $_SERVER['HTTP_USER_AGENT'];

	// Mac, PC ...or Linux
	if ( preg_match( "/Mac/", $browser ) ) {
		$classes[] = 'macos';
	} elseif ( preg_match( "/Windows/", $browser ) ) {
		$classes[] = 'windows';
	} elseif ( preg_match( "/Linux/", $browser ) ) {
		$classes[] = 'linux';
	} else {
		$classes[] = 'unknown-os';
	}
	// Checks browsers in this order: Chrome, Safari, Opera, MSIE, FF
	if ( preg_match( "/Edge/", $browser ) ) {
		$classes[] = 'edge';
	} elseif ( preg_match( "/Chrome/", $browser ) ) {
		$classes[] = 'chrome';
		preg_match( "/Chrome\/(\d.\d)/si", $browser, $matches );
		@$classesh_version = 'ch' . str_replace( '.', '-', $matches[1] );
		$classes[] = $classesh_version;
	} elseif ( preg_match( "/Safari/", $browser ) && preg_match( "/Version\/(\d+\.\d+)/si", $browser, $matches ) ) {
		$sf_version = 'sf' . str_replace( '.', '-', $matches[1] );
		$classes[]  = 'safari';
		$classes[]  = $sf_version;
	} elseif ( preg_match( "/Opera/", $browser ) ) {
		$classes[] = 'opera';
		preg_match( "/Opera\/(\d.\d)/si", $browser, $matches );
		$op_version = 'op' . str_replace( '.', '-', $matches[1] );
		$classes[]  = $op_version;
	} elseif ( preg_match( "/MSIE/", $browser ) ) {
		$classes[] = 'msie';
		if ( preg_match( "/MSIE 6.0/", $browser ) ) {
			$classes[] = 'ie6';
		} elseif ( preg_match( "/MSIE 7.0/", $browser ) ) {
			$classes[] = 'ie7';
		} elseif ( preg_match( "/MSIE 8.0/", $browser ) ) {
			$classes[] = 'ie8';
		} elseif ( preg_match( "/MSIE 9.0/", $browser ) ) {
			$classes[] = 'ie9';
		}
	} elseif ( preg_match( "/Firefox/", $browser ) && preg_match( "/Gecko/", $browser ) ) {
		$classes[] = 'firefox';
		preg_match( "/Firefox\/(\d)/si", $browser, $matches );
		$ff_version = 'ff' . str_replace( '.', '-', $matches[1] );
		$classes[]  = $ff_version;
	} else {
		$classes[] = 'unknown-browser';
	}

	return $classes;
}

// custom SEO title
function wpa_title() {
	global $post;
	if ( ! defined( 'WPSEO_VERSION' ) ) {
		if ( is_404() ) {
			echo '404 Page not found - ';
		} elseif ( ( is_single() || is_page() ) && $post->post_parent ) {
			$parent_title = get_the_title( $post->post_parent );
			echo wp_title( '-', true, 'right' ) . esc_html( $parent_title ) . ' - ';
		} else {
			wp_title( '-', true, 'right' );
		}
		bloginfo( 'name' );
	} else {
		wp_title();
	}
}

function wpa_init() {
	// add support for page/post thumbnails
	add_theme_support( 'post-thumbnails' );

	// security
	// disable JSON API
	add_filter( 'json_enabled', '__return_false' );
	add_filter( 'json_jsonp_enabled', '__return_false' );
	// remove REST API link tag from page header
	remove_action( 'wp_head', 'rest_output_link_wp_head' );

	// custom oEmbed rules
	// turn off oEmbed auto discovery
	add_filter( 'embed_oembed_discover', '__return_false' );
	// remove JSON & XML oEmbed discovery links from front end
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

	// remove unnecessary code from wp_head
	remove_action( 'wp_head', 'feed_links_extra', 3 );
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'index_rel_link' );
	remove_action( 'wp_head', 'parent_post_rel_link', 10 );
	remove_action( 'wp_head', 'start_post_rel_link', 10 );
	remove_action( 'wp_head', 'wp_shortlink_wp_head' );
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head' );
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_head', 'rel_canonical' );

	// remove global css vars
	/*remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
	remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );
	remove_action( 'wp_footer', 'wp_enqueue_global_styles', 1 );*/

	// remove Emoji
	// prevent Emoji from loading on the front-end
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	// remove from admin area also
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	// remove from RSS feeds also
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	// remove from embeds
	remove_filter( 'embed_head', 'print_emoji_detection_script' );
	// remove from emails
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	// disable from TinyMCE editor, currently disabled in block editor by default
	add_filter('tiny_mce_plugins', function($plugins) {
		if(is_array($plugins)) { return array_diff($plugins, array('wpemoji')); } else { return array(); }
	});
	// finally, disable it from the database also, to prevent characters from converting
	// earlier, there was a setting under Writings to do this
	// it is not ideal to get & update it here - but it works for now
	if( (int) get_option('use_smilies') === 1 ) { update_option( 'use_smilies', 0 ); }

	// theme custom functions
	// remove default menu classes + new custom classes
	add_filter( 'nav_menu_css_class', 'wpa_discard_menu_classes', 10, 2 );
	// remove IDs from menu
	add_filter( 'nav_menu_item_id', '__return_false', 10 );
	// new body classes
	add_filter( 'body_class', 'wpa_body_classes' );
	// remove <p> & <br> from CF7
	add_filter( 'wpcf7_autop_or_not', '__return_false' );

}

add_action( 'init', 'wpa_init', 9999 );

/*Disable Patterns*/
add_action( 'after_setup_theme', function () {
	remove_theme_support( 'core-block-patterns' );
} );

/*Load Gutenberg tpl-acf-blocks styles separately*/
add_filter( 'should_load_separate_core_block_assets', '__return_true' );
add_filter( 'styles_inline_size_limit', '__return_zero' );

// custom var_dump
function wpa_dump($variable) {
	$pretty = function($v='',$c="&nbsp;&nbsp;&nbsp;&nbsp;",$in=-1,$k=null)use(&$pretty){$r='';if(in_array(gettype($v),array('object','array'))){$r.=($in!=-1?str_repeat($c,$in):'').(is_null($k)?'':"$k: ").'<br>';foreach($v as $sk=>$vl){$r.=$pretty($vl,$c,$in+1,$sk).'<br>';}}else{$r.=($in!=-1?str_repeat($c,$in):'').(is_null($k)?'':"$k: ").(is_null($v)?'&lt;NULL&gt;':"<strong>$v</strong>");}return$r;};
	echo '<pre style="padding-left: 150px; font-family: Courier New"><code class="json">' . wp_kses_post($pretty($variable)) . '</code></pre>';
}

// custom loader
function get_loader() {
	return '<div class="show_box"><div class="loader"><svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-miterlimit="10"/></svg></div></div>';
}

// allowed tags to use loader with escaping
// usage - echo wp_kses(get_loader(), $GLOBALS['allowed_loader'])
$allowed_loader = array( 'div' => array( 'class' => true ), 'svg' => array( 'class'   => true, 'viewbox' => true, ), 'circle' => array( 'class' => true, 'cx' => true, 'cy' => true, 'r' => true, 'fill' => true, 'stroke-miterlimit' => true, ), );

//allow iframe display via wp_kses_post
function custom_wpkses_post_tags( $tags, $context ) {

	if ( 'post' === $context ) {
		$tags['iframe'] = array(
			'src'             => true,
			'height'          => true,
			'width'           => true,
			'frameborder'     => true,
			'allowfullscreen' => true,
		);
	}

	return $tags;
}

add_filter( 'wp_kses_allowed_html', 'custom_wpkses_post_tags', 10, 2 );

/*Disable Gutenberg tpl-acf-blocks*/
function gutenberg_blacklist_blocks( $allowed_blocks ) {
	// Blocks to blacklist with their slugs
	$blocks_to_blacklist = array(
		'core/archives',
		'core/calendar',
		'core/comments',
		'core/post-author-name',
		'core/nextpage',
		'core/pullquote',
		'core/footnotes',
		'core/verse',
		'core/details',
		'core/more',
		'core/categories',
		'core/latest-comments',
		'core/latest-posts',
		'core/page-list',
		'core/rss',
		'core/search',
		'core/social-links',
		'core/tag-cloud',
		'core/navigation',
		'core/site-logo',
		'core/site-title',
		'core/site-tagline',
		'core/query',
		'core/post-navigation-link',
		'core/post-template',
		'core/query-pagination',
		'core/query-pagination-next',
		'core/query-pagination-numbers',
		'core/query-pagination-previous',
		'core/query-no-results',
		'core/read-more',
		'core/posts-list',
		'core/avatar',
		'core/post-title',
		'core/post-excerpt',
		'core/post-featured-image',
		'core/post-content',
		'core/post-author',
		'core/post-date',
		'core/post-terms',
		'core/read-more',
		'core/comments',
		'core/comment-author-name',
		'core/comment-content',
		'core/comment-date',
		'core/comment-edit-link',
		'core/comment-reply-link',
		'core/comment-template',
		'core/comments-title',
		'core/comments-pagination',
		'core/comments-pagination-next',
		'core/comments-pagination-numbers',
		'core/comments-pagination-previous',
		'core/post-comments-form',
		'core/loginout',
		'core/term-description',
		'core/query-title',
		'core/post-author-biography',
//		'core/paragraph',
//		'core/heading',
//		'core/list',
//		'core/quote',
//		'core/code',
//		'core/preformatted',
//		'core/table',
//		'core/freeform',
//		'core/gallery',
//		'core/audio',
//		'core/cover',
//		'core/file',
//		'core/media-text',
//		'core/video',
//		'core/columns',
//		'core/buttons',
//		'core/group',
//		'core/separator',
//		'core/spacer',
//		'core/html', // custom html block
//		'core/shortcode',
//		'core/embed', // embeds block
//		'contact-form-7/contact-form-selector',
		'yoast-seo/breadcrumbs',
		'yoast/how-to-block',
		'yoast/faq-block',
	);

	// get all the registered tpl-acf-blocks
	$blocks = WP_Block_Type_Registry::get_instance()->get_all_registered();

	// disable the tpl-acf-blocks specified in $blocks_to_blacklist
	foreach ( $blocks_to_blacklist as $block_slug ) {
		unset( $blocks[ $block_slug ] );
	}

	// return the new list of allowed tpl-acf-blocks
	return array_keys( $blocks );
}

add_filter( 'allowed_block_types_all', 'gutenberg_blacklist_blocks' );