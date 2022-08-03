<?php

/**
 * Modify response of default endpoint:
 * https://developer.wordpress.org/rest-api/extending-the-rest-api/modifying-responses/
 */
register_rest_field(["video"], "custom_data", [
    "get_callback" => "theme_get_video_data_for_api",
    "schema" => null,
]);

/**
 * Register new fields to existing Object
 * https://developer.wordpress.org/reference/functions/register_rest_field/
 */
function theme_get_video_data_for_api($object)
{
    //get the id of the term object array
    $id_post = $object["id"];
    $id_youtube = get_post_meta($id_post, "youtube_id", true);

    $meta_fields = [];
    $meta_fields["youtube_id"] = $id_youtube;
    $meta_fields["youtube_url"] = "https://youtube.com/watch?v=" . $id_youtube;

    //ACF Image field
    //https://www.advancedcustomfields.com/resources/image/
    $cover = get_field("cover_image", $id_post);
    $cover_image = $cover ? $cover["sizes"]["video"] : false;

    if ($cover) {
        $meta_fields["cover"] = [
            "alt" => $cover["alt"],
            "caption" => $cover["caption"],
            "jpeg" => $cover_image,
            "webp" => Timber\ImageHelper::img_to_webp($cover_image), //see timber/lib/ImageHelper.php
        ];
    } else {
        $meta_fields["cover"] = false;
    }

    return $meta_fields;
}
