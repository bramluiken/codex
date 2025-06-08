window.addEventListener('DOMContentLoaded', () => {
  class SurveyComponent extends Framework.Component {
    constructor(root) {
      super(root);
      this.questions = [];
      this.nextIndex = 0;
      this.done = false;
    }

    async fetchHistory() {
      try {
        const res = await fetch('/api/history');
        const data = await res.json();
        this.questions = data.history;
        this.nextIndex = data.nextIndex;
        this.done = this.nextIndex >= this.questions.length;
      } catch (err) {
        console.error(err);
      }
      this.refresh();
    }

    async sendAnswer(index, value) {
      await fetch('/api/answer', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ index, value })
      });
      await this.fetchHistory();
    }

    template() {
      if (this.done) {
        return '<div class="thanks">Thank you!</div>';
      }
      const visible = this.questions.slice(0, this.nextIndex + 1);
      return visible.map(q => {
        const buttons = Array.from({ length: 7 }, (_, i) => {
          const val = i + 1;
          const sel = q.answer === val ? 'selected' : '';
          return `<button class="${sel}" data-index="${q.index}" data-value="${val}">${val}</button>`;
        }).join(' ');
        return `<div class="question" data-question-index="${q.index}"><p>${q.question}</p><div class="scale">${buttons}</div></div>`;
      }).join('');
    }

    afterRender() {
      this.root.querySelectorAll('button[data-index][data-value]').forEach(btn => {
        btn.addEventListener('click', () => {
          const index = parseInt(btn.dataset.index, 10);
          const val = parseInt(btn.dataset.value, 10);
          this.sendAnswer(index, val);
        });
      });
      const newEl = this.root.querySelector(`.question[data-question-index="${this.nextIndex}"]`);
      if (newEl && !this.done) {
        Framework.animate(newEl, [{ opacity: 0, transform: 'translateY(-10px)' }, { opacity: 1, transform: 'translateY(0)' }], { duration: 300 });
      }
    }
  }

  const root = document.getElementById('app');
  
  const survey = new SurveyComponent(root);
  survey.fetchHistory();
  survey.mount();
  survey.fetchQuestion();
});
