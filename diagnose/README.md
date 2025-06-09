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

Visit `/` to generate a new 8‑character questionnaire link. Opening `/survey/<id>` loads the questionnaire identified by `<id>`.

### Database

The server stores answers in a MySQL database. Configure the connection using these environment variables (defaults shown):

```bash
export DB_HOST=localhost
export DB_NAME=survey
export DB_USER=root
export DB_PASS=
```

Create the table with:

```bash
mysql -u$DB_USER -p$DB_PASS $DB_NAME < sql/create_answers.sql
```

Then open [http://localhost:8000](http://localhost:8000) in your browser or run the `curl` command described in `AGENTS.md`.
