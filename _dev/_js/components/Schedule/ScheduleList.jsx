import React from 'react';
import DataContext from '../DataContext';
import Scoreboard from '../Scoreboard/Scoreboard';

class ScheduleList extends React.Component {

    render() {

        const data = this.context;
        
        return (
            <ul className="schedule__list list--compact">
                {data.map((game, index) =>
                    <li key={index} className="item--game">
                        <Scoreboard game={game.data} />
                    </li>
                )}
            </ul>


        );
    }
}	

ScheduleList.contextType = DataContext;

export default ScheduleList;
