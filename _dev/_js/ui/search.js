import { UI } from "../ui";

export let search = {
  searchUiSelector: "#search-overlay",
  buttonSelector: ".do-toggle-search-ui",
  classOpen: "search--open",

  bind: function () {
    let searchUI = document.querySelector(this.searchUiSelector);
    let buttons = document.querySelectorAll(this.buttonSelector);

    buttons.forEach((button) => {
      button.addEventListener("click", (event) => {
        !searchUI.classList.contains(this.classOpen)
          ? this.open()
          : this.close();

        UI.nav.resetMenu();

        event.preventDefault();
      });
    });
  },

  open: function () {
    let searchUI = document.querySelector(this.searchUiSelector);
    let searchInput = searchUI.querySelector(".search__query");

    searchUI.classList.add(this.classOpen);

    searchInput.focus();
  },

  close: function (scrollTop = false) {
    let searchUI = document.querySelector(this.searchUiSelector);

    searchUI.classList.remove(this.classOpen);

    //jump to the top of the page
    if (scrollTop) scroll(0, 0);
  },
};
