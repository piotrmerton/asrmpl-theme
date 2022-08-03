<?php

/*
 *  Custom Post Type via register_post_type
 *  https://developer.wordpress.org/reference/functions/register_post_type/
 *
 */

register_post_type("player", [
    "labels" => [
        "name" => __("Zawodnicy", "theme_bo"),
        "all_items" => __("Lista zawodników", "theme_bo"),
        "singular_name" => __("Zawodnik", "theme_bo"),
        "add_new" => _x("Dodaj zawodnika", "player", "theme_bo"),
        "add_new_item" => __("Dodaj nowego zawodnika", "theme_bo"),
        "edit_item" => __("Edytuj zawodnika", "theme_bo"),
        "view_item" => __("Zobacz", "theme_bo"),
    ],
    "description" => __("Lista zawodników", "theme_bo"),
    "public" => true,
    "menu_position" => 4,
    "menu_icon" => "dashicons-admin-users",
    "supports" => ["title", "editor"],
    "show_in_rest" => true,
    "has_archive" => "kadra",
    "rewrite" => ["slug" => "zawodnik"],
]);
