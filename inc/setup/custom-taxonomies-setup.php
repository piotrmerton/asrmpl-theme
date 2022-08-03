<?php

/**
 * Custom Taxonomies setup
 */

function theme_custom_taxonomies()
{
    require_once get_template_directory() . "/inc/taxonomies/competition.php";
    require_once get_template_directory() . "/inc/taxonomies/country.php";
    require_once get_template_directory() . "/inc/taxonomies/broadcaster.php";
    require_once get_template_directory() . "/inc/taxonomies/player_status.php";
    require_once get_template_directory() . "/inc/taxonomies/season.php";
}

add_action("init", "theme_custom_taxonomies");
