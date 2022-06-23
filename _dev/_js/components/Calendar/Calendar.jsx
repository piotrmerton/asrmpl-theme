import React from 'react';
import DataContext from '../DataContext';

class Calendar extends React.Component {

    //Fail state for WordPress dashes and hyphens
    renderText(text) {
        return {__html: text };
    }

    render() {

        const data = this.context;

        return (
            <ul className="events__list">
                {data.map((post, index) =>
                    <li key={index} className="list__item item--event">
                        <p dangerouslySetInnerHTML={this.renderText(post.post_content)} />
                    </li>
                )}				
            </ul>

        );
    }
}	
Calendar.contextType = DataContext;

export default Calendar;
