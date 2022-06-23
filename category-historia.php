<?php

$postType = get_query_var('post_type');
$term = get_queried_object();

$context = Timber::get_context();
$context['term'] = $term;


Timber::render( 'pages/history.twig', $context );