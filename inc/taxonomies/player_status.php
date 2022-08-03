<?php

/*
 *  Custom Post Type via register_taxonomy
 *  https://developer.wordpress.org/reference/functions/register_taxonomy/
 *
 */

register_taxonomy("player_status", "player", [
    "labels" => [
        "name" => __("Status", "theme_bo"),
        "singular_name" => __("Status", "theme_bo"),
        "add_new_item" => __("Dodaj status", "theme_bo"),
        "new_item_name" => __("Dodaj status", "theme_bo"),
        "edit_item" => __("Edytuj", "theme_bo"),
    ],
    "show_ui" => false,
    "show_in_quick_edit" => false,
    "show_tagcloud" => false,
    "show_admin_column" => true,
    "hierarchical" => false,
    "meta_box_cb" => false,
    "rewrite" => false,
    "query_var" => true,
    "show_in_rest" => false,
    "show_in_nav_menus" => false,
]);
