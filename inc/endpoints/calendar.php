<?php

use Theme\Game;

/**
 * Custom endpoint for calendar
 * By default, we can get posts by date range only using "before" and "after" parameters, but for calendar
 * to work we need to select specific day and month (not year)
 * 
 * https://developer.wordpress.org/rest-api/extending-the-rest-api/adding-custom-endpoints/
 * 

 */

function theme_rest_calendar()
{
    $events = get_posts([
        "post_type" => "event",
        "posts_per_page" => 5,
        "date_query" => [
            "month" => date("n"),
            "day" => date("j"),
        ],
    ]);

    return $events;
}

/*
 *
 * Register Rest API Endpoint
 * Route: {URL}/wp-json/posts/v1/{endpoint}
 *
 */
register_rest_route("theme/v1", "/calendar/", [
    "methods" => "GET",
    "callback" => "theme_rest_calendar",
]);
