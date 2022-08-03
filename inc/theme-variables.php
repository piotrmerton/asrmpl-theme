<?php
/**
 * Theme global variables for template files
 * Some global variables later enqueued in JS via wp_localize_script (@see theme_enqueue_scripts() ), so don't put any fragile data here
 * TO DO: refactor as object
 * author: Piotr Merton
 *
 */

$lang = defined("ICL_LANGUAGE_CODE") ? ICL_LANGUAGE_CODE : "pl";
$rest_url = get_rest_url(null, "wp/v2/");
$theme_rest_url = get_rest_url(null, "theme/v1/");

define("API_FOOTBALL_KEY", get_field("api_football_key", "option"));
define("CURRENT_SEASON", get_field("current_season", "option"));
define("THEME_ARCHIVE_PAGE_ID", 45);
define("THEME_CONTACT_PAGE_ID", 43);
define("THEME_STANDINGS_PAGE_ID", 292);
define("THEME_SHOUTBOUX_PAGE_ID", 365);
define("THEME_TERMS_PAGE_ID", 281);
define("THEME_PRIVACY_PAGE_ID", 3);

// variables for js

//some default endpoints for React Components defined here to easily
//override via template files regarding to current contex or filters (i.e. is_home or wpml_object_id, see theme_enqueue_frontend_scripts() at theme-functions.php)
//lang param is required when using WPML
$theme_endpoints = [
    "base" => $rest_url,
    "theme" => $theme_rest_url,
    "posts" => $rest_url . "posts?per_page=4",
    "videos" => $rest_url . "video?per_page=4",
    "injuries" => $rest_url . "injury",
    "calendar" => $theme_rest_url . "calendar",
    "schedule" => $theme_rest_url . "schedule",
    "standings" => $theme_rest_url . "standings",
    "topscorers" => $theme_rest_url . "topscorers",
    "postsbygame" => $theme_rest_url . "postsbygame",
    "playerstats" => $theme_rest_url . "playerstats",
    "shoutbox" =>
        $rest_url . "comments?skip_cache=1&post=" . THEME_SHOUTBOUX_PAGE_ID,
];

$i18n = [
    "no_playerstats" => __(
        "Brak bieżących statystyk dla danego zawodnika.",
        "theme"
    ),
    "no_data" => __("Brak danych.", "theme"),
    "no_events" => __(
        "Na ten dzień nie przypada żadne istotne wydarzenie.",
        "theme"
    ),
    "no_posts" => __("Brak postów do wyświetlenia.", "theme"),
    "no_injuries" => __("Brak kontuzjowanych zawodników.", "theme"),
    "read_more" => __("Czytaj dalej", "theme"),
    "read_full" => __("Przeczytaj całość", "theme"),
    "nav_show_all" => __("Pokaż wszystko", "theme"),
    "points" => __("pkt.", "theme"),
    "playerstats" => [
        "appearences" => __("Rozegrane mecze", "theme"),
        "lineups" => __('Wyjściowa "11"', "theme"),
        "minutes" => __("Minuty na boisku", "theme"),
        "saves" => __("Kluczowe interwencje", "theme"),
        "saved" => __("Obronione rzuty karne", "theme"),
        "goals" => __("Gole", "theme"),
        "assists" => __("Asysty", "theme"),
    ],
    "shoutbox" => [
        "title" => __("Dyskusja", "theme"),
        "refresh" => __("Odśwież", "theme"),
    ],
];

// Global variables for template files and JS (all will be public in JS due to enqueue_scripts)
$theme_vars = [
    "base_url" => home_url(),
    "theme_url" => get_template_directory_uri(),
    "lang" => $lang,
    "rest" => $theme_endpoints,
    "i18n" => $i18n,
    "default_team" => "AS Roma",
    "default_season" => CURRENT_SEASON,
];
