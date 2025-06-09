(() => {
  class SurveyService {
    static get surveyId() {
      const m = location.pathname.match(/\/survey\/([A-Z0-9]+)/i);
      return m ? m[1] : '';
    }
    static async history() {
      const res = await fetch(`/api/${SurveyService.surveyId}/history`);
      return res.json();
    }

    static async question() {
      const res = await fetch(`/api/${SurveyService.surveyId}/question`);
      return res.json();
    }

    static async answer(index, value) {
      return fetch(`/api/${SurveyService.surveyId}/answer`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ index, value })
      });
    }
  }

  window.SurveyService = SurveyService;
})();
