<?php

use Theme\Post;

/**
 * "Posts" - default Endpoint
 * https://developer.wordpress.org/rest-api/reference/posts/
 */

/**
 * Modify response of default endpoint:
 * https://developer.wordpress.org/rest-api/extending-the-rest-api/modifying-responses/
 */
register_rest_field(["post"], "custom_data", [
    "get_callback" => "theme_get_post_data_for_api",
    "schema" => null,
]);

/**
 * Register new fields to existing Object
 * https://developer.wordpress.org/reference/functions/register_rest_field/
 */
function theme_get_post_data_for_api($object)
{
    $id_post = $object["id"];

    $meta_fields = Post::getMetaForRestApi($id_post);

    return $meta_fields;
}
