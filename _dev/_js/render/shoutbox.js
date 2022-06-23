import React from 'react';
import ReactDOM from 'react-dom';

import DataProvider from '../components/DataProvider';
import Shoutbox from '../components/Shoutbox/Shoutbox';

export default function shoutbox(selector, api_url) {

    if( document.querySelector(selector) == null) return;

    let node = document.querySelector(selector);

    ReactDOM.render(
        <DataProvider api_url={api_url} refresh="60000">
            <Shoutbox />
        </DataProvider>, node
    )
    
    }