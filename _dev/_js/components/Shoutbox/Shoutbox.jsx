import React, { useState } from "react";
import { useSWRConfig } from "swr";
import DataContext from "../DataContext";
import Loader from "../Loader";

function Shoutbox() {
  const [isValidating, setIsValidating] = useState(false);
  const { mutate } = useSWRConfig();

  /**
   * https://swr.vercel.app/docs/mutation
   * @todo: ui loader while revalidation? https://benborgers.com/posts/swr-refresh
   */
  function refresh(event) {
    event.preventDefault();

    setIsValidating(true);

    //tell all SWRs with this key to revalidate
    mutate(wp_core.rest.shoutbox, setIsValidating(false));
  }

  return (
    <DataContext.Consumer>
      {(data) => (
        <React.Fragment>
          <a className="ui-action" onClick={refresh}>
            {wp_core.i18n.shoutbox.refresh}
          </a>

          {!isValidating ? (
            <ul className="comments__list">
              {data.map((comment, index) => (
                <li key={index} className="list__item item--comment">
                  <div className="comment__meta">
                    <figure>
                      <img
                        loading="lazy"
                        src={comment.author_avatar_urls["96"]}
                      />
                    </figure>
                    <div className="comment__author">
                      {comment.custom_data.author}
                    </div>
                    <div className="comment__date">
                      {comment.custom_data.date_display}
                    </div>
                  </div>
                  <p>{comment.custom_data.content}</p>
                </li>
              ))}
            </ul>
          ) : (
            <p>
              <Loader />
            </p>
          )}
        </React.Fragment>
      )}
    </DataContext.Consumer>
  );
}

export default Shoutbox;
