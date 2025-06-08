(() => {
  class SurveyService {
    static async history() {
      const res = await fetch('/api/history');
      return res.json();
    }

    static async answer(index, value) {
      return fetch('/api/answer', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ index, value })
      });
    }
  }

  window.SurveyService = SurveyService;
})();
