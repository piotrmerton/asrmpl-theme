<?php

/**
 * Template Name: Tabela Serie A
 * Description: A custom template for Serie A league table subpage
 */


use Theme\ApiFootball;


$context = Timber::get_context();

$context['standings'] = ApiFootball::getSerieATable();

$competition = get_term_by('slug', 'serie-a', 'competition');

$context['competition'] = new Timber\Term( $competition->term_id);

Timber::render( 'pages/standings-serie-a.twig', $context );
