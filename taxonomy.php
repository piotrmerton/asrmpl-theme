<?php

//Current taxonomy name (string)
$taxonomy_name = get_query_var("taxonomy");

//Current taxonomy term (string)
$term_name = get_query_var("term");

/**
 *	Get the object containing a taxonomy's settings (metadata).
 *	https://codex.wordpress.org/Function_Reference/get_taxonomy
 *
 *	@param string
 *	@return object
 *
 */
$taxonomy = get_taxonomy($taxonomy_name);

/**
 *	Get all Term data from database (term_id, name, slug, term_group, taxonomy, description, parent, count)
 *	https://codex.wordpress.org/Function_Reference/get_term_by
 *
 *	@return object
 */
$term = get_term_by("slug", $term_name, $taxonomy_name); //or $wp_query->get_queried_object()

$context = Timber::get_context();

//https://timber.github.io/docs/reference/timber-term/
$context["term"] = new Timber\Term();

Timber::render(
    [
        "taxonomy-" . $term_name . ".twig",
        "taxonomy-" . $taxonomy_name . ".twig",
        "taxonomy.twig",
    ],
    $context
);
