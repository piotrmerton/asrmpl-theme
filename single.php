<?php 

/** 
 * let's make all Post Types redirect to home page by default unless specifc controller in template hierarchy exists - we don't want google bots to index empty pages
 * https://developer.wordpress.org/themes/basics/template-hierarchy/
 * 
*/
wp_redirect( home_url() );