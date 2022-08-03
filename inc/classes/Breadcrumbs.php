<?php

use Theme\Game;

namespace Theme;

/**
 * helper theme class that prepares breadcrumbs for Timber
 */

class Breadcrumbs
{
    /**
     * populates array of urls with titles for Timber to loop through
     */
    public static function getBreadcrumbs()
    {
        global $post;

        $breadcrumbs = [];

        $breadcrumbs[] = [
            "title" => __("Strona główna", "theme"),
            "url" => home_url(),
        ];

        if (is_post_type_archive("post") || is_singular("post")) {
            $category = self::getPostCategory($post->ID);

            $breadcrumbs[] = [
                "title" => $category->name,
                "url" => get_category_link($category->term_id),
            ];
        }

        if (is_post_type_archive("game") || is_singular("game")) {
            $breadcrumbs[] = [
                "title" => __("Terminarz", "theme"),
                "url" => get_post_type_archive_link("game"),
            ];
        }

        if (is_singular("game")) {
            $competition = Game::getCompetition($post->ID);

            $breadcrumbs[] = [
                "title" => $competition->name,
                "url" => $competition->link,
            ];
        }

        if (is_post_type_archive("player") || is_singular("player")) {
            $breadcrumbs[] = [
                "title" => __("Kadra", "theme"),
                "url" => get_post_type_archive_link("player"),
            ];
        }

        if (is_post_type_archive("video") || is_singular("video")) {
            $breadcrumbs[] = [
                "title" => __("Filmy", "theme"),
                "url" => get_post_type_archive_link("player"),
            ];
        }

        if (is_tax("competition")) {
            //TO DO: link tax terms list instead?
            $breadcrumbs[] = [
                "title" => __("Terminarz", "theme"),
                "url" => get_post_type_archive_link("game"),
            ];

            $breadcrumbs[] = [
                "title" => get_queried_object()->name,
                "url" => "#",
            ];
        }

        if (is_tag()) {
            $breadcrumbs[] = [
                "title" => __("Aktualności", "theme"),
                "url" => get_permalink(THEME_ARCHIVE_PAGE_ID),
            ];
            $breadcrumbs[] = [
                "title" => get_queried_object()->name,
                "url" => "",
            ];
        }

        if (is_search()) {
            $breadcrumbs[] = [
                "title" => __("Wyniki wyszukiwania", "theme"),
                "url" => "",
            ];
        }

        if (is_singular() || is_page()) {
            $breadcrumbs[] = [
                "title" => get_the_title(),
                "url" => get_permalink(),
            ];
        }

        return $breadcrumbs;
    }

    public static function getPostCategory($id_post)
    {
        $categories = get_the_category($id_post);

        return $categories[0];
    }
}
