<?php

use Theme\Player;

$context = Timber::get_context();

/** 
 * Cache PHP data via Timber
 * https://timber.github.io/docs/guides/performance/#cache-the-php-data
 */
$context['squad'] = TimberHelper::transient( 
	'squad', 
	function() {
		return Player::generateSquad( Timber::get_posts() );
	}, 3600 
);

Timber::render( 'pages/squad.twig', $context );