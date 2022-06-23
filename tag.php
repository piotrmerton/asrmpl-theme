<?php

$postType = get_query_var('post_type');


$context = Timber::get_context();
$context['tag'] = new Timber\Term();

Timber::render( 'pages/tag.twig', $context );