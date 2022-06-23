import React from 'react';

function Competition(props) {
    
    const competition = props.competition;

    return (
        <div className="playerstats__competition">
            <dl>
                <dt>{wp_core.i18n.playerstats.appearences}</dt>
                <dd>{competition.games.appearences ? competition.games.appearences : 0}</dd>
            </dl>
            <dl>
                <dt>{wp_core.i18n.playerstats.lineups}</dt>
                <dd>{competition.games.lineups ? competition.games.lineups : 0}</dd>
            </dl>
            <dl>
                <dt>{wp_core.i18n.playerstats.minutes}</dt>
                <dd>{competition.games.minutes ? competition.games.minutes : 0}</dd>
            </dl>

            {competition.games.position == "Goalkeeper" ?
                <React.Fragment>
                    <dl>
                        <dt>{wp_core.i18n.playerstats.saves}</dt>
                        <dd>{competition.goals.saves ? competition.goals.saves : 0}</dd>
                    </dl>
                    {/* 
                        It seems that as of 03-2022 api-football.com provides wrong data on penalties saved
                    */}
                    {/* <dl>
                        <dt>{wp_core.i18n.playerstats.saved}</dt>
                        <dd>{competition.penalty.saved ? competition.penalty.saved : 0}</dd>
                    </dl> */}
                </React.Fragment>
                
            :
                <React.Fragment>
                    <dl>
                        <dt>{wp_core.i18n.playerstats.goals}</dt>
                        <dd>{competition.goals.total ? competition.goals.total : 0}</dd>
                    </dl>
                    <dl>
                        <dt>{wp_core.i18n.playerstats.assists}</dt>
                        <dd>{competition.goals.assists ? competition.goals.assists : 0}</dd>
                    </dl>
                </React.Fragment>
            }

        </div>

    )

}

export default Competition;