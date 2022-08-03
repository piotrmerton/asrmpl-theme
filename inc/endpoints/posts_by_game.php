<?php

use Theme\Game;
use Theme\Post;

/**
 * Custom endpoint for retrieving Posts related with CPT Game
 * https://developer.wordpress.org/rest-api/extending-the-rest-api/adding-custom-endpoints/
 * 

 */

function theme_rest_posts_by_game($request_data)
{
    $id_game = $request_data["id_game"];

    $posts = Game::getRelatedPosts($id_game);

    foreach ($posts as $post) {
        //make sure key fields are structured the same as in default Posts endpoint
        $post->id = $post->ID;
        $post->title = ["rendered" => get_the_title($post->ID)];
        $post->link = get_permalink($post->ID);
        $post->custom_data = Post::getMetaForRestApi($post->ID);
    }

    return $posts;
}

/*
 *
 * Register Rest API Endpoint
 * Route: {URL}/wp-json/posts/v1/{endpoint}
 *
 */
register_rest_route("theme/v1", "/postsbygame/", [
    "methods" => "GET",
    "callback" => "theme_rest_posts_by_game",
]);
