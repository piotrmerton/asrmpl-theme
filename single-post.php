<?php

use Theme\Game;

global $post;

$post_id = $post->ID;

$context = Timber::context();

$context['post'] = new Timber\Post();
$context['has_thumbnail'] = has_post_thumbnail();
$context['has_banner'] = get_post_meta($post_id, 'has_banner', true) ? true : false;

//Check if Post is flagged as Match Report (via Edit CPT Match UI)
$related_game_id = get_post_meta($post_id, 'game_relationship', true);

if($related_game_id) {
    $report_id = get_post_meta($related_game_id, 'report', true);
    $is_report = $report_id == $post_id ? true : false;
    if($is_report) $context['game'] = Game::getData($related_game_id);
}



$context['is_report'] = isset($is_report) ? $is_report : false;

Timber::render( 'single-post.twig', $context );
