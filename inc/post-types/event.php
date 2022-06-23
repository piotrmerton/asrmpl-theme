<?php

/* 
 *  Custom Post Type via register_post_type
 *  https://developer.wordpress.org/reference/functions/register_post_type/
 * 
 */

register_post_type( 'event',
    array(
        'labels' => array(
            'name'          => __("Kalendarium", 'theme_bo'),
            'all_items'     => __("Lista wydarzeń", 'theme_bo'),
            'singular_name' => __("Wydarzenie", 'theme_bo'),
            'add_new'       => _x('Dodaj wydarzenie', 'event', 'theme_bo'),
            'add_new_item'  => __('Dodaj nowe wydarzenie', 'theme_bo'),
            'edit_item'     => __('Edytuj wydarzenie', 'theme_bo'),
            'view_item'     => __('Zobacz', 'theme_bo'),                
        ),
        'description'   => __("Lista wydarzeń", 'theme_bo'),
        'public'        => true,
        'menu_position' => 4,
        'menu_icon'     => 'dashicons-calendar',
        //'supports'      => array( 'page-attributes' ),
        'show_in_rest'  => true,
        'has_archive'   => false,
    )
);

