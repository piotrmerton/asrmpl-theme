<?php

/**
 * Template Name: Shoutbox
 * Description: A custom template for Shoutbox subpage
 */


$context = Timber::get_context();

$context['page'] =  Timber::get_post();
$context['is_shoutbox'] =  true;

Timber::render( 'pages/shoutbox.twig', $context );
