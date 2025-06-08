(() => {
  window.addEventListener('DOMContentLoaded', () => {
    const root = document.getElementById('app');
    const survey = new SurveyComponent(root);
    survey.mount();
    survey.refreshData();
  });
})();
