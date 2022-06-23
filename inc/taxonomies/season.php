<?php

/* 
 *  Custom Post Type via register_taxonomy
 *  https://developer.wordpress.org/reference/functions/register_taxonomy/
 * 
 */

register_taxonomy('season', 'game',
    array(
        'labels' => array(
            'name'                   => __('Sezony', 'theme_bo'),
            'singular_name'          => __('Sezon', 'theme_bo'),
            'add_new_item'           => __('Dodaj nowy sezon', 'theme_bo'),
            'new_item_name'          => __('Dodaj nowy sezon', 'theme_bo'),
            'edit_item'              => __('Edytuj sezon', 'theme_bo'),
            'name_field_description' => __('Pełna nazwa sezonu np. 2021/2022.', 'theme_bo'),
            'slug_field_description' => __('Nazwa uproszczona składająca się z roku, w którym zaczyna się sezon, np. 2021 (na potrzeby przyjaznych URL lub zapytań do bazy danych)', 'theme_bo'),
        ),
        'show_ui'               => true,
        'show_in_quick_edit'    => false,
        'show_tagcloud'         => false,
        'show_admin_column'     => true,
        'hierarchical'          => false,
        'meta_box_cb'           => false,
        'rewrite'               => false,
        'query_var'             => true,
        'show_in_rest'          => true,
        'show_in_nav_menus'     => false,
    )
);


