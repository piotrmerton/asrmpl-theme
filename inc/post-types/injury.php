<?php

/* 
 *  Custom Post Type via register_post_type
 *  https://developer.wordpress.org/reference/functions/register_post_type/
 * 
 */

register_post_type( 'injury',
    array(
        'labels' => array(
            'name'          => __("Kontuzje", 'theme_bo'),
            'all_items'     => __("Lista kontuzji", 'theme_bo'),
            'singular_name' => __("Kontuzja", 'theme_bo'),
            'add_new'       => _x('Dodaj wpis', 'injury', 'theme_bo'),
            'add_new_item'  => __('Dodaj wpis', 'theme_bo'),
            'edit_item'     => __('Edytuj', 'theme_bo'),
            'view_item'     => __('Zobacz', 'theme_bo'),                
        ),
        'description'   => __("Lista kontuzji", 'theme_bo'),
        'public'        => true,
        'menu_position' => 4,
        'menu_icon'     => 'dashicons-plus-alt',
        //'supports'      => array( 'page-attributes' ),
        'show_in_rest'  => true,
        'has_archive'   => false,
    )
);

