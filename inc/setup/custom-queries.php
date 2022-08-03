<?php

use Theme\Season;

/**
 *  There is no way to stop default query from running without preventing wp() to run, so
 *  the only method to alter main query is to use pre_get_posts hook:
 *  https://developer.wordpress.org/reference/hooks/pre_get_posts/
 */
function theme_customize_main_query($query)
{
    if (is_admin() or !$query->is_main_query()) {
        return false;
    }

    if (is_home() or is_category() or is_tag()) {
        $query->set("posts_per_page", 20);
    }

    if (is_tax("competition") or is_post_type_archive("game")) {
        $query->set("posts_per_page", 75);

        // For Tax Queries use "parse_tax_query" hook, otherwise the queries will be doubled, see: https://wordpress.stackexchange.com/a/98143

        // Order posts by custom data field
        // https://developer.wordpress.org/reference/classes/wp_query/#comment-5309
        $query->set("meta_key", "date");
        $query->set("meta_type", "DATETIME");
        $query->set("orderby", "meta_value");
        $query->set("order", "ASC");
    }

    if (is_post_type_archive("player")) {
        $query->set("posts_per_page", 50);
        $query->set("meta_key", "number");
        $query->set("meta_type", "NUMERIC");
        $query->set("orderby", "meta_value_num");
        $query->set("order", "ASC");
    }

    if (is_category("historia")) {
        $query->set("posts_per_page", 50);
        $query->set("order", "ASC");
    }
}

function theme_customize_tax_query($query)
{
    if (is_admin() or !$query->is_main_query()) {
        return false;
    }

    if (is_tax("competition") or is_post_type_archive("game")) {
        $param = isset($_GET["season"]) ? $_GET["season"] : false;

        if ($param) {
            // some simple fail states for now

            if (!is_numeric($param)) {
                die("param must be an int");
            }

            $is_season_defined = Season::isSeasonDefined($param);

            if ($is_season_defined == false) {
                die("season not defined");
            }
        } elseif ($param == false) {
            // it seems that WordPress automatically adds param to main query if it matches defined taxonomy so we are altering tax_query only when there is no param in URL

            $season_query = [
                "taxonomy" => "season",
                "field" => "slug",
                "terms" => CURRENT_SEASON, //TO DO: current season as an WP Option
                "operator" => "IN",
            ];

            $query->tax_query->queries[] = $season_query;
        }
    }

    if (is_post_type_archive("player")) {
        $player_status_query = [
            "taxonomy" => "player_status",
            "field" => "slug",
            "terms" => "active",
            "operator" => "IN",
        ];

        $query->tax_query->queries[] = $player_status_query;
    }
}

add_action("pre_get_posts", "theme_customize_main_query", 10, 1);
add_action("parse_tax_query", "theme_customize_tax_query");
