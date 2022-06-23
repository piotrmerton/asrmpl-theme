<?php


$context = Timber::get_context();

$context['search_query'] = get_search_query();

Timber::render( 'search.twig', $context );
