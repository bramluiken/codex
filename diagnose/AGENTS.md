This project hosts a simple PHP server and JavaScript client.
The landing page at `/` lets you create a questionnaire link and `/survey/<id>` loads the questionnaire.

**Testing**:
1. From the `diagnose` directory start the built-in server:
   `php -S localhost:8000 -t public public/index.php &`
   - If `php` is missing, install it with `apt-get update && apt-get install -y php-cli php-mysql`.
2. Run `curl -s http://localhost:8000/api/hello`.
   The response should include `"message"`.