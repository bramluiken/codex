CREATE TABLE answers (
  survey_id VARCHAR(8) NOT NULL,
  question_index INT NOT NULL,
  answer INT NOT NULL,
  PRIMARY KEY (survey_id, question_index)
);
