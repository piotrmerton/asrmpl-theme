<?php

use Theme\Player;

global $post;

$post_id = $post->ID;

$birthdate = get_post_meta($post_id, 'birthdate', true);
$age = Player::getPlayerAge($birthdate);

$context = Timber::context();

$context['post'] = new Timber\Post();
$context['player'] =  array(
    'age' => $age,
    'role' => Player::getPlayerRole( get_post_meta($post_id, 'role', true) ),
);

// Get related Tag by Player Name
// TO DO: check if tag has posts?
$related_tag = get_term_by('slug', $post->post_name, 'post_tag');
if($related_tag) $context['related_tag'] = new Timber\Term( $related_tag->term_id );


// get team squad for sidecolumn
// TO DO: make it asynchronous for better performance?
$team = Player::getFirstTeamPlayers();

//die( var_dump($team));

$context['squad'] = Player::generateSquad( Timber::get_posts($team) );

Timber::render( 'pages/player.twig', $context );
