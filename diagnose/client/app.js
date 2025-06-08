window.addEventListener('DOMContentLoaded', () => {
  class HelloComponent extends Framework.Component {
    constructor(root) {
      super(root);
      this.message = '';
    }

    async load() {
      try {
        const res = await fetch('/api/hello');
        const data = await res.json();
        this.message = data.message;
      } catch (err) {
        this.message = 'Error: ' + err;
      }
      this.refresh();
    }

    template() {
      return `<div class="hello">${this.message}</div>`;
    }

    afterRender() {
      const el = this.root.querySelector('.hello');
      if (el) {
        Framework.animate(el, [
          { opacity: 0, transform: 'translateY(-20px)' },
          { opacity: 1, transform: 'translateY(0)' }
        ], { duration: 500, fill: 'forwards', easing: 'ease-out' });
      }
    }
  }

  const root = document.getElementById('result');
  const hello = new HelloComponent(root);
  hello.mount();
  hello.load();
});
