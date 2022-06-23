<?php

/* 
 *  Custom Post Type via register_taxonomy
 *  https://developer.wordpress.org/reference/functions/register_taxonomy/
 * 
 */

register_taxonomy('broadcaster', 'game',
    array(
        'labels' => array(
            'name'                   => __('Stacje telewizyjne', 'theme_bo'),
            'singular_name'          => __('Stacja telewizyjna', 'theme_bo'),
            'add_new_item'           => __('Dodaj stację', 'theme_bo'),
            'new_item_name'          => __('Dodaj stację', 'theme_bo'),
            'edit_item'              => __('Edytuj', 'theme_bo'),
        ),
        'show_ui'               => true,
        'show_in_quick_edit'    => false,
        'show_tagcloud'         => false,
        'show_admin_column'     => false,
        'hierarchical'          => false,
        'meta_box_cb'           => false,
        'rewrite'               => false,
        'query_var'             => true,
        'show_in_rest'          => false,
        'show_in_nav_menus'     => false,
    )
);


