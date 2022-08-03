<?php

$postType = get_query_var("post_type");
$term = get_queried_object();

$context = Timber::get_context();

$context["post_type"] = get_query_var("post_type");
$context["term"] = $term;
$context["title"] = $term->name . " - " . __("archiwum", "theme");

Timber::render(["archive-" . $postType . ".twig", "archive.twig"], $context);
