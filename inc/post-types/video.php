<?php

/*
 *  Custom Post Type via register_post_type
 *  https://developer.wordpress.org/reference/functions/register_post_type/
 *
 */

register_post_type("video", [
    "labels" => [
        "name" => __("Filmy", "theme_bo"),
        "all_items" => __("Lista filmów", "theme_bo"),
        "singular_name" => __("Film", "theme_bo"),
        "add_new" => _x("Dodaj film", "video", "theme_bo"),
        "add_new_item" => __("Dodaj nowy film", "theme_bo"),
        "edit_item" => __("Edytuj film", "theme_bo"),
        "view_item" => __("Zobacz", "theme_bo"),
    ],
    "description" => __("Lista filmów", "theme_bo"),
    "public" => true,
    "menu_position" => 4,
    "menu_icon" => "dashicons-video-alt3",
    "supports" => ["title"],
    "show_in_rest" => true,
    "has_archive" => "filmy",
    //'rewrite'       => array( 'slug' => 'mecz' ),
]);
