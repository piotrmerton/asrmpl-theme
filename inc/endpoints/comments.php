<?php

use Theme\Comments;

/**
 * "Comments" - default Endpoint
 * https://developer.wordpress.org/rest-api/reference/posts/
 */


/**
 * Modify response of default endpoint:
 * https://developer.wordpress.org/rest-api/extending-the-rest-api/modifying-responses/
 */
register_rest_field( array('comment'), 'custom_data', array(
    'get_callback'    => 'theme_get_comment_data_for_api',
    'schema'          => null,
    )
);

/**
 * Register new fields to existing Object
 * https://developer.wordpress.org/reference/functions/register_rest_field/
 */
function theme_get_comment_data_for_api( $object ) {

    $id_comment = $object['id'];

    $meta_fields = Comments::getMetaForRestApi($id_comment);
    
    return $meta_fields;
}