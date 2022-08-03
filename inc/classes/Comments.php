<?php

namespace Theme;

use Timber\Timber;

class Comments
{
    /**
     * Adds useful metadata to default Comments WP REST endpoint
     */
    public static function getMetaForRestApi($id_comment)
    {
        $meta_fields = [];

        $comment_age =
            human_time_diff(
                get_comment_date("U", $id_comment),
                current_time("timestamp")
            ) .
            " " .
            __("temu", "theme");

        $meta_fields["author"] = get_comment_author($id_comment);
        $meta_fields["date"] = get_comment_date("F j Y, H:i", $id_comment);
        $meta_fields["comment_age"] = $comment_age;
        $meta_fields["date_display"] =
            get_comment_date("U", $id_comment) > date("U") - 60 * 60 * 24
                ? $comment_age
                : get_comment_date("F j Y, H:i", $id_comment);
        $meta_fields["content"] = strip_tags(get_comment_text($id_comment));

        return $meta_fields;
    }

    /**
     * Callback for wp_list_comments to customize comment markup
     *
     * https://developer.wordpress.org/reference/functions/wp_list_comments/
     * https://wordpress.stackexchange.com/questions/216502/change-html-produced-by-wp-list-comments
     *
     * @see: Walker_Comment::html5_comment
     */
    public static function renderCommentCustomMarkup($comment, $args, $depth)
    {
        $context = [
            "avatar" => get_avatar($comment),
            "author" => get_comment_author($comment),
            "comment" => $comment,
            "comment_text" => apply_filters(
                "comment_text",
                strip_tags(get_comment_text($comment))
            ),
            "comment_date" => get_comment_date("", $comment),
            "comment_time" => get_comment_time(),
            "comment_reply_link" => get_comment_reply_link(
                array_merge($args, [
                    "reply_to_text" => "",
                    "depth" => $depth,
                    "max_depth" => $args["max_depth"],
                    "login_text" => __("Odpowiedz"),
                ])
            ),
            "ago" => human_time_diff(
                get_comment_time("U"),
                current_time("timestamp")
            ),
        ];

        Timber::render("partials/item-comment.twig", $context);
    }
}
