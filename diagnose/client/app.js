window.addEventListener('DOMContentLoaded', () => {
  class SurveyComponent extends Framework.Component {
    constructor(root) {
      super(root);
      this.question = null;
      this.done = false;
    }

    async fetchQuestion() {
      try {
        const res = await fetch('/api/question');
        const data = await res.json();
        if (data.done) {
          this.done = true;
        } else {
          this.question = data.question;
        }
      } catch (err) {
        this.question = 'Error: ' + err;
      }
      this.refresh();
    }

    async sendAnswer(value) {
      await fetch('/api/answer', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ value })
      });
      await this.fetchQuestion();
    }

    template() {
      if (this.done) {
        return '<div class="thanks">Thank you!</div>';
      }
      if (!this.question) {
        return '<div>Loading...</div>';
      }
      const buttons = Array.from({ length: 7 }, (_, i) =>
        `<button data-value="${i + 1}">${i + 1}</button>`
      ).join(" ");
      return `<div class="question"><p>${this.question}</p><div class="scale">${buttons}</div></div>`;
    }

    afterRender() {
      this.root.querySelectorAll('button[data-value]').forEach(btn => {
        btn.addEventListener('click', () => {
          const val = parseInt(btn.dataset.value, 10);
          this.sendAnswer(val);
        });
      });
    }
  }

  const root = document.getElementById('survey');
  const survey = new SurveyComponent(root);
  survey.mount();
  survey.fetchQuestion();
});
