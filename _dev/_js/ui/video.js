import GLightbox from "glightbox";

export let video = {
  selectorLink: "do-play-video",

  settings: {
    openEffect: "none",
    closeEffect: "none",
    videosWidth: 1280,
    autoplayVideos: true,
  },

  init: function () {
    const video = GLightbox({
      selector: this.selectorLink,
      ...this.settings,
    });
  },
};
