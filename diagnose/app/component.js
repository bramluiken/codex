(() => {
  class SurveyComponent extends Framework.Component {
    constructor(root) {
      super(root);
      this.questions = [];
      this.done = false;
    }

    async refreshData() {
      try {
        const hist = await SurveyService.history();
        this.questions = hist.history;
        const next = await SurveyService.question();
        if (!next.done) {
          this.questions.push({ index: next.index, question: next.question, answer: null });
          this.done = false;
        } else {
          this.done = true;
        }
      } catch (err) {
        console.error(err);
      }
      this.refresh();
    }

    async handleAnswer(index, value) {
      await SurveyService.answer(index, value);
      await this.refreshData();
    }

    template() {
      if (this.done) {
        return '<div class="thanks">Thank you!</div>';
      }
      return this.questions.map((q) => {
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
          this.handleAnswer(index, val);
        });
      });
      const last = this.questions[this.questions.length - 1];
      const newEl = last ? this.root.querySelector(`.question[data-question-index="${last.index}"]`) : null;
      if (newEl && !this.done) {
        Framework.animate(newEl, [{ opacity: 0, transform: 'translateY(-10px)' }, { opacity: 1, transform: 'translateY(0)' }], { duration: 300 });
      }
    }
  }

  window.SurveyComponent = SurveyComponent;
})();
