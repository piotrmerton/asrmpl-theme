import React from 'react';
import GLightbox from 'glightbox';

class PostItem extends React.Component {

    constructor(props) {
        super(props);

        // This binding is necessary to make `this` work in the callback
        this.playVideo = this.playVideo.bind(this);
      }

    //Fail state for WordPress dashes and hyphens
    renderText(text) {
        return {__html: text };
    }

    playVideo(event, id_video) {
        event.preventDefault();

        const modal = GLightbox({

            'elements' : [
                {
                    'href' : 'https://www.youtube.com/watch?v=' + id_video,
                    'type' : 'video',
                    'source' : 'youtube',
                    'width' : 1280,
                }
            ],
			'openEffect' : 'none',
			'closeEffect' : 'none',
            'autoplayVideos': true,

        });

        modal.open();

    }

    render() {

        const video = this.props.data;
        const id_video = video.custom_data.youtube_id;

        return(
            <li className="grid__item item--video" data-video-id={id_video}>
                <a className="video__link" href={video.custom_data.youtube_url} onClick={(event) => this.playVideo(event, id_video )}>   

                    {video.custom_data.cover &&
                    <div className="video__cover">
                        <figure className="cover__image cover cover--overlay">
                            <picture>
                                <source srcSet={video.custom_data.cover.webp} type="image/webp" />
                                <source srcSet={video.custom_data.cover.jpeg} type="image/jpeg" />
                                <img loading="lazy" src={video.custom_data.cover.jpeg} width="480" height="270" alt={video.custom_data.cover.alt} />
                            </picture>
                            <figcaption>{video.custom_data.cover.caption}</figcaption>
                        </figure>
                        <figure className="cover__ico">
                            <img loading="lazy" src={`${wp_core.theme_url}/assets/svg/ico/play.svg`} />
                        </figure>
                    </div>    

                    }

                    <p className="video__title" dangerouslySetInnerHTML={this.renderText(video.title.rendered)} /> 
                </a>
            </li> 

        )
       
    }

}

export default PostItem;
