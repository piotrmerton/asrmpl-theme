<?php
/**
 * Theme shortcodes
 * author: Piotr Merton
 *
 * Should you need render twig template via shortcode, use Timber::compile( 'team-member.twig', $data ) (timber/lib/Timber.php)
 * Additional resources for rendering twig templates via shortcodes:
 * https://stackoverflow.com/a/37499288
 *
 */

/**
 * Permalinks as shortcodes to use in WYSIWYG editor
 */
function theme_shortcode_permalinks($atts)
{
    extract(
        shortcode_atts(
            [
                "post_id" => false,
                "term_id" => false,
                "text" => false,
            ],
            $atts
        )
    );

    if ($term_id) {
        $term_id = (int) $term_id;
        $term = get_term($term_id);

        if ($term) {
            $url = get_term_link($term_id);
            $title = $term->name;
            //$text = $text ? $text : $title;
        }
    } else {
        $post_id = (int) $post_id;
        $url = get_permalink($post_id);
        $title = get_the_title($post_id);
        //$text = $text ? $text : $title;
    }

    if ($text) {
        $title = isset($title) ? $title : $text;

        return '<a href="' .
            $url .
            '" title="' .
            $title .
            '">' .
            $text .
            "</a>";
    }

    return $url;
}
