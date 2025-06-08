# Diagnose Project

This subproject contains a PHP server with a static JavaScript client. The server exposes an API endpoint at `/api/hello` and additional survey endpoints for the client. The client demonstrates a small component framework with animations and displays survey questions returned by the server.

## Running

From the `diagnose` directory, start the built-in PHP server (you may need to install PHP with `sudo apt-get install php`):

```bash
php -S localhost:8000 -t server server/index.php

```

Then open [http://localhost:8000](http://localhost:8000) in your browser or run the `curl` command described in `AGENTS.md`.
