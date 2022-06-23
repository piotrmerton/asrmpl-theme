import React from 'react';
import ReactDOM from 'react-dom';

import DataProvider from '../components/DataProvider';
import VideosList from '../components/Video/VideosList';

export default function videos(selector, api_url) {
    if( document.querySelector(selector) == null) return;

    //component can have multiple roots and can be rendered multiple times on a single page
    let nodes = document.querySelectorAll(selector);

    nodes.forEach( node => {

        ReactDOM.render(
            <DataProvider api_url={api_url}>
                <VideosList />
            </DataProvider>, node
        ); 

    });
}