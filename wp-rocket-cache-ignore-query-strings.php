<?php
/**
 * Plugin Name: WP Rocket | Ignore Query Strings
 * Description: Define query strings that should use the same set of cache.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/cache/wp-rocket-cache-ignore-query-strings
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2019
 */
// Namespaces must be declared before any other declaration.
namespace WP_Rocket\Helpers\cache\ignore_query_strings;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Add new parameters or remove existing ones.
 * You can add new parameter by editing or copying existing line and changing its name in brackets (new_query_string).
 * To prevent WP Rocket from caching specific parameter, uncomment 30th line of code and change value (utm_source) to the desired one.
 * If you want WP Rocket stop serving cache for more parameters, simply copy the 30th line and change the value.  
 *
 * @author Piotr Bąk
 */
function define_ignored_parameters( array $params ) {
	
	$params['hss_channel'] = 1;
	$params['hsa_acc'] = 2;
	$params['hsa_cam'] = 3;
	$params['hsa_grp'] = 4;
	$params['hsa_ad'] = 5;
	$params['hsa_src'] = 6;
	$params['hsa_tgt'] = 7;
	$params['hsa_kw'] = 8;
	$params['hsa_mtsa_ne'] = 9;
	$params['hsa_ver'] = 10;
	$params['hsa_mt'] = 11;
	$params['hsa_net'] = 12;
	$params['__hstc'] = 13;
	$params['__hssc'] = 14;
	$params['__hsfp'] = 15;
	$params['_hsmi'] = 16;
	$params['_hsenc'] = 17;
	$params['hsutk'] = 18;
	$params['hsCtaTracking'] = 19;
	$params['submissionGuid'] = 20;
	$params['hsa_la'] = 21;
	$params['hsa_ol'] = 22;
	return $params;
}
// Filter rocket_cache_ignored_parameters parameters
add_filter( 'rocket_cache_ignored_parameters', __NAMESPACE__ . '\define_ignored_parameters', 999 );

/**
 * Updates .htaccess, regenerates WP Rocket config file.
 *
 * @author Piotr Bąk
 */
function flush_wp_rocket() {

	if ( ! function_exists( 'rocket_generate_config_file' ) ) {
		return false;
	}

	// Regenerate WP Rocket config file.
	rocket_generate_config_file();
}
register_activation_hook( __FILE__, __NAMESPACE__ . '\flush_wp_rocket' );

/**
 * Removes customizations, updates .htaccess, regenerates config file.
 *
 * @author Piotr Bąk
 */
function deactivate() {

	// Remove all functionality added above.
	remove_filter( 'rocket_cache_ignored_parameters', __NAMESPACE__ . '\define_ignored_parameters' );

	// Flush .htaccess rules, and regenerate WP Rocket config file.
	flush_wp_rocket();
}
register_deactivation_hook( __FILE__, __NAMESPACE__ . '\deactivate' );
