import React from 'react';
import VideoItem from './VideoItem';
import DataContext from '../DataContext';

class VideosList extends React.Component {

    render() {

        const data = this.context;
        let defaultCssClass = "videos__grid";

        if(wp_core.is_home) {
            defaultCssClass = defaultCssClass + ' grid--home';
        }

        return (
            <ul className={defaultCssClass}>
                {data.map((post, index) =>
                    <VideoItem key={post.id} data={post} index={index} />
                )}				
            </ul>

        );
    }
}	
VideosList.contextType = DataContext;

export default VideosList;
