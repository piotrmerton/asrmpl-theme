<?php

use Theme\Game;

$postType = get_query_var("post_type");

$context = Timber::get_context();

$context["current_season"] = get_term_by("slug", CURRENT_SEASON, "season");

/**
 * Cache PHP data via Timber
 * https://timber.github.io/docs/guides/performance/#cache-the-php-data
 */
$context["schedule"] = TimberHelper::transient(
    "schedule",
    function () {
        return Game::generateSchedule(Timber::get_posts());
    },
    3600
);

Timber::render(["archive-" . $postType . ".twig", "archive.twig"], $context);
