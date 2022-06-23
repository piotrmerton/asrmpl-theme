<?php

use Theme\Game;
use Theme\ApiFootball;

// echo '<pre>';
// die(print_r($table));

$context = Timber::context();
$context['links']['videos'] = get_post_type_archive_link('video');
$context['links']['articles'] = get_category_link(40);
$context['links']['interviews'] = get_category_link(41);

/** 
 * Cache PHP data via Timber
 * https://timber.github.io/docs/guides/performance/#cache-the-php-data
 */
$context['latest_game'] = TimberHelper::transient( 
	'latest_game',
	function() {
		return Game::getLatestGames();
	}, 86400 
);
$context['upcoming_games'] = Game::getUpcomingGames(2);

$context['honours'] = get_field('honours', 'option');

Timber::render( 'index.twig', $context );
