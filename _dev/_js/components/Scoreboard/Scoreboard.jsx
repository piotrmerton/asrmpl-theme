import React from "react";
import TeamCrest from "../Scoreboard/TeamCrest";

function Scoreboard(props) {
  return (
    <div className="scoreboard">
      <div className="scoreboard__layout">
        <div className="scoreboard__team team--home">
          <TeamCrest crest={props.game.teams.home.crest} />
          <span className="team__name">{props.game.teams.home.name}</span>
        </div>

        <div className="scoreboard__result">
          {props.game.is_final_time == "1" ? (
            <div>
              {props.game.result.home}:{props.game.result.away}
            </div>
          ) : (
            <div>{props.game.time}</div>
          )}
        </div>

        <div className="scoreboard__team team--away">
          <TeamCrest crest={props.game.teams.away.crest} />
          <span className="team__name">{props.game.teams.away.name}</span>
        </div>
      </div>

      <ul className="scoreboard__details">
        <li className="list__item item--details">{props.game.details}</li>
        <li className="list__item item--date">{props.game.display_date}</li>
      </ul>
    </div>
  );
}

export default Scoreboard;
