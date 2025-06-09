-- Questions are stored as "symptoms".  Each symptom can contribute to multiple
-- diagnoses using weights.

CREATE TABLE symptoms (
  id INT AUTO_INCREMENT PRIMARY KEY,
  question TEXT NOT NULL
);

CREATE TABLE diagnoses (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL
);

-- Weight matrix connecting symptoms to diagnoses
CREATE TABLE weights (
  symptom_id INT NOT NULL,
  diagnosis_id INT NOT NULL,
  weight FLOAT NOT NULL,
  PRIMARY KEY (symptom_id, diagnosis_id),
  FOREIGN KEY (symptom_id) REFERENCES symptoms(id),
  FOREIGN KEY (diagnosis_id) REFERENCES diagnoses(id)
);

-- Answers link a survey to a specific symptom rating
CREATE TABLE answers (
  survey_id VARCHAR(8) NOT NULL,
  symptom_id INT NOT NULL,
  answer INT NOT NULL,
  PRIMARY KEY (survey_id, symptom_id),
  FOREIGN KEY (symptom_id) REFERENCES symptoms(id)
);

-- Example seed data
INSERT INTO symptoms (question) VALUES
  ('How satisfied are you with our service?'),
  ('How likely are you to recommend us to a friend?'),
  ('How would you rate the overall experience?');

INSERT INTO diagnoses (name) VALUES
  ('Great'),
  ('Neutral'),
  ('Poor');

-- Simple weight matrix for demonstration purposes
INSERT INTO weights (symptom_id, diagnosis_id, weight) VALUES
  (1,1, 1.0), (1,2, 0.5), (1,3, -1.0),
  (2,1, 1.0), (2,2, 0.2), (2,3, -0.5),
  (3,1, 1.0), (3,2, 0.1), (3,3, -0.7);
