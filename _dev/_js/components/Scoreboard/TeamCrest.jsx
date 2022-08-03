import React from "react";

function TeamCrest(props) {
  return (
    <figure className="team__crest">
      {props.crest ? (
        <img loading="lazy" src={props.crest} />
      ) : (
        <img
          loading="lazy"
          src={`${wp_core.theme_url}/assets/img/team-crest-placeholder.png`}
        />
      )}
    </figure>
  );
}

export default TeamCrest;
