This project hosts a simple PHP server and JavaScript client.

**Testing**:
- Start the PHP built-in server: `php -S localhost:8000 -t server server/index.php &`
- Run: `curl -s http://localhost:8000/api/hello`
- Ensure the output contains `"message"`.
