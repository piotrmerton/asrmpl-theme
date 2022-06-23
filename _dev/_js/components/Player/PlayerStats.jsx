import React from 'react';
import DataContext from '../DataContext';
import Competition from './Competition';

/**
 * Player Competition Stats
 * 
 * @todo: add Season prop; for now, data from current season only is displayed because we don't want to exceed requests limit (season param is hardcoded in api_url)
 * @todo: refactor and abstract Tabs as Higher Order Component to make it reusable (i.e. on "SerieA" Component) or use react-tabs package
 * @todo: dynamically set active tab on componentDidMount for first competition available in data context
 * 
 */
class PlayerStats extends React.Component {

    constructor() {
        super();

        this.state = {
            activeTab : 135,
        }
        this.setActiveTab = this.setActiveTab.bind(this);

    }

    setActiveTab(event, id_tab) {
		event.preventDefault();
		//update active tab
		if(this.state.activeTab != id_tab) {
			this.setState({
				'activeTab' : id_tab
			});
		}
    }

	printCssClass(cssClass, id_tab) {
        return cssClass + ' item--tab ' + (id_tab === this.state.activeTab ? 'tab--active' : '');
	}

    render() {

        const data = this.context;

        const has_stats = data['has_stats'] ? true : false;

        if(!has_stats) return <p>{wp_core.i18n.no_playerstats}</p>

        return (
            <React.Fragment>
                {data.stats.map((playerstats, index) =>                            
                    <div key={index} className="ui-tabs tabs--playerstats">
                        <nav className="tabs__nav">
                            <ul className="nav__list">
                                {playerstats.statistics.map((competition, index) => {
                                    if(competition.league.id != null) { //null = friendlies
                                        return (
                                            <li key={index} className={this.printCssClass('nav__item', competition.league.id)}>
                                                <a href="#" onClick={ (event) => this.setActiveTab(event, competition.league.id) }>
                                                    <img loading="lazy" src={competition.league.logo} alt={competition.league.name} />
                                                    <span className="label">{competition.league.name}</span>
                                                </a>
                                            </li>                                        
                                        )
                                    }
                                })}
                            </ul>
                        </nav>

                        <ul className="tabs__list competitions__list">
                            {playerstats.statistics.map((competition, index) => {
                                if(competition.league.id != null) { //null = friendlies
                                    return (
                                        <li key={index} className={this.printCssClass('list__item', competition.league.id)}>
                                            <Competition competition={competition} />
                                        </li>                                        
                                    )
                                }
                            })}
                        </ul>

                    </div>
                )}

            </React.Fragment>
        );
    }
}	

PlayerStats.contextType = DataContext;

export default PlayerStats;
