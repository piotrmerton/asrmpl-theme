<?php

/* 
 *  Custom Post Type via register_post_type
 *  https://developer.wordpress.org/reference/functions/register_post_type/
 * 
 */

register_post_type( 'game',
    array(
        'labels' => array(
            'name'          => __("Terminarz", 'theme_bo'),
            'all_items'     => __("Lista meczów", 'theme_bo'),
            'singular_name' => __("Mecz", 'theme_bo'),
            'add_new'       => _x('Dodaj mecz', 'game', 'theme_bo'),
            'add_new_item'  => __('Dodaj nowy mecz', 'theme_bo'),
            'edit_item'     => __('Edytuj mecz', 'theme_bo'),
            'view_item'     => __('Zobacz', 'theme_bo'),                
        ),
        'description'   => __("Lista meczów", 'theme_bo'),
        'public'        => true,
        'menu_position' => 4,
        'menu_icon'     => 'dashicons-calendar-alt',
        //'supports'      => array( 'page-attributes' ),
        'show_in_rest'  => true,
        'has_archive'   => 'terminarz',
        'rewrite'       => array( 'slug' => 'mecz' ),
    )
);

