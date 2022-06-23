import React from 'react';
import ReactDOM from 'react-dom';

import DataProvider from '../components/DataProvider';
import PostsList from '../components/Post/PostsList';

export default function posts(selector, api_url) {
    if( document.querySelector(selector) == null) return;

    //component can have multiple roots and can be rendered multiple times on a single page
    let nodes = document.querySelectorAll(selector);

    nodes.forEach( node => {

        const grid = node.dataset.grid != undefined ? node.dataset.grid : 'horizontal'; //either horizontal or vertical, will be applied to css classes
        const show_meta = node.dataset.showMeta != undefined ? node.dataset.showMeta : true;
        
        const id_current_post = node.dataset.currentPostId != undefined ? node.dataset.currentPostId : false;
        const id_tag = node.dataset.tagId != undefined ? node.dataset.tagId : false;
        const id_category = node.dataset.categoryId != undefined ? node.dataset.categoryId : false;
        const id_game = node.dataset.gameId != undefined ? node.dataset.gameId : false;
        let limit = node.dataset.limit != undefined ? node.dataset.limit : false;

        let url = new URL(api_url);

        if(id_current_post) url.searchParams.append('exclude', parseInt(id_current_post) );

        if(id_tag) url.searchParams.append('tags', parseInt(id_tag) );

        if(id_category) url.searchParams.append('categories', parseInt(id_category) );   
        
        if(id_game) {
            //to filter posts by meta, we need to override api url with custom endpoint (see inc/endpoints/posts_by_game.php)
            url = new URL(wp_core.rest.postsbygame);
            url.searchParams.append('id_game', id_game );
        }

        if(limit) {     
            limit = parseInt(limit); 
            limit = limit > 5 ? 5 : limit;
            url.searchParams.set('per_page', limit );
        }        

        ReactDOM.render(
            <DataProvider api_url={url} message_empty={wp_core.i18n.no_posts}>
                <PostsList grid={grid} meta={show_meta} />
            </DataProvider>, node
        );  

    });
}