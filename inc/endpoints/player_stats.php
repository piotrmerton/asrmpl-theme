<?php

use Theme\ApiFootball;

/**
 * Custom endpoint for retrieving Posts related with CPT Game
 * https://developer.wordpress.org/rest-api/extending-the-rest-api/adding-custom-endpoints/
 * 

 */

function theme_rest_player_stats($request_data)
{
    $id_player = $request_data["id_player"];

    $stats = ApiFootball::getPlayerStats($id_player);

    if ($stats) {
        $data = [
            "has_stats" => true,
            "stats" => $stats,
        ];
    } else {
        $data = [
            "has_stats" => false,
        ];
    }

    return $data;
}

/*
 *
 * Register Rest API Endpoint
 * Route: {URL}/wp-json/posts/v1/{endpoint}
 *
 */
register_rest_route("theme/v1", "/playerstats/", [
    "methods" => "GET",
    "callback" => "theme_rest_player_stats",
]);
