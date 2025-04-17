
# Laravel Blog Post API

A simple Blog Post RESTful API built with Laravel, featuring:

- CRUD for Users and Posts
- SQLite database
- Feature-based folder structure
- Swagger (OpenAPI) documentation
- RESTful error handling
- Eager Loading
- Redis Caching

---

## 🚀 Getting Started

### 1. Clone the repository

```bash
git clone https://github.com/tytrandn/blog-api.git
cd blog-api
```

### 2. Install dependencies

```bash
composer install
```

### 3. Configure environment

Copy the `.env.example` to `.env` and configure:

```bash
cp .env.example .env
```

Ensure the following lines for SQLite:

```env
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

Create the SQLite file if it doesn't exist:

```bash
touch database/database.sqlite
```

### 4. Generate app key

```bash
php artisan key:generate
```

### 5. Run migrations

```bash
php artisan migrate
```

---

## 📦 API Documentation with Swagger

### Generate Swagger UI

```bash
php artisan l5-swagger:generate
```

Then open:
```
http://localhost:8000/api/documentation
```

> No need to manually register Swagger service provider — it is already configured in the source.

---

## 🔧 Redis Setup (for Windows)

### Option 1: Redis for Windows (Unofficial Build)

1. Download from: [https://github.com/tporadowski/redis/releases](https://github.com/tporadowski/redis/releases)
2. Extract to `C:\Redis`
3. Run:
   ```bash
   redis-server.exe
   ```
4. (Optional) Add Redis to PATH

5. Test:
   ```bash
   redis-cli ping
   ```

### Option 2: Redis on WSL (Ubuntu)

```bash
sudo apt update
sudo apt install redis-server
redis-server
redis-cli ping
```

### Laravel `.env` settings:

```env
CACHE_DRIVER=redis
REDIS_HOST=127.0.0.1
REDIS_PORT=6379
```

---

## 🧪 Run the API

```bash
php artisan serve
```

You can now test the API using Postman or Swagger UI.

---

## 🧹 Project Structure

```
/app
    /Exceptions/
        - Handler.php
    /Http
        /Requests
            /Modules
                /User
                    /Request
                /Post
                    /Request
        - Kernel.php
    /Modules
        /User
            - Controllers
            - Models
            - Requests
        /Post
            - Controllers
            - Models
            - Requests
    /Providers
        - RouteServiceProvider.php
/config
    - swagger.php
/database
    - migrations
    - database.sqlite
/routes
    - api.php
/resources
    /views
/storage
    /api-docs
        - api-docs.json
```

Follows feature-based organization with Redis caching and Eager Loading.

---

## ✅ Features

- Feature-based structure
- RESTful status codes and JSON format
- Redis Caching on GET endpoints
- Eager Loading for performance
- Centralized error handling
- SQLite database (no MySQL setup required)

---

## ✍️ Author

Made by Tran Van Ty
