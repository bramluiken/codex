# Expert-Based Psychological Symptoms and Diagnoses Database Overview

This database schema includes three tables:

* **Symptoms**
* **Diagnoses**
* **Weights** (linking symptoms to diagnoses with expert-derived weights)

It covers a comprehensive range of psychological symptoms and clinically recognized mental health conditions based on the latest psychological research and expert judgment.

## Symptom Categories Covered

* **Cognitive** (e.g., trouble concentrating, racing thoughts)
* **Emotional** (e.g., sadness, hopelessness, irritability)
* **Behavioral** (e.g., avoidance, compulsions, impulsivity)

## Diagnoses Included

* Major Depressive Disorder
* Generalized Anxiety Disorder (GAD)
* Post-Traumatic Stress Disorder (PTSD)
* Obsessive-Compulsive Disorder (OCD)
* Attention-Deficit/Hyperactivity Disorder (ADHD)
* Bipolar Disorder
* Schizophrenia
* Social Anxiety Disorder
* Panic Disorder
* Anorexia Nervosa

## Symptom-Diagnosis Weighting Explained

* **Positive weight**: Symptom significantly indicates a diagnosis.
* **Negative weight**: Symptom presence suggests against the diagnosis.

Examples:

* **Hearing voices (hallucinations)**:

  * Highly indicative (**positive**) for Schizophrenia.
  * Generally absent (**negative**) in anxiety disorders or OCD.

* **Compulsive rituals**:

  * Strongly indicative (**positive**) of OCD.
  * Typically absent (**negative**) in Generalized Anxiety Disorder.

* **High-energy episodes with reduced sleep**:

  * Strongly indicative (**positive**) for Bipolar Disorder.
  * Typically absent (**negative**) in Depression or Anxiety Disorders.

## Clinical Relevance and Expert Approach

* Symptoms are phrased clearly for self-report surveys (e.g., *"I feel sad or down most of the day."*).
* Weights reflect clinical practice, capturing nuanced differential diagnosis considerations.
* Aligns broadly with DSM-5 criteria and contemporary psychological literature.

The database thus serves as a solid foundation for creating nuanced psychological assessment tools or decision-support systems for clinical and research settings.
