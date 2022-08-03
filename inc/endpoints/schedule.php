<?php

use Theme\Game;

/**
 * Custom endpoint for schedule
 * https://developer.wordpress.org/rest-api/extending-the-rest-api/adding-custom-endpoints/
 * 

 */

function theme_rest_schedule()
{
    /**
     * @todo: can we optimize this to retrieve games with one query?
     */
    $last_game = Game::getLatestGames();
    $upcoming_games = Game::getUpcomingGames(4);

    $schedule = array_merge($last_game, $upcoming_games);

    return $schedule;
}

/*
 *
 * Register Rest API Endpoint
 * Route: {URL}/wp-json/posts/v1/{endpoint}
 *
 */
register_rest_route("theme/v1", "/schedule/", [
    "methods" => "GET",
    "callback" => "theme_rest_schedule",
]);
