<?php

/**
 * Theme related functions
 * author: Piotr Merton
 *
 */

/**
 * Localize the script with new data: makes some server-side data available to js from the server side of
 */
function theme_enqueue_frontend_scripts()
{
    global $theme_vars, $theme_endpoints, $rest_url, $lang;

    // Register the scripts
    wp_register_script(
        "js_bundle",
        get_template_directory_uri() . "/assets/js/global.bundle.js",
        [],
        "1637097512",
        true
    );
    //some context related functions (is_home) and filters (wpml_object_id) doesn't work during bootup, so we need to wrap them in hook
    //see: https://wordpress.stackexchange.com/a/47305
    $theme_vars["is_home"] = is_home();

    //https://codex.wordpress.org/Function_Reference/wp_localize_script
    wp_localize_script("js_bundle", "wp_core", $theme_vars);

    // Enqueue script with localized data
    wp_enqueue_script("js_bundle");

    if (is_home()) {
        wp_enqueue_script("index");
    }

    // Threaded comment reply styles.
    if (is_singular() && comments_open() && get_option("thread_comments")) {
        wp_enqueue_script("comment-reply");
    }
}

/**
 * Load custom stylesheet for WordPress Admin Area and Login Page
 */
function theme_enqueue_backend_scripts()
{
    wp_enqueue_style(
        "admin_css",
        get_template_directory_uri() . "/assets/css/admin.css"
    );

    //custom CSS to TinyMCE WYSIWYG editor
    //add_editor_style( get_template_directory_uri(). '/assets/css/editor.css' );
}

/**
 * Deregister unwanted scripts
 */
function theme_deregister_scripts()
{
    wp_deregister_script("wp-embed");
}

/**
 * Remove Guntenberg related CSS stylesheets introduced in 5.0
 * https://stackoverflow.com/a/52280110
 */
function theme_remove_gutenberg_css()
{
    wp_dequeue_style("global-styles"); //global inline styles introduced in 5.9
    wp_dequeue_style("wp-block-library");
    wp_deregister_style("wp-block-library");
}

/**
 * Disable emojis
 * https://wordpress.stackexchange.com/a/185578
 */
function theme_disable_emojis()
{
    // all actions related to emojis
    remove_action("admin_print_styles", "print_emoji_styles");
    remove_action("wp_head", "print_emoji_detection_script", 7);
    remove_action("admin_print_scripts", "print_emoji_detection_script");
    remove_action("wp_print_styles", "print_emoji_styles");
    remove_filter("wp_mail", "wp_staticize_emoji_for_email");
    remove_filter("the_content_feed", "wp_staticize_emoji");
    remove_filter("comment_text_rss", "wp_staticize_emoji");
}

/**
 * Customize Back Office menu
 * Removes Posts and Comments section from admin Back office menu
 */
function theme_remove_admin_menus()
{
    global $submenu;

    // remove customize link
    unset($submenu["themes.php"][6]);

    // remove Theme My Login plugin Menu, but not on localhost
    if (defined("WP_LOCALHOST") && WP_LOCALHOST != true) {
        remove_menu_page("theme-my-login");
    }
}

/**
 * Remove native Meta Boxes
 */
function theme_remove_meta_boxes()
{
    // remove native Meta Boxes - we will re-add it later using ACF with better UI
    remove_meta_box("postimagediv", "post", "side"); //Post Thumbnail
    remove_meta_box("categorydiv", "post", "side"); //Categories
}

/**
 * Use own external URL in admin login screen
 * http://wp.smashingmagazine.com/2012/05/17/customize-wordpress-admin-easily/
 */
function theme_login_url()
{
    return home_url();
}

/**
 * Deregister jQuery in order to serve it via CDN (but don't enqueue - by default we are not using it, but some plugins might)
 * https://css-tricks.com/snippets/wordpress/include-jquery-in-wordpress-theme/
 */
function theme_deregister_jquery()
{
    // Deregister jQuery first...
    wp_deregister_script("jquery");

    // ..and register jQuery from CDN
    wp_register_script(
        "jquery",
        "//ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js",
        false,
        null,
        true
    );
}

/**
 * Remove default WordPress favicon
 * https://stackoverflow.com/a/64164537
 */
function theme_remove_wordpress_favicon()
{
    exit();
}

/**
 * Remove Admin Bar for all users except Administrators
 */
function theme_remove_admin_bar_for_users()
{
    if (!current_user_can("administrator") && !is_admin()) {
        show_admin_bar(false);
    }
}

/**
 * Creates <select> dropdown in Post Type Edit screen allowing filtering by Custom Taxonomy
 * source:  https://wordpress.stackexchange.com/a/346273
 */
function theme_add_custom_taxonomy_filter_to_edit_screen($taxonomy)
{
    $tax = get_taxonomy($taxonomy);
    $cat = filter_input(INPUT_GET, $taxonomy);

    echo '<label class="screen-reader-text" for="' .
        $taxonomy .
        '">Filter by ' .
        esc_html($tax->labels->singular_name) .
        "</label>";

    wp_dropdown_categories([
        "show_option_all" => $tax->labels->all_items,
        "hide_empty" => 0, // include categories that have no posts
        "hierarchical" => $tax->hierarchical,
        "show_count" => 0, // don't show the category's posts count
        "orderby" => "name",
        "selected" => $cat,
        "taxonomy" => $taxonomy,
        "name" => $taxonomy,
        "value_field" => "slug",
    ]);
}

/**
 * Update CPT Game post_title based on custom meta fields
 */
function theme_update_cpt_game_title($post_id)
{
    if (get_post_type() != "game" or !empty($_POST["post_title"])) {
        return;
    }

    $post = [];
    $post["ID"] = $post_id;

    //$date_string = get_post_meta($post_id, 'date', true);
    //$date = DateTime::createFromFormat('Y-m-d H:i:s', $date_string)->format('j.n.Y');

    $teams = get_field("teams");

    $home = Theme\Team::getTeamNameById($teams["home"]);
    $away = Theme\Team::getTeamNameById($teams["away"]);
    $details = get_field("details");

    $title = "{$details}, {$home} - {$away}";

    $post["post_title"] = $title;
    $post["post_name"] = sanitize_title($title);

    // Update the post into the database
    wp_update_post($post);
}

/**
 * Delete specific transients on Save Post action
 * https://developer.wordpress.org/reference/hooks/save_post/
 * https://developer.wordpress.org/reference/functions/delete_transient/
 *
 *
 */
function theme_delete_transients($post_id, $post)
{
    if ($post->post_type == "game") {
        delete_transient("schedule");
        delete_transient("latest_game");
        delete_transient("upcoming_games");

        //temporary: dirty way of deleteing Transients with dynamic key
        global $wpdb;
        $wpdb->query(
            "DELETE FROM `$wpdb->options` WHERE `option_name` LIKE ('_transient_schedule_%')"
        );
        $wpdb->query(
            "DELETE FROM `$wpdb->options` WHERE `option_name` LIKE ('_transient_timeout_schedule_%')"
        );
    }

    if ($post->post_type == "player") {
        delete_transient("squad");
    }
}

/**
 * Helper function to generate choices for ACF field that connects CPT Player with api-football.com Player ID
 * Reason: players endpoint provides search param but it is highly inconsistent when it comes to players with multiple surnames, i.e. api-football stores Sergio Oliveira with his full name, but not Rui Patricio etc.
 *
 * see: https://www.advancedcustomfields.com/resources/dynamically-populate-a-select-fields-choices/
 */
function theme_update_acf_player_id_api($field)
{
    $field["choices"] = [];

    $players = Theme\ApiFootball::getSquad();

    foreach ($players as $player) {
        $field["choices"][$player->id] = remove_accents($player->name);
    }

    return $field;
}

/**
 * Reorder comments on demand
 * asc = oldest comments first (reverse = false)
 * desc = newest comments first (reverse = true)
 *
 * By default, comment order is controlled via comments_template() and depends on comment_order and default_comments_page options.
 * No matter the setting, WordPress always renders older comments on first page, so newest comments are on "last" page, but the navigation can be displayed backwards. This is super counter-inutitive, but overriding order param in query solves this.
 *
 * It is possible to reorder comments directly via wp_list_comments() with "reverse_top_level" param, however
 * this only reorders comments on currently displayed page. Alternatively filtering options via option_{$option} hook also works.
 *
 * https://developer.wordpress.org/reference/functions/comments_template/
 * https://developer.wordpress.org/reference/hooks/option_option/
 **/
function theme_reorder_comments($query)
{
    if (!comments_open() or is_admin()) {
        return;
    }

    if (is_page_template("page-templates/shoutbox.php")) {
        //fixed order on shoutbox template
        $query->query_vars["order"] = "DESC";

        //disable thread comments for shoutbox template?
        //add_filter( "option_thread_comments", function() { return false; } );
    } elseif (is_single()) {
        $comments_order = isset($_GET["comments_order"])
            ? $_GET["comments_order"]
            : false;

        if ($comments_order === "asc") {
            $query->query_vars["order"] = "ASC";
        } elseif ($comments_order === "desc") {
            $query->query_vars["order"] = "DESC";
        }
    }

    return $query;
}
