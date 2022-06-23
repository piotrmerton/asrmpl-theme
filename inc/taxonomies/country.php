<?php

/* 
 *  Custom Post Type via register_taxonomy
 *  https://developer.wordpress.org/reference/functions/register_taxonomy/
 * 
 */

register_taxonomy('country', 'team',
    array(
        'labels' => array(
            'name'                   => __('Kraje', 'theme_bo'),
            'singular_name'          => __('Kraj', 'theme_bo'),
            'add_new_item'           => __('Dodaj kraj', 'theme_bo'),
            'new_item_name'          => __('Dodaj kraj', 'theme_bo'),
            'edit_item'              => __('Edytuj', 'theme_bo'),
            'name_field_description' => __('Wyświetlana nazwa kraju.', 'theme_bo'),
            'slug_field_description' => __('Trzyliterowy kod kraju ISO 3166 Alpha-3 <a href="https://en.wikipedia.org/wiki/List_of_ISO_3166_country_codes">link</a>', 'theme_bo'),
        ),
        'show_ui'               => true,
        'show_in_quick_edit'    => false,
        'show_tagcloud'         => false,
        'show_admin_column'     => true,
        'hierarchical'          => false,
        'meta_box_cb'           => false,
        'rewrite'               => false,
        'query_var'             => true,
        'show_in_rest'          => false,
        'show_in_nav_menus'     => false,
    )
);


