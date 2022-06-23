<?php

use Theme\ApiFootball;

/**
 * Custom endpoint for Serie A standings
 * https://developer.wordpress.org/rest-api/extending-the-rest-api/adding-custom-endpoints/
 * 
 * @todo: add season param
 */

function theme_rest_topscorers() {

    return ApiFootball::getSerieATopScorers();

}

/*
*
* Register Rest API Endpoint
* Route: {URL}/wp-json/posts/v1/{endpoint}
*
*/
register_rest_route( 'theme/v1', '/topscorers/', array(
    'methods' => 'GET',
    'callback' => 'theme_rest_topscorers'
) );
