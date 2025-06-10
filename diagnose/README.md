# Diagnose Project

This subproject contains a PHP server with a static JavaScript client. The server exposes an API endpoint at `/api/hello` and survey endpoints for the client. The client uses a tiny component framework with animations and shows a questionnaire that grows as new questions arrive.

## Running

From the `diagnose` directory, start the built-in PHP server (you may need to install PHP with `sudo apt-get install php-cli php-mysql`):

```bash
php -S localhost:8000 -t public public/index.php
```

### API Endpoints

- `GET /api/hello` – simple test endpoint.
- `GET /api/<id>/history` – returns all questions and current answers for a questionnaire.
- `POST /api/<id>/answer` – submit or update an answer (JSON: `{index, value}`).

The questionnaire requests the next question automatically based on server state.

## Efficiency-Aware Question Selection

The API now chooses questions using a three-stage information-theoretic
approach:

1. **Stage 1 – Exploration**
   - Picks the question with the highest expected entropy reduction across all
     diagnoses.
2. **Stage 2 – Differential Diagnosis**
   - Focuses on the top three most probable diagnoses and again selects the
     question with the highest expected gain among them.
3. **Stage 3 – Confirmation**
   - Prioritizes questions that best confirm or refute the leading diagnosis.

The threshold for asking additional questions becomes stricter as more responses
are recorded to keep surveys short when little new information is gained.

Visit `/` to generate a new 8‑character questionnaire link. Opening `/survey/<id>` loads the questionnaire identified by `<id>`.

### Database

The server stores answers in a MySQL database. Configure the connection using these environment variables (defaults shown):

```bash
export DB_HOST=localhost
export DB_NAME=survey
export DB_USER=root
export DB_PASS=
```

Initialize the database with all tables and seed data using:

```bash
mysql -u$DB_USER -p$DB_PASS $DB_NAME < sql/setup.sql
```

Then open [http://localhost:8000](http://localhost:8000) in your browser or run the `curl` command described in `AGENTS.md`.
