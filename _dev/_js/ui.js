import { nav } from "./ui/nav";
import { form } from "./ui/form";
import { search } from "./ui/search";
import { tabs } from "./ui/tabs";
import { video } from "./ui/video";

export let UI = {
  mobile: /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(
    navigator.userAgent
  ),
  windowWidth: null,
  windowHeight: null,
  debug: false,

  // calculate and store viewport dimensions
  // this method will be bound to window resize event so try not to overload it
  init: function () {
    this.windowWidth = window.innerWidth;
    this.windowHeight = window.innerHeight;

    if (this.debug)
      console.log(
        "Window width: " +
          this.windowWidth +
          ", Window height: " +
          this.windowHeight
      );
  },

  nav,
  form,
  search,
  tabs,
  video,
};
