import React from 'react';
import DataContext from '../DataContext';

class InjuryList extends React.Component {

    //Fail state for WordPress dashes and hyphens
    renderText(text) {
        return {__html: text };
    }

    render() {

        const data = this.context;

        return (
            <ul className="injury__list">
                {data.map((post, index) =>
                    <li key={index} className="list__item item--injury">
                        <p className="injury__player" dangerouslySetInnerHTML={this.renderText(post.title.rendered)} />
                        <div className="injury__desc" dangerouslySetInnerHTML={this.renderText(post.content.rendered)} />
                    </li>
                )}				
            </ul>

        );
    }
}	
InjuryList.contextType = DataContext;

export default InjuryList;
