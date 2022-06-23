<?php

/* 
 *  Custom Post Type via register_post_type
 *  https://developer.wordpress.org/reference/functions/register_post_type/
 * 
 */

register_post_type( 'team',
    array(
        'labels' => array(
            'name'          => __("Drużyny", 'theme_bo'),
            'all_items'     => __("Lista drużyn", 'theme_bo'),
            'singular_name' => __("Drużyna", 'theme_bo'),
            'add_new'       => _x('Dodaj drużynę', 'team', 'theme_bo'),
            'add_new_item'  => __('Dodaj nową drużynę', 'theme_bo'),
            'edit_item'     => __('Edytuj drużynę', 'theme_bo'),
            'view_item'     => __('Zobacz', 'theme_bo'),                
        ),
        'description'       => __("Lista drużyn", 'theme_bo'),
        'public'            => true,
        'menu_position'     => 4,
        'menu_icon'         => 'dashicons-shield-alt',
        'supports'          => array( 'title', 'page-attributes' ),
        'show_in_rest'      => false,
        'show_in_nav_menus' => false,
        'has_archive'       => false,
    )
);