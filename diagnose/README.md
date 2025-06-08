# Diagnose Project

This subproject contains a PHP server with a static JavaScript client. The server exposes an API endpoint at `/api/hello` and serves the client files from the `client` directory. The client demonstrates a small component framework with animations.

## Running

From the `diagnose` directory, start the built-in PHP server:

```bash
php -S localhost:8000 -t server index.php
```

Then open [http://localhost:8000](http://localhost:8000) in your browser or run the `curl` command described in `AGENTS.md`.
