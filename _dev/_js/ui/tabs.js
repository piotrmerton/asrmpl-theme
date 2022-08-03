import { UI } from "../ui";

export let tabs = {
  selector: ".ui-tabs",
  selectorButton: ".do-toggle-tab",
  selectorTab: ".item--tab",
  selectorNav: ".tabs__nav",
  selectorTabContent: ".tab__content",
  classActive: "tab--active",

  bind: function () {
    if (document.querySelector(this.selectorButton) === null) return;

    let tabsContainer = document.querySelector(this.selector);

    let buttons = tabsContainer.querySelectorAll(this.selectorButton);

    buttons.forEach((button) => {
      button.addEventListener("click", (event) => {
        let target = event.target;
        let li = target.closest("li");
        let id_tab = li.dataset.idTab;

        if (UI.windowWidth > 960) {
          if (!li.classList.contains(this.classActive)) this.toggleTab(id_tab);
        } else {
          this.toggleTab(id_tab);
        }

        event.preventDefault();
      });
    });

    //window.addEventListener('resize', () => { this.reset() } );
  },

  toggleTab: function (id_tab) {
    let tabsContainer = document.querySelector(this.selector);

    //target both nav and content items
    let targetTabs = tabsContainer.querySelectorAll(
      '[data-id-tab="' + id_tab + '"]'
    );

    targetTabs.forEach((tab) => {
      this.closeSiblings(tab);

      if (!tab.classList.contains(this.classActive)) {
        this.openTab(tab);
      } else {
        this.closeTab(tab);
      }
    });
  },

  openTab: function (tab) {
    tab.classList.add(this.classActive);
    tab.setAttribute("data-collapsed", "false");
  },

  closeTab: function (tab) {
    tab.classList.remove(this.classActive);
    tab.setAttribute("data-collapsed", "true");
  },

  closeSiblings: function (tab) {
    let siblings = Array.prototype.filter.call(
      tab.parentNode.children,
      (child) => {
        return child !== tab;
      }
    );

    //remove active class from siblings
    siblings.forEach((tab) => {
      tab.classList.remove(this.classActive);
      this.closeTab(tab);
    });
  },

  // close all tabs
  reset: function () {
    let tabsContainer = document.querySelector(this.selector);
    let tabs = tabsContainer.querySelectorAll(this.selectorTab);

    tabs.forEach((tab, index) => {
      tab.classList.remove(this.classActive);
      this.closeTab(tab);
    });
  },
};
