<?php

/**
 *	Customize WordPress with ACF Pro
 *	https://www.advancedcustomfields.com/resources/including-acf-within-a-plugin-or-theme/
 */

//	1. Define path and URL to the ACF plugin.
define( 'MY_ACF_PATH', get_stylesheet_directory() . '/inc/tools/advanced-custom-fields-pro/' );
define( 'MY_ACF_URL', get_stylesheet_directory_uri() . '/inc/tools/advanced-custom-fields-pro/' );

//	2. Include the ACF plugin.
include_once( MY_ACF_PATH . 'acf.php' );

//	3. Customize the url setting to fix incorrect asset URLs.
add_filter('acf/settings/url', 'my_acf_settings_url');

function my_acf_settings_url( $url ) {
    return MY_ACF_URL;
}

//	4. Hide the ACF admin menu item.
add_filter('acf/settings/show_admin', 'my_acf_settings_show_admin');

function my_acf_settings_show_admin( $show_admin ) {
    return ( defined('WP_LOCALHOST') && WP_LOCALHOST == true) ? true : false;
}

//	5. Custom Options Settings via ACF Options feature
//	https://www.advancedcustomfields.com/resources/options-page/
include_once(get_stylesheet_directory() . '/inc/setup/custom-options-setup.php');


//	6.  Custom Fields Setup via Local JSON - Customize ACF JSON path
//	https://www.advancedcustomfields.com/resources/local-json/
add_filter('acf/settings/save_json', 'my_acf_json_save_point');

function my_acf_json_save_point( $path ) {
    $path = get_stylesheet_directory() . '/inc/acf-json';
    return $path; 
}

//	7. Load ACF data from json
add_filter('acf/settings/load_json', 'my_acf_json_load_point');

function my_acf_json_load_point( $paths ) {
    // remove original path (optional)
    unset($paths[0]);
    
    // append path
    $paths[] = get_stylesheet_directory() . '/inc/acf-json';
    
    return $paths;
}

// 8. Enhance ACF with ACF Extended
// https://wordpress.org/support/topic/include-acf-extended-with-a-plugin/#post-12363717

define('MY_ACFE_PATH', get_stylesheet_directory() . '/inc/tools/acf-extended-pro/');
define('MY_ACFE_URL', get_stylesheet_directory_uri() . '/inc/tools/acf-extended-pro/');

include_once(MY_ACFE_PATH . 'acf-extended.php');

function my_acfe_settings_url($url) {
    return MY_ACFE_URL;
}

add_filter('acf/settings/acfe/url', 'my_acfe_settings_url');
