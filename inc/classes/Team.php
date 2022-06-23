<?php

namespace Theme;

class Team {

    /**
     * Get Team name by ID directly from DB using wpdb class without using get_post()
     * uses non-persistent wp_cache
     * 
     * @param int CPT Team id
     */
    public static function getTeamNameById($id) {
        global $wpdb;

        if( !$result = wp_cache_get($id, 'cpt_game_title')) {
            $result = $wpdb->get_var( $wpdb->prepare( "SELECT post_title FROM $wpdb->posts WHERE ID = %d", $id) );
            wp_cache_add( $id, $result, 'cpt_game_title' );
        }

        return $result;

    }


    /**
     * Get Team simple data without using get_post()
     */
    public static function getTeamData($id) {

        $team = array(
            'id' => $id,
            'name' => get_the_title($id), //get_the_title uses get_post under the hood and retrieves more data than we need
            //'name' => self::getTeamNameById($id),
            'crest' => get_field('logo', $id),
            //'crest' => get_post_meta($id, 'logo', true),
        );

        return $team;

    }

}