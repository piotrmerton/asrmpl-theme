<?php

use Theme\Season;
use Theme\Game;
use Theme\ApiFootball;

//Current taxonomy name (string)
$taxonomy_name = get_query_var( 'taxonomy' );

//Current taxonomy term (string)
$term_name = get_query_var( 'term' );

$context = Timber::get_context();

//https://timber.github.io/docs/reference/timber-term/
$context['term'] = new Timber\Term();

/**
 * Get all available seasons
 * TO DO: get only seasons valid for current competition?
 */
$seasons = Season::getSeasons();

$queried_season = Season::getQueriedSeason();

$context['seasons'] = $seasons;
$context['queried_season'] = $queried_season;
$context['current_season'] = get_term_by('slug', CURRENT_SEASON, 'season');
$context['current_url'] = get_term_link( get_queried_object_id() );

/** 
 * Cache PHP data via Timber
 * https://timber.github.io/docs/guides/performance/#cache-the-php-data
 */
$context['schedule'] = TimberHelper::transient( 
	'schedule_'.$term_name.'_'.($queried_season ? $queried_season->slug : CURRENT_SEASON),
	function() {
		return Game::generateSchedule( Timber::get_posts() );
	}, 3600 
);

// Get related Tag by Competition Name
// TO DO: check if tag has posts?
$related_tag = get_term_by('slug', $term_name, 'post_tag');
if($related_tag) $context['related_tag'] = new Timber\Term( $related_tag->term_id );


Timber::render( 
	array( 
		'taxonomy-' . $term_name . '.twig', 
        'taxonomy-' . $taxonomy_name . '.twig',
		'taxonomy.twig' ),
	$context 
);