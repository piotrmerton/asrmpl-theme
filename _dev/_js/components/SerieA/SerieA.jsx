import React from "react";
import DataProvider from "../DataProvider";
import Standings from "./Standings";
import TopScorers from "./TopScorers";

/**
 * Serie A stats component with hardcoded Standings and Top Scorers tabs
 *
 * @todo: add Season prop; for now, data from current season only is displayed because we don't want to exceed requests limit (season param is hardcoded in api_url)
 * @todo: refactor and abstract Tabs as Higher Order Component to make it reusable or use react-tabs package
 */

class SerieA extends React.Component {
  constructor() {
    super();

    this.state = {
      activeTab: "standings",
    };

    this.tabs = [
      {
        id: "standings",
        title: "Tabela",
      },
      {
        id: "topscorers",
        title: "Strzelcy",
      },
    ];

    this.setActiveTab = this.setActiveTab.bind(this);
  }

  setActiveTab(event, id_tab) {
    event.preventDefault();
    //update active tab
    if (this.state.activeTab != id_tab) {
      this.setState({
        activeTab: id_tab,
      });
    }
  }

  printCssClass(cssClass, id_tab) {
    return (
      cssClass +
      " item--tab " +
      (id_tab === this.state.activeTab ? "tab--active" : "")
    );
  }

  render() {
    const data = this.context;

    return (
      <div className="ui-competition">
        <div className="ui-tabs">
          <nav className="tabs__nav">
            <ul>
              {this.tabs.map((item) => (
                <li
                  key={item.id}
                  className={this.printCssClass("nav__item", item.id)}
                >
                  <a
                    href="#"
                    onClick={(event) => this.setActiveTab(event, item.id)}
                  >
                    {item.title}
                  </a>
                </li>
              ))}
            </ul>
          </nav>

          <ul className="tabs__list">
            <li className={this.printCssClass("list__item", "standings")}>
              <DataProvider api_url={wp_core.rest.standings}>
                <Standings />
              </DataProvider>
            </li>

            <li className={this.printCssClass("list__item", "topscorers")}>
              <DataProvider api_url={wp_core.rest.topscorers}>
                <TopScorers />
              </DataProvider>
            </li>
          </ul>
        </div>
      </div>
    );
  }
}

export default SerieA;
