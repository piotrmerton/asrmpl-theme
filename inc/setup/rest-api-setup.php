<?php

function theme_customize_rest_api()
{
    require_once get_template_directory() . "/inc/endpoints/calendar.php";
    require_once get_template_directory() . "/inc/endpoints/comments.php";
    require_once get_template_directory() . "/inc/endpoints/posts.php";
    require_once get_template_directory() . "/inc/endpoints/posts_by_game.php";
    require_once get_template_directory() . "/inc/endpoints/player_stats.php";
    require_once get_template_directory() . "/inc/endpoints/schedule.php";
    require_once get_template_directory() . "/inc/endpoints/standings.php";
    require_once get_template_directory() . "/inc/endpoints/topscorers.php";
    require_once get_template_directory() . "/inc/endpoints/video.php";
}

add_action("rest_api_init", "theme_customize_rest_api");

/**
 * Register the custom endpoints that rely on API Football to be cached.
 * see: https://wordpress.org/plugins/wp-rest-cache/#can%20i%20register%20my%20own%20endpoint%20for%20caching%3F
 */
function theme_add_custom_endpoints_to_wp_rest_cache($allowed_endpoints)
{
    $namespace = "theme/v1";
    if (
        !isset($allowed_endpoints[$namespace]) ||
        !in_array(
            ["playerstats", "standings", "topscorers"],
            $allowed_endpoints[$namespace]
        )
    ) {
        $allowed_endpoints[$namespace][] = "playerstats";
        $allowed_endpoints[$namespace][] = "standings";
        $allowed_endpoints[$namespace][] = "topscorers";
    }
    return $allowed_endpoints;
}
//don't cache custom endpoints for now, since they are not getting regenerated after expiration
//add_filter( 'wp_rest_cache/allowed_endpoints', 'theme_add_custom_endpoints_to_wp_rest_cache', 10, 1);
