import React from 'react';
import DataContext from '../DataContext';

class TopScorers extends React.Component {

    render() {

        const data = this.context;

        return (
            <table>
                <tbody>
                {data.map((row, index) =>
                
                    <tr key={index} className={row.statistics[0].team.name == wp_core.default_team ? 'highlight' : ''}>

                        <td>{row.player.name}</td>
                        <td><img loading="lazy" src={row.crest} alt={row.statistics[0].team.name} /></td>
                        <td>{row.statistics[0].goals.total}</td>

                    </tr>
                )}		
                </tbody>		    
            </table>

        );
    }
}	

TopScorers.contextType = DataContext;

export default TopScorers;
