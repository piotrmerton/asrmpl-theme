import React from "react";
import ReactDOM from "react-dom";

import DataProvider from "../components/DataProvider";
import ScheduleList from "../components/Schedule/ScheduleList";

export default function schedule(selector, api_url) {
  if (document.querySelector(selector) == null) return;

  let node = document.querySelector(selector);

  ReactDOM.render(
    <DataProvider api_url={api_url}>
      <ScheduleList />
    </DataProvider>,
    node
  );
}
