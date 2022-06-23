import React from 'react';
import PostItem from './PostItem';
import DataContext from '../DataContext';

class PostsList extends React.Component {

    render() {

        const data = this.context;

        let cssClass = 'posts__grid';
        cssClass += this.props.grid ? ' grid--' + this.props.grid : '';

        return (
            <ul className={cssClass}>
                {data.map((post, index) =>
                    <PostItem key={post.id} data={post} index={index} grid={this.props.grid} meta={this.props.meta} cssClass="grid__item item--post" />
                )}				
            </ul>

        );
    }
}	
PostsList.contextType = DataContext;

export default PostsList;
