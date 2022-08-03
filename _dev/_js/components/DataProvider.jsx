import React from "react";

import DataContext from "./DataContext";
import useSWR from "swr";
import Loader from "./Loader";

const fetcher = (...args) => fetch(...args).then((res) => res.json());

function DataProvider(props) {
  const { data, error } = useSWR(props.api_url, fetcher, {
    revalidateOnFocus: false,
    refreshInterval: props.refresh ? props.refresh : 0,
  });

  if (error) return <div>Error {error}</div>;
  if (!data) return <Loader />;
  if (!error && !data) return null;
  if (data && data.length == 0)
    return (
      <p>{props.message_empty ? props.message_empty : wp_core.i18n.no_data}</p>
    );

  return (
    <DataContext.Provider value={data}>{props.children}</DataContext.Provider>
  );
}

export default DataProvider;
