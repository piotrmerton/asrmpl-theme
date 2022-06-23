<?php

use Theme\Breadcrumbs;

// initialize Timber
$timber = new \Timber\Timber();

/**
 * Timber global context
 */
add_filter( 'timber/context', 'theme_global_context' );

function theme_global_context( $context ) {

    $context['is_home'] = is_home();
    $context['is_single'] = is_single();

    //https://timber.github.io/docs/guides/menus/#setting-up-a-menu-globally
    $context['nav'] = new \Timber\Menu( 'top-nav', array( 'depth' => 2) );
    $context['footer_nav'] = new \Timber\Menu( 'bottom-nav', array( 'depth' => 1) );
    $context['footer'] = get_field('footer', 'option');

    //global links
    $context['links'] = array(
        'archive' => get_permalink(THEME_ARCHIVE_PAGE_ID),
        'schedule' => get_post_type_archive_link('game'),
        'standings' => get_permalink(THEME_STANDINGS_PAGE_ID),
        'shoutbox' => get_permalink(THEME_SHOUTBOUX_PAGE_ID),
        'login' => wp_login_url(),
        'logout' => wp_logout_url( home_url() ),
        
        //theme-my-login plugin dependency
        'register' => tml_get_action_url( 'register' ),
        'dashboard' => tml_get_action_url( 'profile' ), //or use admin_url()
    );

    /**
     * @see inc/classes/Breadcrumbs.php
     */
    $context['breadcrumbs'] = Breadcrumbs::getBreadcrumbs();     

    return $context;
}
