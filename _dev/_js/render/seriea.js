import React from 'react';
import ReactDOM from 'react-dom';

import SerieA from '../components/SerieA/SerieA';

export default function seriea(selector) {

    if( document.querySelector(selector) == null) return;

    let node = document.querySelector(selector);
    
    ReactDOM.render(
        <SerieA />, node
    ); 
}