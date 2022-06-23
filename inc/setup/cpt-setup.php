<?php

/**
 * Custom Post Types setup
 */

function theme_custom_post_types() {
    
    require_once( get_template_directory() . '/inc/post-types/game.php' );
    require_once( get_template_directory() . '/inc/post-types/player.php' );
    require_once( get_template_directory() . '/inc/post-types/team.php' );
    require_once( get_template_directory() . '/inc/post-types/video.php' );
    require_once( get_template_directory() . '/inc/post-types/event.php' );
    require_once( get_template_directory() . '/inc/post-types/injury.php' );
}

add_action( 'init', 'theme_custom_post_types' );