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
     OPENAI_API_KEY: sk-your-key-here
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

## Project Structure

```text
chatgpt-assistant/
├── backend/              # PHP 8.3 + Symfony + OpenAI Client
│   ├── Dockerfile
│   ├── composer.json
│   ├── index.php
│   └── src/              # Controllers/config
├── frontend/             # React 19 + TypeScript + SCSS
│   ├── Dockerfile
│   ├── package.json
│   └── src/              # Components/pages
├── docker-compose.yml
└── README.md
```
