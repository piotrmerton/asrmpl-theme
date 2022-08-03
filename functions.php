<?php

/**
 * Autoloading via Composer
 */
if (file_exists(dirname(__FILE__) . "/vendor/autoload.php")) {
    require_once dirname(__FILE__) . "/vendor/autoload.php";
}

//Theme Setup
require_once "inc/setup/timber-setup.php";

require_once "inc/theme-functions.php";
require_once "inc/theme-hooks.php";
require_once "inc/theme-settings.php";
require_once "inc/theme-shortcodes.php";

require_once "inc/setup/custom-queries.php";

//Data Model: custom fields, post types and taxonomies
require_once "inc/setup/acf-setup.php";
require_once "inc/setup/cpt-setup.php";
require_once "inc/setup/custom-taxonomies-setup.php";

//Customize WP REST API
require_once "inc/setup/rest-api-setup.php";

//Some theme variables are dependant on ACF so let's move it below ACF initialization
require_once "inc/theme-variables.php";
