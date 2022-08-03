export let form = {
  uiSelect: ".ui-select",
  commentTextareaWrapperSelector: ".comment-form-comment",

  bind: function () {
    this.autoGrowTextarea(this.commentTextareaWrapperSelector);
    this.selectAutoSubmit(this.uiSelect);
  },

  /**
   * auto resize <textarea>
   * source: https://css-tricks.com/the-cleanest-trick-for-autogrowing-textareas/
   */
  autoGrowTextarea(selector) {
    const nodes = document.querySelectorAll(selector);

    if (nodes === null) return;

    nodes.forEach((node) => {
      const textarea = node.querySelector("textarea");
      textarea.addEventListener("input", () => {
        node.dataset.replicatedValue = textarea.value;
      });
      textarea.addEventListener("focus", () => {
        node.classList.add("focused");
      });
      textarea.addEventListener("blur", () => {
        node.classList.remove("focused");
      });
    });
  },

  /**
   * automatically submit form when interacting with <select>
   *
   */
  selectAutoSubmit(selector) {
    const nodes = document.querySelectorAll(selector);

    if (nodes === null) return;

    nodes.forEach((node) => {
      const form = node.closest("form");

      node.addEventListener("change", () => {
        form.submit();
      });
    });
  },
};
