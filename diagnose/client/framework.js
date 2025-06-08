(() => {
  class Component {
    constructor(root) {
      this.root = root;
    }

    mount() {
      this.refresh();
    }

    refresh() {
      this.root.innerHTML = this.template();
      this.afterRender();
    }

    template() {
      return '';
    }

    afterRender() {}
  }

  function animate(element, keyframes, options) {
    return element.animate(keyframes, options);
  }

  window.Framework = { Component, animate };
})();
