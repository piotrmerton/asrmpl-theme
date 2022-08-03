<?php

namespace Theme;

use Theme\Team;

class Game
{
    /**
     * Structure games collection into schedule with some extra data
     *
     * @param $array array of CPT Game WP_POST Objects
     */
    public static function generateSchedule(array $games)
    {
        $schedule = [];
        $months = [];

        foreach ($games as $game) {
            $is_final_time = get_post_meta($game->ID, "is_final_time", true);
            $date = get_post_meta($game->ID, "date", true);
            $game_month = date("Y-m", strtotime($date));

            if (!isset($month) or $month != $game_month) {
                $months[] = $game_month;
            }
            //determine if it's a next game based on previous game results, not current date
            $game->next =
                isset($has_finished) && $has_finished == true && !$is_final_time
                    ? true
                    : false;
            if ($game->next) {
                $schedule["has_next_game"] = true;
            }

            $game->date = $date; //save Date in format stored in database, and not processed via ACF in order to use Twig date filter; see: https://github.com/timber/timber/issues/2078
            $game->data = self::getData($game->ID);

            $month = $game_month;
            $has_finished = $is_final_time;
        }

        $schedule["calendar"] = $months;
        $schedule["games"] = $games;

        return $schedule;
    }

    /**
     * Prepare CPT Game metadata for Scoreboard (teams, crests, competition data)
     * @param int $id game post ID
     * @param bool $broadcaster
     * @return array
     */
    public static function getData(int $id_game, $broadcaster = false)
    {
        $date = get_post_meta($id_game, "date", true);
        $date_string = strtotime($date);

        /**
         * We store post ID instead of post Object in meta fields due to performance,
         * so we need to get data manually if needed
         */
        $meta["teams"] = [
            "home" => Team::getTeamData(
                get_post_meta($id_game, "teams_home", true)
            ),
            "away" => Team::getTeamData(
                get_post_meta($id_game, "teams_away", true)
            ),
        ];
        $meta["is_final_time"] = get_post_meta($id_game, "is_final_time", true);
        $meta["date"] = $date;

        //this saves us using front-end date library like dayjs
        $meta["time"] = date("H:i", $date_string);
        $meta["display_date"] = date_i18n("l, j F Y", $date_string);

        $meta["details"] = get_post_meta($id_game, "details", true);
        $meta["result"] = [
            "home" => get_post_meta($id_game, "result_home", true),
            "away" => get_post_meta($id_game, "result_away", true),
        ];

        $meta["competition"] = Game::getCompetition($id_game, true);

        if ($broadcaster) {
            //get taxonomy broadcaster
            $meta["broadcaster"] = Game::getBroadcaster($id_game);
        }

        return $meta;
    }

    /**
     * Get next game(s) from current season based
     * We are querying based on meta_query instead of a date - thus, we can look for first record without "is_final_time" flag
     *
     * @param int $limit How many games to return
     */
    public static function getUpcomingGames(int $limit = 1)
    {
        $games = get_posts([
            "posts_per_page" => $limit,
            "post_type" => "game",
            "orderby" => "meta_value",
            "meta_key" => "date",
            "meta_type" => "DATETIME",
            "order" => "ASC",
            "meta_query" => [
                [
                    "key" => "is_final_time",
                    "value" => 0,
                    "type" => "NUMERIC",
                ],
            ],
            "tax_query" => [
                [
                    "taxonomy" => "season",
                    "field" => "slug",
                    "terms" => CURRENT_SEASON,
                ],
            ],
        ]);

        foreach ($games as $game) {
            $game->data = self::getData($game->ID, true);
        }

        return $games;
    }

    /**
     * Get latest game(s) from current season based
     * We are querying based on meta_query instead of a date - thus, we can look for first record without "is_final_time" flag
     *
     * @param int $limit How many games to return
     */
    public static function getLatestGames(int $limit = 1)
    {
        $games = get_posts([
            "posts_per_page" => $limit,
            "post_type" => "game",
            "orderby" => "meta_value",
            "meta_key" => "date",
            "meta_type" => "DATETIME",
            "order" => "DESC",
            "meta_query" => [
                [
                    "key" => "is_final_time",
                    "value" => 1,
                    "type" => "NUMERIC",
                ],
            ],
            "tax_query" => [
                [
                    "taxonomy" => "season",
                    "field" => "slug",
                    "terms" => CURRENT_SEASON,
                ],
            ],
        ]);

        foreach ($games as $game) {
            $game->data = self::getData($game->ID);
        }

        return $games;
    }

    /**
     * Check if there are Posts with specific meta data
     */
    public static function hasRelatedPosts(int $id_game): bool
    {
        $id_match_report = Game::getMatchReportId($id_game);

        $args = [
            "posts_per_page" => 1,
            "post_type" => "post",
            "fields" => "ids",
            "meta_query" => [
                [
                    "key" => "game_relationship",
                    "value" => $id_game,
                    "type" => "NUMERIC",
                ],
            ],
        ];

        if ($id_match_report and is_numeric($id_match_report)) {
            $args["post__not_in"] = [$id_match_report];
        }

        $posts = get_posts($args);

        return empty($posts) ? false : true;
    }

    public static function getRelatedPosts(int $id_game, $limit = 4): array
    {
        $id_match_report = Game::getMatchReportId($id_game);

        $args = [
            "posts_per_page" => $limit,
            "post_type" => "post",
            "meta_query" => [
                [
                    "key" => "game_relationship",
                    "value" => $id_game,
                    "type" => "NUMERIC",
                ],
            ],
        ];

        if ($id_match_report and is_numeric($id_match_report)) {
            $args["post__not_in"] = [$id_match_report];
        }

        $posts = get_posts($args);

        return $posts;
    }

    public static function getCompetition(int $id_game, $logo = false)
    {
        $id_competition = get_post_meta($id_game, "competition", true);

        //this is more efficient than new Timber\Term
        $competition = get_term_by("term_id", $id_competition, "competition");
        $competition->link = get_term_link(
            (int) $id_competition,
            "competition"
        );

        if ($logo) {
            $competition->logo = get_field(
                "logo",
                "competition_" . $id_competition
            );
        }

        return $competition;
    }

    public static function getBroadcaster(int $id_game)
    {
        $id_broadcaster = get_post_meta($id_game, "broadcaster", true);

        if (!$id_broadcaster) {
            return false;
        }

        //this is more efficient than new Timber\Term
        $broadcaster = get_term_by("term_id", $id_broadcaster, "broadcaster");
        $broadcaster_logo = get_field("logo", "broadcaster_" . $id_broadcaster);
        $broadcaster->logo = $broadcaster_logo ? $broadcaster_logo : false;

        return $broadcaster;
    }

    public static function getMatchReportId(int $id_game)
    {
        $id_match_report = get_post_meta($id_game, "report", true);

        return $id_match_report ? $id_match_report : false;
    }
}
