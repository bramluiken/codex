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
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (survey_id, symptom_id),
  FOREIGN KEY (symptom_id) REFERENCES symptoms(id)
);
