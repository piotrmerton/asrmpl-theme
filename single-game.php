<?php

use Theme\Game;

global $post;

$post_id = $post->ID;

$id_match_report = get_post_meta($post_id, "report", true);
$game_data = Game::getData($post_id);

$context = Timber::context();
$context["post"] = new Timber\Post();
$context["game"] = $game_data;
$context["has_related_posts"] = Game::hasRelatedPosts($post_id);

if ($id_match_report) {
    $context["match_report"] = Timber::get_post($id_match_report);
}

// Get related Tag by Competition Name
// TO DO: check if tag has posts?

$related_tag = get_term_by("slug", $game_data["competition"]->slug, "post_tag");
if ($related_tag) {
    $context["related_tag"] = new Timber\Term($related_tag->term_id);
}

Timber::render("pages/game.twig", $context);
