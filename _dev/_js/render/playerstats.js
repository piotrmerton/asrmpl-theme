import React from 'react';
import ReactDOM from 'react-dom';

import DataProvider from '../components/DataProvider';
import PlayerStats from '../components/Player/PlayerStats';

export default function calendar(selector, api_url) {

    if( document.querySelector(selector) == null) return;

    let node = document.querySelector(selector);
    
    let url = new URL(api_url);

    const id_player = node.dataset.playerId != undefined ? node.dataset.playerId : false;

    if(id_player) {
        url.searchParams.append('id_player', parseInt(id_player) );
    } else {
        return;
    }

    ReactDOM.render(
        <DataProvider api_url={url}>
            <PlayerStats />
        </DataProvider>, node
    ); 
    
}