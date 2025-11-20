# ChatGPT Assistant

A simple web service for interacting with the OpenAI API (chat completion endpoint).
It provides a chat interface to send messages and receive GPT responses, with token usage stats (prompt, completion, total).
Built with **PHP (backend)** + **React (frontend)** inside **Docker**.

**Note:** This is a test assignment to showcase full-stack development skills with API integration and containerization.

## Requirements

* Docker and Docker Compose
* OpenAI API key (from the OpenAI Dashboard)

## Quick Setup

1. **Clone the repo**

   ```bash
   git clone https://github.com/your-username/chatgpt-assistant.git
   cd chatgpt-assistant
   ```

2. **Add your OpenAI API key** in `docker-compose.yml`:

   ```yaml
   environment:
      - OPENAI_API_KEY=your_key_here
   ```

3. **Run the project**

   ```bash
   docker-compose up --build
   ```

4. Open in browser:
   **[http://localhost:8080](http://localhost:8080)**

## Usage

* Messages appear immediately (user on the right, AI on the left) with a loading bar during requests.
* Errors appear above the input (click to dismiss).
* Token usage shown in the sidebar after each response.
* No persistence — chat history resets on refresh.

Stop the project:

```bash
docker-compose down
```

## Running Tests (Backend)
To run PHPUnit tests for the backend, build in development mode (includes dev dependencies) and execute inside the container:
```bash
docker-compose build backend --build-arg PHP_ENV=development
docker-compose up -d backend
docker-compose exec backend sh
./vendor/bin/phpunit tests
```

## Project Structure

```text
chatgpt-assistant/
├── backend/              # PHP 8.3
│   ├── Dockerfile
│   ├── composer.json
│   ├── index.php
│   ├── src/
|   └── tests/            # PHPUnit
├── frontend/             # React 19 + TypeScript + SCSS
│   ├── Dockerfile
│   ├── package.json
│   └── src/
├── docker-compose.yml
└── README.md
```

## License
This project is licensed under the MIT License.  
See the [LICENSE](LICENSE) file for details.
