import React from "react";
import ReactDOM from "react-dom";

import DataProvider from "../components/DataProvider";
import InjuryList from "../components/Injury/InjuryList";

export default function injuries(selector, api_url) {
  if (document.querySelector(selector) == null) return;

  let node = document.querySelector(selector);

  ReactDOM.render(
    <DataProvider api_url={api_url} message_empty={wp_core.i18n.no_injuries}>
      <InjuryList />
    </DataProvider>,
    node
  );
}
