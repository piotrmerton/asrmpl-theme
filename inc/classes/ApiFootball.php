<?php

namespace Theme;


class ApiFootball extends Api {

    public static function getSerieATable($full = true, $season = CURRENT_SEASON) {

        $data = self::getData('https://v3.football.api-sports.io/standings?league=135&season='.$season);

        if(!$data or $data->results == 0) return false;

        $table = $data->response[0]->league->standings[0];

        if( $full == true) {

            $standings = $table;
            
        } else {
            $standings = array();
            $default_team = false;
            $index = 0;

            foreach($table as $row) {

                $index++;

                if( $index <= 5 or $row->team->name == "AS Roma") {
                    $standings[] = $row;
                } else {
                    continue;
                }
                
            }            
        }

        foreach($standings as $row) {
            $row->crest = self::getImage($row->team->logo, sanitize_title($row->team->name) );
        }

        return $standings;

    }

    public static function getSerieATopScorers($limit = 6, $season = CURRENT_SEASON) {
     
        $data = self::getData('https://v3.football.api-sports.io/players/topscorers?league=135&season='.$season);

        if(!$data or $data->results == 0) return false;

        $topscorers = $data->response;

        foreach($topscorers as $row) {
            $row->crest = self::getImage($row->statistics[0]->team->logo, sanitize_title($row->statistics[0]->team->name) );
        }        

        $topscorers = array_slice($topscorers, 0, $limit);

        return $topscorers;

    }


    public static function getPlayerStats($id_player, $season = CURRENT_SEASON) {

        $ttl = 172800;

        $id_player_api = get_post_meta($id_player, 'id_player_api', true);

        if($id_player_api) {

            $data = self::getData('https://v3.football.api-sports.io/players?id='.$id_player_api.'&team=497&season='.$season, $ttl);

        } else {

            $player_name = get_the_title($id_player);
            $player_name = remove_accents($player_name);

            // There is great inconsistency regarding player names in api-football.com, across different endpoints (i.e. players and players/squad) and it is hard to search and compare, i.e Rui Patricio doesn't have full name, while Sergio Oliveira has etc.

            // Highly inefficient workaround for manually providing IDs, i.e. not proof for multiple players with the same names        
            //$player_name = array_pop( explode(' ', $player_name) ); 

            $data = self::getData('https://v3.football.api-sports.io/players?search='.$player_name.'&team=497&season='.$season, $ttl);

        }

        if(!$data or $data->results == 0) return false;

        $stats = $data->response;

        return $stats;

    }


    public static function getSquad($id_team = 497) {

        $data = self::getData('https://v3.football.api-sports.io/players/squads?team=' . $id_team, 604800);

        if(!$data or $data->results == 0) return false;

        return $data->response[0]->players;

    }

}