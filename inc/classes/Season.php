<?php

namespace Theme;

class Season
{
    /**
     * Check if season is defined in Database
     *
     * @param string $season_slug
     */
    public static function isSeasonDefined(int $season_slug)
    {
        $seasons = self::getSeasons();

        foreach ($seasons as $season) {
            if ($season_slug == $season->slug) {
                return true;
            }
        }

        return false;
    }

    /**
     * Return Season term based on URL param
     */
    public static function getQueriedSeason()
    {
        $param = isset($_GET["season"]) ? $_GET["season"] : false;

        if (!is_numeric($param)) {
            return false;
        }

        if ($param && self::isSeasonDefined($param)) {
            return get_term_by("slug", (int) $param, "season");
        } else {
            return false;
        }
    }

    /**
     * Get all available seasons
     */
    public static function getSeasons()
    {
        $seasons = get_terms([
            "taxonomy" => "season",
            "hide_empty" => true,
        ]);

        return $seasons;
    }
}
