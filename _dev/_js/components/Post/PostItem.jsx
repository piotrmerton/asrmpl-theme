import React from "react";

class PostItem extends React.Component {
  //Fail state for WordPress dashes and hyphens
  renderText(text) {
    return { __html: text };
  }

  render() {
    const defaultCssClass = "list__item item--post";
    let cssClass = this.props.cssClass ? this.props.cssClass : defaultCssClass;

    const post = this.props.data;

    let cover = post.custom_data.cover;

    if (!cover && this.props.grid == "horizontal") {
      cover = {
        webp: wp_core.theme_url + "/assets/img/post-cover-placeholder.webp",
        jpeg: wp_core.theme_url + "/assets/img/post-cover-placeholder.jpg",
      };
    }

    return (
      <li className={cssClass}>
        <a href={post.link}>
          {cover && (
            <figure className="post__cover cover cover--overlay">
              <picture>
                <source srcSet={cover.webp} type="image/webp" />
                <source srcSet={cover.jpeg} type="image/jpeg" />
                <img
                  loading="lazy"
                  src={cover.jpeg}
                  width="720"
                  height="480"
                  alt={cover.alt}
                />
              </picture>
              <figcaption>{cover.caption}</figcaption>
            </figure>
          )}

          <h3
            className="post__title"
            dangerouslySetInnerHTML={this.renderText(post.title.rendered)}
          />

          {this.props.meta && (
            <div className="post__meta">
              <div className="post__date">
                <figure className="ui-ico">
                  <img
                    loading="lazy"
                    src={`${wp_core.theme_url}/assets/svg/ico/calendar.svg`}
                  />
                </figure>
                <span className="label">{post.custom_data.date_display}</span>
              </div>
              <div className="post__comment-count">
                <figure className="ui-ico">
                  <img
                    loading="lazy"
                    src={`${wp_core.theme_url}/assets/svg/ico/comments.svg`}
                  />
                </figure>
                <span className="label">
                  {post.custom_data.comments_display}
                </span>
              </div>
            </div>
          )}
        </a>
      </li>
    );
  }
}

export default PostItem;
