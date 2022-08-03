<?php

namespace Theme;

use DateTime;
use Theme\ApiFootball;

class Player
{
    public static function getRolesLabels()
    {
        $roles = [
            1 => [
                "singular" => __("Bramkarz", "theme"),
                "plural" => __("Bramkarze", "theme"),
            ],
            2 => [
                "singular" => __("Obrońca", "theme"),
                "plural" => __("Obrońcy", "theme"),
            ],
            3 => [
                "singular" => __("Pomocnik", "theme"),
                "plural" => __("Pomocnicy", "theme"),
            ],
            4 => [
                "singular" => __("Napastnik", "theme"),
                "plural" => __("Napastnicy", "theme"),
            ],
            5 => [
                "singular" => __("Trener", "theme"),
                "plural" => __("Sztab szkoleniowy", "theme"),
            ],
        ];

        return $roles;
    }

    public static function getPlayerRole($key)
    {
        $labels = self::getRolesLabels();

        return $labels[$key]["singular"];
    }

    /**
     * Calculate player age based on birthday
     *
     * @param $date string player birthday in  Ymd string format (this is how ACF stores data in post_meta table)
     */
    public static function getPlayerAge($date)
    {
        $birthdate = DateTime::createFromFormat("Ymd", $date);
        $age = date_diff(new DateTime(), $birthdate)->y;
        return $age;
    }

    /**
     * Run stardard WP Query to retrieve first team players
     * TO DO: alter query arguments via method parameters
     * @return array of WP Post Objects
     */
    public static function getFirstTeamPlayers()
    {
        $result = get_posts([
            "post_type" => "player",
            "posts_per_page" => 50,
            "meta_key" => "number",
            "meta_type" => "NUMBERIC",
            "orderby" => "meta_value_num",
            "order" => "ASC",
            "tax_query" => [
                [
                    "taxonomy" => "player_status",
                    "field" => "slug",
                    "terms" => "active",
                ],
            ],
        ]);

        return $result;
    }

    /**
     * Structure player collection into squad grouped by positions (roles)
     *
     * @param $array array of CPT Game WP_POST Objects
     */
    public static function generateSquad(array $players)
    {
        $squad = [];
        $labels = self::getRolesLabels();

        foreach ($players as $player) {
            $role = get_post_meta($player->ID, "role", true);

            $squad[$role]["players"][] = $player;
        }

        //add labels
        foreach ($squad as $key => $role) {
            $squad[$key]["labels"] = $labels[$key];
        }

        //reorder here, because we are already ordering query by meta_key "number" and sorting by two meta keys on query level is more performance-heavy becase requires meta_query: https://core.trac.wordpress.org/ticket/36937#comment:2
        ksort($squad);

        return $squad;
    }
}
