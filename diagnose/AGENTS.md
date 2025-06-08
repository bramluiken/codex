This project hosts a simple PHP server and JavaScript client.

**Testing**:
1. From the `diagnose` directory start the built-in server:
   `php -S localhost:8000 -t server server/index.php &`
   - If `php` is missing, install it with `apt-get update && apt-get install -y php-cli`.
2. Run `curl -s http://localhost:8000/api/hello`.
   The response should include `"message"`.