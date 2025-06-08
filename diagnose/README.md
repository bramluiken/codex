# Diagnose Project

This subproject contains a PHP server with a static JavaScript client. The server exposes an API endpoint at `/api/hello` and survey endpoints for the client. The client uses a tiny component framework with animations and shows a questionnaire that grows as new questions arrive.

## Running

From the `diagnose` directory, start the built-in PHP server (you may need to install PHP with `sudo apt-get install php`):

```bash
php -S localhost:8000 -t server server/index.php

### API Endpoints

- `GET /api/hello` – simple test endpoint.
- `GET /api/history` – returns all questions and current answers.
- `POST /api/answer` – submit or update an answer (JSON: `{index, value}`).

The questionnaire will request the next question automatically based on server state.

To start a specific survey, open `/survey/<id>` in the browser (for example `/survey/product`).
The server will remember the survey ID in your session and serve the same client UI at `/`.

```

Then open [http://localhost:8000](http://localhost:8000) in your browser or run the `curl` command described in `AGENTS.md`.
