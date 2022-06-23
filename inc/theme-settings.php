<?php
/**
 * Theme related settings
 * author: Piotr Merton
 *
 */

/**
 * Enable menu feature
 * see: https://developer.wordpress.org/reference/functions/register_nav_menus/ should you want to define different positions as well
 */
add_theme_support( 'menus' );

/**
 * Let WordPress manage the document title.
 * By adding theme support, we declare that this theme does not use a
 * hard-coded <title> tag in the document head, and expect WordPress to
 * provide it for us.
 */
add_theme_support( 'title-tag' );



/** 
 * Switch default core markup for search form, comment form, and comments to output valid HTML5.
 */
add_theme_support( 'html5', array(
    'gallery',
    'caption',
) );


/**
 * Post thumbnails settings
 */
add_theme_support( 'post-thumbnails', array('post') ); 
add_image_size( 'small', 240, 240, true );
add_image_size( 'video', 480, 270, true ); //matches youtube thumbnail ratio
add_image_size( 'player', 960, 960, true );
add_image_size( 'cover', 960, 640, true );