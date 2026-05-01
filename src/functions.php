<?php
/**
 * Seiler 2026 Theme Functions
 *
 * @package Seiler_2026
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Theme Setup
 */
function seiler_2026_setup() {
	// Make theme available for translation
	load_theme_textdomain( 'seiler-2026', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title
	add_theme_support( 'title-tag' );

	// Enable support for Post Thumbnails
	add_theme_support( 'post-thumbnails' );

	// Enable support for responsive embeds
	add_theme_support( 'responsive-embeds' );

	// Add support for editor styles
	add_theme_support( 'editor-styles' );

	// Enqueue editor styles
	add_editor_style( 'assets/css/theme.css' );

	// Add support for block templates
	add_theme_support( 'block-templates' );

	// Add support for full and wide align images
	add_theme_support( 'align-wide' );

	// Add support for custom line heights
	add_theme_support( 'custom-line-height' );

	// Add support for custom spacing
	add_theme_support( 'custom-spacing' );

	// Add support for custom units
	add_theme_support( 'custom-units' );

	// Add support for link color control
	add_theme_support( 'link-color' );

	// Add support for experimental appearance tools
	add_theme_support( 'appearance-tools' );

	// Add support for HTML5 markup
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Declare WooCommerce support (optional)
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'seiler_2026_setup' );

/**
 * Create default navigation menus on theme activation
 */
function seiler_2026_create_default_navigations() {
	// Check if already created
	if ( get_option( 'seiler_2026_default_navs_created' ) ) {
		return;
	}

	// Create Utility Navigation (Customer Account, Cart, Search)
	$utility_nav_title = 'Header Utility Menu';
	$utility_nav = wp_insert_post( array(
		'post_title'   => $utility_nav_title,
		'post_content' => '<!-- wp:seiler-2026/customer-account-nav /-->

		<!-- wp:seiler-2026/cart-link-nav /-->

		<!-- wp:seiler-2026/search-overlay /-->',
		'post_status'  => 'publish',
		'post_type'    => 'wp_navigation',
	) );

	// Create Main Navigation (Industries, Shop, Resources, etc.)
	$main_nav_title = 'Header Main Menu';
	$main_nav = wp_insert_post( array(
		'post_title'   => $main_nav_title,
		'post_content' => '<!-- wp:navigation-link {"label":"Industries","url":"#","kind":"custom","isTopLevelLink":true} /-->

		<!-- wp:navigation-link {"label":"Shop","url":"' . esc_url( home_url( '/shop/' ) ) . '","kind":"custom","isTopLevelLink":true} /-->

		<!-- wp:navigation-link {"label":"Resources","url":"#","kind":"custom","isTopLevelLink":true} /-->

		<!-- wp:navigation-link {"label":"Events","url":"#","kind":"custom","isTopLevelLink":true} /-->

		<!-- wp:navigation-link {"label":"About","url":"' . esc_url( home_url( '/about/' ) ) . '","kind":"custom","isTopLevelLink":true} /-->

		<!-- wp:navigation-link {"label":"Contact","url":"#","kind":"custom","isTopLevelLink":true} /-->

		<!-- wp:navigation-link {"label":"Rentals","url":"#","kind":"custom","isTopLevelLink":true,"className":"rentals-button"} /-->',
		'post_status'  => 'publish',
		'post_type'    => 'wp_navigation',
	) );

	// Store the created navigation IDs for reference
	update_option( 'seiler_2026_utility_nav_id', $utility_nav );
	update_option( 'seiler_2026_main_nav_id', $main_nav );
	update_option( 'seiler_2026_default_navs_created', true );

	// Update header template part with correct navigation IDs
	seiler_2026_update_header_refs( $utility_nav, $main_nav );

	// Log for debugging
	error_log( sprintf( 'Created default navigations - Utility: %d, Main: %d', $utility_nav, $main_nav ) );
}
add_action( 'after_switch_theme', 'seiler_2026_create_default_navigations' );

/**
 * Create default pages on theme activation.
 * Runs once per activation; skipped on subsequent activations.
 */
function seiler_2026_create_default_pages() {
	if ( get_option( 'seiler_2026_default_pages_created' ) ) {
		return;
	}

	$pages = array(
		array(
			'post_title'  => 'Home',
			'post_name'   => 'home',
			'post_status' => 'publish',
			'post_type'   => 'page',
		),
		array(
			'post_title'  => 'About',
			'post_name'   => 'about',
			'post_status' => 'publish',
			'post_type'   => 'page',
		),
	);

	$home_id = 0;

	foreach ( $pages as $page ) {
		// Skip if a page with this slug already exists.
		$existing = get_page_by_path( $page['post_name'], OBJECT, 'page' );
		if ( $existing ) {
			if ( 'home' === $page['post_name'] ) {
				$home_id = $existing->ID;
			}
			continue;
		}

		$id = wp_insert_post( $page );

		if ( 'home' === $page['post_name'] ) {
			$home_id = $id;
		}
	}

	// Set Home as the static front page.
	if ( $home_id ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $home_id );
	}

	update_option( 'seiler_2026_default_pages_created', true );
}
add_action( 'after_switch_theme', 'seiler_2026_create_default_pages' );

/**
 * Set default site logo on theme activation
 */
function seiler_2026_set_default_logo() {
	// Check if logo is already set
	if ( get_theme_mod( 'custom_logo' ) ) {
		return;
	}

	// Path to the default logo
	$logo_path = get_template_directory() . '/assets/images/Seiler_Logo.png';

	// Check if file exists
	if ( ! file_exists( $logo_path ) ) {
		return;
	}

	// Check if we've already uploaded this logo
	$existing_logo_id = get_option( 'seiler_2026_default_logo_id' );
	if ( $existing_logo_id && get_post( $existing_logo_id ) ) {
		set_theme_mod( 'custom_logo', $existing_logo_id );
		return;
	}

	// Upload the logo to media library
	require_once( ABSPATH . 'wp-admin/includes/file.php' );
	require_once( ABSPATH . 'wp-admin/includes/media.php' );
	require_once( ABSPATH . 'wp-admin/includes/image.php' );

	$file_array = array(
		'name'     => 'Seiler_Logo.png',
		'tmp_name' => $logo_path,
	);

	// Copy file to temp location for upload
	$temp_file = wp_tempnam( 'Seiler_Logo.png' );
	copy( $logo_path, $temp_file );
	$file_array['tmp_name'] = $temp_file;

	// Upload the file
	$logo_id = media_handle_sideload( $file_array, 0, 'Seiler Logo' );

	// Remove temp file
	@unlink( $temp_file );

	if ( is_wp_error( $logo_id ) ) {
		error_log( 'Failed to upload default logo: ' . $logo_id->get_error_message() );
		return;
	}

	// Set as site logo
	set_theme_mod( 'custom_logo', $logo_id );
	update_option( 'seiler_2026_default_logo_id', $logo_id );

	error_log( 'Default site logo set (ID: ' . $logo_id . ')' );
}
add_action( 'after_switch_theme', 'seiler_2026_set_default_logo' );

/**
 * Update header template part with correct navigation refs
 */
function seiler_2026_update_header_refs( $utility_nav_id, $main_nav_id ) {
	// Find the header template part
	$header = get_posts( array(
		'post_type'      => 'wp_template_part',
		'name'           => 'header',
		'posts_per_page' => 1,
		'post_status'    => 'publish',
	) );

	if ( empty( $header ) ) {
		return;
	}

	$header_post = $header[0];
	$content = $header_post->post_content;

	// Find and replace navigation blocks with correct refs
	// First navigation (utility)
	$content = preg_replace(
		'/<!-- wp:navigation \{([^}]*)"metadata":\{"ignoredHookedBlocks":\["woocommerce\/customer-account","woocommerce\/mini-cart"\]\}/',
		'<!-- wp:navigation {"ref":'.$utility_nav_id.',$1"metadata":{"ignoredHookedBlocks":["woocommerce/customer-account","woocommerce/mini-cart"]}',
		$content,
		1
	);

	// Second navigation (main)
	$content = preg_replace(
		'/<!-- wp:navigation \{([^}]*)"textColor":"primary"([^}]*)"metadata":\{"ignoredHookedBlocks":\["woocommerce\/customer-account"\]\}/',
		'<!-- wp:navigation {"ref":'.$main_nav_id.',$1"textColor":"primary"$2"metadata":{"ignoredHookedBlocks":["woocommerce/customer-account"]}',
		$content,
		1
	);

	// Update the template part
	wp_update_post( array(
		'ID'           => $header_post->ID,
		'post_content' => $content,
	) );

	error_log( 'Updated header template part with navigation refs' );
}

/**
 * Show admin notice after theme activation
 */
function seiler_2026_activation_notice() {
	$utility_id = get_option( 'seiler_2026_utility_nav_id' );
	$main_id = get_option( 'seiler_2026_main_nav_id' );

	if ( ! $utility_id || ! $main_id ) {
		return;
	}

	// Only show once
	if ( get_option( 'seiler_2026_activation_notice_shown' ) ) {
		return;
	}

	?>
	<div class="notice notice-success is-dismissible">
		<h3><?php esc_html_e( 'Seiler 2026 Theme Activated!', 'seiler-2026' ); ?></h3>
		<p><?php esc_html_e( 'Default navigation menus have been created:', 'seiler-2026' ); ?></p>
		<ul style="list-style: disc; margin-left: 20px;">
			<li><strong>Header Utility Menu</strong> (ID: <?php echo esc_html( $utility_id ); ?>) - Login, Cart, Search</li>
			<li><strong>Header Main Menu</strong> (ID: <?php echo esc_html( $main_id ); ?>) - Industries, Shop, Resources, etc.</li>
		</ul>
		<p>
			<?php esc_html_e( 'You can customize these menus in:', 'seiler-2026' ); ?>
			<strong><?php esc_html_e( 'Appearance → Editor → Navigation', 'seiler-2026' ); ?></strong>
		</p>
	</div>
	<?php

	update_option( 'seiler_2026_activation_notice_shown', true );
}
add_action( 'admin_notices', 'seiler_2026_activation_notice' );

/**
 * Enqueue dashicons for block editor
 */
function seiler_2026_enqueue_editor_assets() {
	wp_enqueue_style( 'dashicons' );
}
add_action( 'enqueue_block_editor_assets', 'seiler_2026_enqueue_editor_assets' );

/**
 * Register custom block styles for core/button.
 * These appear in the FSE block inspector under "Styles" and replace
 * hardcoded per-block backgroundColor/textColor attributes in patterns.
 */
function seiler_2026_register_block_styles() {
	register_block_style( 'core/button', [
		'name'  => 'accent',
		'label' => 'Accent',
	] );
	register_block_style( 'core/button', [
		'name'  => 'on-dark',
		'label' => 'On Dark',
	] );
	register_block_style( 'core/button', [
		'name'  => 'alternate',
		'label' => 'Alternate',
	] );

	// Entrance animation styles (keyframe) — appear in the block Style picker.
	$animation_blocks = [ 'core/group', 'core/cover', 'core/image', 'core/heading', 'core/paragraph', 'core/columns', 'core/column' ];
	foreach ( $animation_blocks as $block ) {
		register_block_style( $block, [
			'name'  => 'fade-in',
			'label' => 'Fade In',
		] );
		register_block_style( $block, [
			'name'  => 'slide-in-left',
			'label' => 'Slide In Left',
		] );
	}

	// Hover interaction styles — expose the hover lift/scale effects used on
	// cards and images so editors can apply them to any compatible block.
	$hover_blocks = [ 'core/group', 'core/image', 'core/cover', 'core/columns', 'core/column' ];
	foreach ( $hover_blocks as $block ) {
		register_block_style( $block, [
			'name'  => 'hover-lift',
			'label' => 'Hover Lift',
		] );
		register_block_style( $block, [
			'name'  => 'hover-scale',
			'label' => 'Hover Scale',
		] );
	}

}
add_action( 'init', 'seiler_2026_register_block_styles' );

/**
 * Enqueue theme styles in the FSE canvas iframe only.
 *
 * _wp_get_iframed_editor_assets() calls do_action('enqueue_block_assets') inside
 * a sandboxed WP_Styles context while the 'should_load_block_editor_scripts_and_styles'
 * filter is set to false. We use that signal to distinguish canvas collection
 * (inject) from the outer admin page (skip, would bleed into FSE chrome).
 *
 * Frontend enqueuing is handled separately by seiler_2026_enqueue_assets()
 * on wp_enqueue_scripts — do NOT add a frontend branch here to avoid double-loading.
 */
function seiler_2026_enqueue_canvas_styles() {
	// Only run inside the FSE editor canvas iframe — NOT on the frontend.
	$in_canvas = is_admin() && ! apply_filters( 'should_load_block_editor_scripts_and_styles', true );

	if ( ! $in_canvas ) {
		return;
	}

	wp_enqueue_style(
		'seiler-2026-google-fonts',
		'https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@400;600;700&family=Exo+2:wght@600;700;800;900&display=swap',
		array(),
		null
	);

	wp_enqueue_style(
		'seiler-2026-style',
		get_template_directory_uri() . '/assets/css/theme.css',
		array( 'seiler-2026-google-fonts' ),
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'enqueue_block_assets', 'seiler_2026_enqueue_canvas_styles' );


/**
 * Enqueue theme styles and scripts
 */
function seiler_2026_enqueue_assets() {
	// Enqueue dashicons (for cart, search, user icons)
	wp_enqueue_style( 'dashicons' );

	// Preconnect to Google Fonts to reduce FOUT
	wp_enqueue_style( 'google-fonts-preconnect', 'https://fonts.googleapis.com', array(), null );
	wp_enqueue_style( 'google-fonts-preconnect-gstatic', 'https://fonts.gstatic.com', array(), null );
	add_filter( 'style_loader_tag', function( $html, $handle ) {
		if ( in_array( $handle, array( 'google-fonts-preconnect', 'google-fonts-preconnect-gstatic' ), true ) ) {
			$crossorigin = ( 'google-fonts-preconnect-gstatic' === $handle ) ? ' crossorigin' : '';
			$href = ( 'google-fonts-preconnect' === $handle ) ? 'https://fonts.googleapis.com' : 'https://fonts.gstatic.com';
			return '<link rel="preconnect" href="' . $href . '"' . $crossorigin . '>' . "\n";
		}
		return $html;
	}, 10, 2 );

	// Enqueue Google Fonts
	wp_enqueue_style(
		'google-fonts',
		'https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@400;600;700&family=Exo+2:wght@600;700;800;900&display=swap',
		array( 'google-fonts-preconnect', 'google-fonts-preconnect-gstatic' ),
		null
	);

	// Enqueue main stylesheet (style.css)
	wp_enqueue_style(
		'seiler-2026-style',
		get_stylesheet_uri(),
		array(),
		wp_get_theme()->get( 'Version' )
	);

	// Enqueue custom theme styles
	wp_enqueue_style(
		'seiler-2026-theme-css',
		get_template_directory_uri() . '/assets/css/theme.css',
		array( 'seiler-2026-style' ),
		wp_get_theme()->get( 'Version' )
	);

	// Block styles and scripts are automatically loaded from block.json
	// via the JavaScript registerBlockType() in index.js files

	// Enqueue header JavaScript for search overlay
	wp_enqueue_script(
		'seiler-2026-header',
		get_template_directory_uri() . '/assets/js/header.js',
		array(),
		wp_get_theme()->get( 'Version' ),
		true
	);

	// Enqueue minimal theme JavaScript if needed
	wp_enqueue_script(
		'seiler-2026-script',
		get_template_directory_uri() . '/assets/js/theme.js',
		array(),
		wp_get_theme()->get( 'Version' ),
		true
	);
}
add_action( 'wp_enqueue_scripts', 'seiler_2026_enqueue_assets' );

/**
 * Enqueue block styles on frontend
 */
function seiler_2026_enqueue_block_styles() {
	// Block styles are automatically loaded from block.json
	// No need to manually enqueue them here
}
add_action( 'wp_enqueue_scripts', 'seiler_2026_enqueue_block_styles' );

/**
 * Register block pattern categories
 */
function seiler_2026_register_pattern_categories() {
	register_block_pattern_category(
		'seiler-hero',
		array( 'label' => __( 'Hero Sections', 'seiler-2026' ) )
	);

	register_block_pattern_category(
		'seiler-features',
		array( 'label' => __( 'Features', 'seiler-2026' ) )
	);

	register_block_pattern_category(
		'seiler-content',
		array( 'label' => __( 'Content Sections', 'seiler-2026' ) )
	);

	register_block_pattern_category(
		'seiler-testimonials',
		array( 'label' => __( 'Testimonials', 'seiler-2026' ) )
	);

	register_block_pattern_category(
		'seiler-cta',
		array( 'label' => __( 'Call to Action', 'seiler-2026' ) )
	);
}
add_action( 'init', 'seiler_2026_register_pattern_categories' );

/**
 * Admin notice for recommended Splide Carousel plugin
 */
function seiler_2026_admin_notice_splide() {
	// Check if Splide Carousel plugin is active
	if ( is_plugin_active( 'splide-carousel/splide-carousel.php' ) ) {
		return;
	}

	// Check if user has dismissed the notice
	if ( get_user_meta( get_current_user_id(), 'seiler_2026_dismiss_splide_notice', true ) ) {
		return;
	}

	$plugin_install_url = admin_url( 'plugin-install.php?s=splide+carousel&tab=search&type=term' );
	?>
	<div class="notice notice-info is-dismissible seiler-splide-notice">
		<p>
			<strong><?php esc_html_e( 'Seiler 2026 Theme:', 'seiler-2026' ); ?></strong>
			<?php
			printf(
				/* translators: %s: Plugin installation URL */
				esc_html__( 'For the best experience with carousel sliders, we recommend installing the %s plugin.', 'seiler-2026' ),
				'<a href="' . esc_url( $plugin_install_url ) . '">Splide Carousel</a>'
			);
			?>
		</p>
	</div>
	<?php
}
add_action( 'admin_notices', 'seiler_2026_admin_notice_splide' );

/**
 * Handle dismissal of Splide notice
 */
function seiler_2026_dismiss_splide_notice() {
	if ( isset( $_GET['seiler-dismiss-splide'] ) ) {
		update_user_meta( get_current_user_id(), 'seiler_2026_dismiss_splide_notice', true );
	}
}
add_action( 'admin_init', 'seiler_2026_dismiss_splide_notice' );

/**
 * Add custom JavaScript for notice dismissal
 */
function seiler_2026_admin_scripts() {
	?>
	<script>
	jQuery(document).ready(function($) {
		$(document).on('click', '.seiler-splide-notice .notice-dismiss', function() {
			$.ajax({
				url: ajaxurl,
				data: {
					action: 'seiler_2026_dismiss_splide_notice'
				}
			});
		});
	});
	</script>
	<?php
}
add_action( 'admin_footer', 'seiler_2026_admin_scripts' );

/**
 * AJAX handler for dismissing Splide notice
 */
function seiler_2026_ajax_dismiss_splide_notice() {
	update_user_meta( get_current_user_id(), 'seiler_2026_dismiss_splide_notice', true );
	wp_die();
}
add_action( 'wp_ajax_seiler_2026_dismiss_splide_notice', 'seiler_2026_ajax_dismiss_splide_notice' );

/**
 * Render search overlay block
 */
function seiler_2026_render_search_overlay( $attributes ) {
	$placeholder = isset( $attributes['placeholder'] ) ? esc_attr( $attributes['placeholder'] ) : 'Search...';
	$button_text = isset( $attributes['buttonText'] ) ? esc_attr( $attributes['buttonText'] ) : 'Search';

	ob_start();
	?>
	<div class="header-search-block wp-block-seiler-2026-search-overlay">
		<button type="button" class="header-search-toggle" aria-label="<?php echo $button_text; ?>" data-search-toggle>
			<span class="dashicons dashicons-search"></span>
		</button>
		<div class="header-search-container" data-search-overlay>
			<div class="header-search-inner">
				<form role="search" method="get" class="header-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<input type="search" class="header-search-input" placeholder="<?php echo $placeholder; ?>" name="s" required />
					<button type="submit" class="header-search-submit" aria-label="Submit search">
						<span class="dashicons dashicons-search"></span>
					</button>
				</form>
				<button type="button" class="header-search-close" aria-label="Close search" data-search-close>
					<span class="dashicons dashicons-no-alt"></span>
				</button>
			</div>
		</div>
	</div>
	<?php
	return ob_get_clean();
}

/**
 * Register custom blocks
 */
function seiler_2026_register_blocks() {
	$build_dir = __DIR__ . '/build/blocks';
	$build_uri = get_template_directory_uri() . '/build/blocks';

	// Register search overlay block
	register_block_type( 'seiler-2026/search-overlay', array(
		'api_version' => 3,
		'title' => __( 'Search with Overlay', 'seiler-2026' ),
		'category' => 'widgets',
		'icon' => 'search',
		'description' => __( 'Search form that opens in an overlay', 'seiler-2026' ),
		'keywords' => array( 'search', 'overlay', 'flyout' ),
		'parent' => array( 'core/navigation' ),
		'supports' => array(
			'html' => false,
			'align' => false,
			'spacing' => array(
				'margin' => true,
				'padding' => true,
			),
		),
		'attributes' => array(
			'placeholder' => array(
				'type' => 'string',
				'default' => 'Search...',
			),
			'buttonText' => array(
				'type' => 'string',
				'default' => 'Search',
			),
		),
		'editor_script' => 'seiler-2026-search-overlay-editor',
		'render_callback' => 'seiler_2026_render_search_overlay',
	) );

	// Register cart link nav block
	register_block_type( 'seiler-2026/cart-link-nav', array(
		'api_version' => 3,
		'title' => __( 'Cart Link (Nav)', 'seiler-2026' ),
		'category' => 'widgets',
		'icon' => 'cart',
		'description' => __( 'WooCommerce cart link for navigation', 'seiler-2026' ),
		'parent' => array( 'core/navigation' ),
		'supports' => array(
			'html' => false,
			'align' => false,
		),
		'attributes' => array(
			'showIcon' => array(
				'type' => 'boolean',
				'default' => true,
			),
			'showText' => array(
				'type' => 'boolean',
				'default' => true,
			),
			'showCount' => array(
				'type' => 'boolean',
				'default' => true,
			),
		),
		'editor_script' => 'seiler-2026-cart-link-nav-editor',
		'render_callback' => 'seiler_2026_render_cart_link_nav',
	) );

	// Register customer account nav block
	register_block_type( 'seiler-2026/customer-account-nav', array(
		'api_version' => 3,
		'title' => __( 'Customer Account (Nav)', 'seiler-2026' ),
		'category' => 'widgets',
		'icon' => 'admin-users',
		'description' => __( 'Customer account link with dropdown for navigation', 'seiler-2026' ),
		'parent' => array( 'core/navigation' ),
		'supports' => array(
			'html' => false,
			'align' => false,
		),
		'attributes' => array(
			'showIcon' => array(
				'type' => 'boolean',
				'default' => true,
			),
			'showText' => array(
				'type' => 'boolean',
				'default' => true,
			),
			'showDropdown' => array(
				'type' => 'boolean',
				'default' => true,
			),
			'loggedOutText' => array(
				'type' => 'string',
				'default' => 'Login',
			),
		),
		'editor_script' => 'seiler-2026-customer-account-nav-editor',
		'render_callback' => 'seiler_2026_render_customer_account_nav',
	) );

	// Enqueue block editor scripts with asset file dependencies
	$search_overlay_asset = require $build_dir . '/search-overlay/index.asset.php';
	wp_register_script(
		'seiler-2026-search-overlay-editor',
		$build_uri . '/search-overlay/index.js',
		$search_overlay_asset['dependencies'],
		$search_overlay_asset['version']
	);

	$cart_link_asset = require $build_dir . '/cart-link-nav/index.asset.php';
	wp_register_script(
		'seiler-2026-cart-link-nav-editor',
		$build_uri . '/cart-link-nav/index.js',
		$cart_link_asset['dependencies'],
		$cart_link_asset['version']
	);

	$customer_account_asset = require $build_dir . '/customer-account-nav/index.asset.php';
	wp_register_script(
		'seiler-2026-customer-account-nav-editor',
		$build_uri . '/customer-account-nav/index.js',
		$customer_account_asset['dependencies'],
		$customer_account_asset['version']
	);

	// Block styles are included in main theme.css, no need for separate files
}
add_action( 'init', 'seiler_2026_register_blocks' );

/**
 * Render cart link nav block
 */
function seiler_2026_render_cart_link_nav( $attributes ) {
	if ( ! function_exists( 'WC' ) ) {
		return '';
	}

	$show_icon = isset( $attributes['showIcon'] ) ? $attributes['showIcon'] : true;
	$show_text = isset( $attributes['showText'] ) ? $attributes['showText'] : true;
	$show_count = isset( $attributes['showCount'] ) ? $attributes['showCount'] : true;

	$cart_url = wc_get_cart_url();
	$cart_count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;

	ob_start();
	?>
	<div class="cart-link-nav-block">
		<a href="<?php echo esc_url( $cart_url ); ?>" class="cart-link-nav">
			<?php if ( $show_icon ) : ?>
				<span class="dashicons dashicons-cart"></span>
			<?php endif; ?>
			<?php if ( $show_text ) : ?>
				<span class="cart-text">Cart</span>
			<?php endif; ?>
			<?php if ( $show_count ) : ?>
				<span class="cart-count">(<span class="cart-count-number"><?php echo esc_html( $cart_count ); ?></span>)</span>
			<?php endif; ?>
		</a>
	</div>
	<?php
	return ob_get_clean();
}

/**
 * Render customer account nav block
 */
function seiler_2026_render_customer_account_nav( $attributes ) {
	$show_icon = isset( $attributes['showIcon'] ) ? $attributes['showIcon'] : true;
	$show_text = isset( $attributes['showText'] ) ? $attributes['showText'] : true;
	$show_dropdown = isset( $attributes['showDropdown'] ) ? $attributes['showDropdown'] : true;
	$logged_out_text = isset( $attributes['loggedOutText'] ) ? $attributes['loggedOutText'] : 'Login';

	$is_logged_in = is_user_logged_in();
	$account_url = function_exists( 'wc_get_account_endpoint_url' )
		? wc_get_account_endpoint_url( 'dashboard' )
		: home_url( '/my-account/' );

	ob_start();
	?>
	<div class="customer-account-nav-block">
		<?php if ( $is_logged_in && $show_dropdown ) : ?>
			<button type="button" class="customer-account-nav" data-account-toggle>
				<?php if ( $show_icon ) : ?>
					<span class="dashicons dashicons-admin-users"></span>
				<?php endif; ?>
				<?php if ( $show_text ) : ?>
					<span class="account-text"><?php echo esc_html__( 'Account', 'seiler-2026' ); ?></span>
				<?php endif; ?>
				<span class="dashicons dashicons-arrow-down-alt2" style="font-size: 12px;"></span>
			</button>
			<div class="customer-account-dropdown">
				<?php
				if ( function_exists( 'wc_get_account_menu_items' ) ) :
					foreach ( wc_get_account_menu_items() as $endpoint => $label ) :
						$url = wc_get_account_endpoint_url( $endpoint );
						$icon_class = 'dashicons-admin-generic';

						// Set icons based on endpoint
						switch ( $endpoint ) {
							case 'dashboard':
								$icon_class = 'dashicons-dashboard';
								break;
							case 'orders':
								$icon_class = 'dashicons-cart';
								break;
							case 'downloads':
								$icon_class = 'dashicons-download';
								break;
							case 'edit-address':
								$icon_class = 'dashicons-location';
								break;
							case 'edit-account':
								$icon_class = 'dashicons-admin-users';
								break;
							case 'customer-logout':
								$icon_class = 'dashicons-exit';
								break;
						}
						?>
						<a href="<?php echo esc_url( $url ); ?>" class="account-dropdown-item">
							<span class="dashicons <?php echo esc_attr( $icon_class ); ?>"></span>
							<?php echo esc_html( $label ); ?>
						</a>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		<?php else : ?>
			<a href="<?php echo esc_url( $account_url ); ?>" class="customer-account-nav">
				<?php if ( $show_icon ) : ?>
					<span class="dashicons dashicons-admin-users"></span>
				<?php endif; ?>
				<?php if ( $show_text ) : ?>
					<span class="account-text">
						<?php echo esc_html( $is_logged_in ? __( 'Account', 'seiler-2026' ) : $logged_out_text ); ?>
					</span>
				<?php endif; ?>
			</a>
		<?php endif; ?>
	</div>
	<?php
	return ob_get_clean();
}

/**
 * Remove all default WordPress core block patterns
 */
function seiler_2026_remove_core_patterns() {
	// Remove core pattern support
	remove_theme_support( 'core-block-patterns' );
}
add_action( 'after_setup_theme', 'seiler_2026_remove_core_patterns' );

/**
 * Remove patterns from third-party plugins (keep only our theme patterns)
 */
function seiler_2026_unregister_third_party_patterns() {
	// Get all registered patterns
	$patterns = WP_Block_Patterns_Registry::get_instance()->get_all_registered();

	// Unregister patterns that aren't from our theme
	foreach ( $patterns as $pattern ) {
		// Keep only our theme patterns (seiler-2026/*)
		if ( strpos( $pattern['name'], 'seiler-2026/' ) === false ) {
			unregister_block_pattern( $pattern['name'] );
		}
	}
}
add_action( 'init', 'seiler_2026_unregister_third_party_patterns', 15 );

/**
 * Suppress empty core/post-excerpt render.
 *
 * WP core's post-excerpt block renders `<p class="wp-block-post-excerpt__excerpt"> </p>`
 * (with a hardcoded leading space before the more-link) even when both the excerpt
 * and more-text are empty — defeating CSS `:empty` / `:has()` targeting.
 * Upstream: gutenberg#30571, partially-reverted PR#35749.
 */
add_filter( 'render_block_core/post-excerpt', function( $html ) {
	return trim( wp_strip_all_tags( $html ) ) === '' ? '' : $html;
} );
