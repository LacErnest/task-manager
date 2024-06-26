# Task Manager

## Installation

1. Clone the repository:
    ```sh
    git clone https://github.com/LacErnest/task-manager.git
    cd task-manager
    ```

2. Install dependencies:
    ```sh
    composer install
    npm install && npm run dev
    ```

3. Create a copy of `.env` file:
    ```sh
    cp .env.example .env
    ```

4. Update the `.env` file to use SQLite:
    ```ini
    DB_CONNECTION=sqlite
    DB_DATABASE=./task.sqlite
    ```

5. Create the SQLite database file:
    ```sh
    touch task.sqlite
    ```

6. Generate application key:
    ```sh
    php artisan key:generate
    ```

7. Run the migrations:
    ```sh
    php artisan migrate
    ```

8. Serve the application:
    ```sh
    php artisan serve
    ```

9. Access the application at `http://localhost:8000`.

## Features

- Create, edit, delete tasks
- Reorder tasks with drag and drop (priorities updated automatically)
- Associate tasks with projects
- View tasks by project
