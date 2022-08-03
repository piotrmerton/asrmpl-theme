<?php

namespace Theme;

use Timber\ImageHelper;

class Post
{
    /**
     * Default Posts WP REST endpoint is missing post meta data
     */
    public static function getMetaForRestApi($id_post)
    {
        $meta_fields = [];

        $post_age =
            human_time_diff(
                get_the_date("U", $id_post),
                current_time("timestamp")
            ) .
            " " .
            __("temu", "theme");
        $comments_number = get_comments_number($id_post);

        if ($comments_number == 1) {
            $comment_label = __("komentarz");
        } elseif (in_array(substr($comments_number, -1), ["2", "3", "4"])) {
            $comment_label = __("komentarze");
        } else {
            $comment_label = __("komentarzy");
        }

        $meta_fields["date"] = get_the_date("F j Y, H:i", $id_post);
        $meta_fields["post_age"] = $post_age;
        $meta_fields["comments_display"] =
            $comments_number . " " . $comment_label;
        $meta_fields["date_display"] =
            get_post_time("U", false, $id_post) > date("U") - 60 * 60 * 24
                ? $post_age
                : get_the_date("F j Y, H:i", $id_post);

        //ACF Image field
        //https://www.advancedcustomfields.com/resources/image/
        $cover = get_field("cover_image", $id_post);
        $cover_image = $cover ? $cover["sizes"]["cover"] : false;

        if ($cover) {
            $meta_fields["cover"] = [
                "alt" => $cover["alt"],
                "caption" => $cover["caption"],
                "jpeg" => $cover_image,
                "webp" => ImageHelper::img_to_webp($cover_image), //see timber/lib/ImageHelper.php
            ];
        } else {
            $meta_fields["cover"] = false;
        }

        return $meta_fields;
    }
}
