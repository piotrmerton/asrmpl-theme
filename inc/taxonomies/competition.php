<?php

/* 
 *  Custom Post Type via register_taxonomy
 *  https://developer.wordpress.org/reference/functions/register_taxonomy/
 * 
 */

register_taxonomy('competition', 'game',
    array(
        'labels' => array(
            'name'          => __('Rozgrywki', 'theme_bo'),
            'add_new_item'  => __('Dodaj nowe rozgrywki', 'theme_bo'),
            'new_item_name' => __('Dodaj nowe rozgrywki', 'theme_bo'),
            'edit_item'     => __('Edytuj rozgrywki', 'theme_bo'),
        ),
        'show_ui'           => true,
        'show_tagcloud'     => false,
        'show_admin_column' => true,
        'hierarchical'      => false,
        'meta_box_cb'       => false,
        'rewrite'           => array( 'slug' => 'rozgrywki' ),
        'query_var'         => true,
        'show_in_rest'      => true,
    )
);