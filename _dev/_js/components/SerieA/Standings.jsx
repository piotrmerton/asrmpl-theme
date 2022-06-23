import React from 'react';
import DataContext from '../DataContext';

class Standings extends React.Component {

    render() {

        const data = this.context;

        return (
            <table className="table__standings">
                <tbody>
                {data.map((row, index) =>
                    <tr key={index} className={row.team.name == wp_core.default_team ? 'highlight' : ''}>

                        <td>{row.rank}.</td>
                        <td className="team">
                            <div>
                                <img loading="lazy" src={row.crest} />
                                <span>{row.team.name}</span>
                            </div>
                        </td>
                        <td>{ row.all.played }</td>
                        <td>{ row.all.goals.for }-{ row.all.goals.against }</td>
                        <td>{ row.points } {wp_core.i18n.points}</td>

                    </tr>
                )}		
                </tbody>		    
            </table>

        );
    }
}	

Standings.contextType = DataContext;

export default Standings;
