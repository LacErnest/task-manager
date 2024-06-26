Here's an improved version of your readme:

# Task Manager

## Installation

1. Clone the repository:
    ```sh
    git clone https://github.com/LacErnest/task-manager.git
    cd task-manager
    ```


3. Create a copy of `.env` file:
    ```sh
    cp .env.example .env
    ```

4. Update the `.env` file to use MySQL with the following configuration (according to your credentials):
    ```ini
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=task-manager
    DB_USERNAME=root
    DB_PASSWORD=root
    ```

5. Generate application key:
    ```sh
    php artisan key:generate
    ```

6. Run the migrations and seed the database:
    ```sh
    php artisan migrate --seed
    ```

7. Serve the application:
    ```sh
    php artisan serve
    ```

8. Access the application at `http://localhost:8000`.

## Features

- Create, edit, delete tasks
- Reorder tasks with drag and drop (priorities updated automatically)
- Associate tasks with projects
- View tasks by project
