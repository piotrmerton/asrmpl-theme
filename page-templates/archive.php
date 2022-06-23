<?php

/**
 * Template Name: Archiwum
 * Description: A custom template for Archive subpage
 * 
 * notes:
 * 
 * For standard Posts there is no dedicated archive controller (like for CPT, i.e. archive-{CPT}.php) so we are creating one manually via Page with custom query
 * 
 * To set up a separate archive index you'll need to create it as a Page, and assign it a special template.", see: https://codex.wordpress.org/Creating_an_Archive_Index
 * 
 */

global $paged;

if (!isset($paged) || !$paged){
    $paged = 1;
}

$context = Timber::get_context();

/**
 * Custom query with pagination: https://timber.github.io/docs/guides/pagination/#what-if-im-not-using-the-default-query
 */
$query_arguments = array(
    'post_type' => 'post',
    'ignore_sticky_posts' => true, //sticky posts prepends to results increasing posts number which can messed up custom pagination
    'paged' => $paged,
    'posts_per_page' => 20,
);

$context['posts'] = new Timber\PostQuery($query_arguments);
$context['title'] = __('Archiwum wpisów', 'theme');

Timber::render( 
    array( 'archive.twig' ), 
    $context 
);
