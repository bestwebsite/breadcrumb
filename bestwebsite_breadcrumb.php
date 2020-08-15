<?php
/**
 * Plugin Name: Bestwebsite Breadcrumb
 * Plugin URI:  https://github.com/bestwebsite/breadcrumb
 * Version:     1.1.0
 * Author:      bestwebsite
 * Author URI:  https://bestwebsite.com
 * Text Domain: bestwebsite-breadcrumb
 */

# Extra check in case the script is being loaded by a theme.
if ( ! function_exists( 'bestwebsite_breadcrumb' ) )
	require_once( 'inc/breadcrumbs.php' );

# Plugin setup callback.
add_action( 'plugins_loaded', 'bestwebsite_breadcrumb_setup' );

# Check theme support. */
add_action( 'after_setup_theme', 'bestwebsite_breadcrumb_theme_setup', 12 );

/**
 * Plugin setup. For now, it just loads the translation.
 *
 * @since  1.1.0
 * @access public
 * @return void
 */
function bestwebsite_breadcrumb_setup() {

	load_plugin_textdomain( 'breadcrumb-trail', false, trailingslashit( dirname( plugin_basename( __FILE__ ) ) ) . 'lang' );
}

/**
 * Checks if the theme supports the Breadcrumb Trail script.  If it doesn't, we'll hook some styles
 * into the header.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function bestwebsite_breadcrumb_theme_setup() {

	if ( ! current_theme_supports( 'breadcrumb-trail' ) )
		add_action( 'wp_head', 'bestwebsite_breadcrumb_print_styles' );
}

/**
 * Prints CSS styles in the header for themes that don't support Breadcrumb Trail.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function bestwebsite_breadcrumb_print_styles() {

	$style = '
		.breadcrumbs .trail-browse,
		.breadcrumbs .trail-items,
		.breadcrumbs .trail-items li {
			display:     inline-block;
			margin:      0;
			padding:     0;
			border:      none;
			background:  transparent;
			text-indent: 0;
		}

		.breadcrumbs .trail-browse {
			font-size:   inherit;
			font-style:  inherit;
			font-weight: inherit;
			color:       inherit;
		}

		.breadcrumbs .trail-items {
			list-style: none;
		}

			.trail-items li::after {
				content: "\002F";
				padding: 0 0.5em;
			}

			.trail-items li:last-of-type::after {
				display: none;
			}';

	$style = apply_filters( 'bestwebsite_breadcrumb_inline_style', trim( str_replace( array( "\r", "\n", "\t", "  " ), '', $style ) ) );

	if ( $style )
		echo "\n" . '<style type="text/css" id="breadcrumb-trail-css">' . $style . '</style>' . "\n";
}
