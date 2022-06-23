<?php

/**
 * No Timber implementation for comments due to poor documentation: for now we are using built-in WordPress functions for rendering comments, form and pagination so we are mostly relying on default markup, but using Timber to slightly help with separating HTML markup from logic
 * 
 * TO DO: fully refactor in Twig
 * 
 * see:
 * https://timber.github.io/docs/guides/comments/
 * https://github.com/timber/timber/issues/1205
 * https://github.com/timber/timber/issues/2034
 * https://github.com/timber/timber/issues/182
 * 
 * References:
 * 
 * Markup and examples:
 * WordPress comment templates from default themes (i.e. twentytwentyone)
 * 
 * Default markup:
 * @see Walker_Comment::comment and Walker_Comment::html5_comment
 * https://developer.wordpress.org/reference/classes/walker_comment/
 * 
 * Official docs:
 * https://developer.wordpress.org/reference/functions/comment_form/
 * https://developer.wordpress.org/reference/functions/wp_list_comments/
 * https://developer.wordpress.org/reference/functions/get_the_comments_pagination/
 * https://developer.wordpress.org/reference/functions/get_the_comments_navigation/
 * https://developer.wordpress.org/reference/functions/get_previous_comments_link/
 * https://developer.wordpress.org/reference/functions/get_next_comments_link/
 * 
 */

if ( post_password_required() ) {
	return;
}

$comments_order = isset($_GET['comments_order']) ? $_GET['comments_order'] : false;
/**
 * comments can by reorder via pre_get_comments hook but this param confirms that replies will always be in chronological order
 */
$reverse_children = ($comments_order === "desc") ? true : false;

$context = array(
	'link' => get_permalink(),
	'is_shoutbox' => is_page_template('page-templates/shoutbox.php') ? true : false,
	'comments_order' => $comments_order,
	'comments_open' => comments_open(),
	'comments_count' => get_comments_number(),
	'have_comments' => have_comments(),
	'comments' => wp_list_comments(
		array(
			'type' => 'comment',
			'style' => 'ul',
			'callback' => 'Theme\\Comments::renderCommentCustomMarkup',
			//'reverse_top_level' => $reverse_top_level,
			'reverse_children' => $reverse_children,
			'echo' => false,
		)
	),

	'comment_form' => array(
		'title_reply' => '',
		'title_reply_to' => 'abbbbcccc',
		'logged_in_as' => false,
		'comment_field' => Timber::compile('partials/comments/textarea.twig'),
		'format' => 'html5',
	),
	
	'comments_pagination' => get_the_comments_pagination(array(
		//'prev_next' => false,
	)),

);

/**
 * Enhance markup for easier styling
 */
function theme_commentform_add_fieldset_wrapper_start() {
	echo '<div class="fieldset">';
}
function theme_commentform_add_fieldset_wrapper_end() {
	echo '</div>';
}
add_action( 'comment_form_top', 'theme_commentform_add_fieldset_wrapper_start' );
add_action( 'comment_form', 'theme_commentform_add_fieldset_wrapper_end' );


Timber::render('components/comments.twig', $context);