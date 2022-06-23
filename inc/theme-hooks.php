<?php

/**
 * Theme hooks
 * author: Piotr Merton
 *
 */

/**
 * Init
 * @see theme_disable_emojis()
 */
if( !is_admin() ) add_action( 'init', 'theme_disable_emojis' );	


/**
 * Header front-end markup cleanup
 */
remove_action( 'wp_head', 'rel_canonical');
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'rsd_link');
remove_action( 'wp_head', 'wlwmanifest_link');
remove_action( 'wp_head', 'index_rel_link');
remove_action( 'wp_head', 'parent_post_rel_link');
remove_action( 'wp_head', 'start_post_rel_link');
remove_action( 'wp_head', 'wp_generator');
remove_action( 'wp_head', 'rest_output_link_wp_head');
remove_action( 'wp_head', 'wp_resource_hints', 2 );

// Turn off oEmbed auto discovery and Remove oEmbed discovery links.
remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
remove_action('wp_head', 'wp_oembed_add_discovery_links');

// Remove oEmbed-specific JavaScript from the front-end and back-end.
remove_action('wp_head', 'wp_oembed_add_host_js');

//remove_action( 'template_redirect', 'rest_output_link_header', 11, 0 );

//disable XML RPC
add_filter('xmlrpc_enabled', '__return_false');

//remove favicon
add_action( 'do_faviconico', 'theme_remove_wordpress_favicon');

//remove CSS related to Gutenberg introduced in 5.0
add_action( 'wp_print_styles', 'theme_remove_gutenberg_css', 100 );

/**
 * Footer
 *
 * @see theme_deregister_scripts()
 * @see theme_enqueue_frontend_scripts()
 * @see theme_deregister_jquery()
 */
add_action( 'wp_footer', 'theme_deregister_scripts' );

if (!is_admin()) {
    add_action( 'wp_enqueue_scripts', 'theme_enqueue_frontend_scripts', 5 );
    add_action( 'wp_enqueue_scripts', 'theme_deregister_jquery', 10 );

}

/**
 * Back office admin area
 * @see theme_remove_admin_menus()
 * @see theme_login_url()
 * @see theme_remove_meta_boxes()
 */
add_action( 'admin_menu', 'theme_remove_admin_menus' );
add_action( 'login_head', 'theme_enqueue_backend_scripts' );
add_action( 'admin_head', 'theme_enqueue_backend_scripts' );
add_filter( 'login_headerurl', 'theme_login_url' );
add_action( 'do_meta_boxes', 'theme_remove_meta_boxes' );
add_action( 'after_setup_theme', 'theme_remove_admin_bar_for_users' );

/**
 * shortcodes
 * see inc/theme-shortcodes.php
 */
add_shortcode('link', 'theme_shortcode_permalinks');

/**
 * Edit Posts/Pages screen management
 * @see theme_add_custom_taxonomy_filter_to_edit_screen()
 */
add_action( 'restrict_manage_posts', function ( $post_type, $which ) {
    if ( 'top' === $which && $post_type == 'game' ) {
        theme_add_custom_taxonomy_filter_to_edit_screen('competition');
        theme_add_custom_taxonomy_filter_to_edit_screen('season');
    }
    if ( 'top' === $which && $post_type == 'team' ) {
        theme_add_custom_taxonomy_filter_to_edit_screen('country');
    } 
    if ( 'top' === $which && $post_type == 'player' ) {
        theme_add_custom_taxonomy_filter_to_edit_screen('player_status');
    }       
}, 10, 2 );



/**
 * Custom logic on Save Post hooks
 **/

/**
 * https://developer.wordpress.org/reference/hooks/save_post/
 * @see theme_delete_transients()
 **/
add_action( 'save_post', 'theme_delete_transients', 10, 2 );

/**
 * when ACF saves the $_POST['fields'] data
 * https://www.advancedcustomfields.com/resources/acf-save_post/
 * @see theme_update_cpt_game_title()
 **/
add_action('acf/save_post', 'theme_update_cpt_game_title', 20);

/**
 * Customize ACF select field
 * https://www.advancedcustomfields.com/resources/dynamically-populate-a-select-fields-choices/
 * @see theme_update_acf_player_id_api()
 */
add_filter('acf/load_field/name=id_player_api', 'theme_update_acf_player_id_api');


/**
 * Reorder comments on demand
 **/
add_filter( 'pre_get_comments', 'theme_reorder_comments' );
