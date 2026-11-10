# WEBDEV3 · Lab Exercise 9 — Expose the API

A RESTful API built with **Laravel 13** and **Laravel Sanctum** for **WEBDEV3 (Week 11: RESTful API Development)**.

---

## Features Implemented

1. **`apiResource` Endpoints (`/api/posts`)**
   - Stateless RESTful CRUD routes registered in `routes/api.php` using `Route::apiResource('posts', PostApiController::class)`.
2. **API Resource Transformation (`PostResource`)**
   - Shapes JSON output (`id`, `title`, `body`, `author`, `created_at`) with eager loading (`Post::with('user')->latest()->paginate(10)`).
3. **Laravel Sanctum Token Authentication**
   - Personal access tokens issued via `$user->createToken('mobile')->plainTextToken`.
   - Protected routes guarded by `auth:sanctum` middleware (`Authorization: Bearer <token>`).
4. **Postman Collection Included**
   - [`WEBDEV3_Lab9_Postman_Collection.json`](./WEBDEV3_Lab9_Postman_Collection.json) covering both **Happy Paths (`200`, `201`, `204`)** and **Sad Paths (`401`, `422`, `404`)**.
5. **Built-in Live API Explorer**
   - Visit `http://127.0.0.1:8000` in the browser to interactively test all endpoints and inspect JSON responses & HTTP status codes.

---

## API Endpoints Summary

| Method | URI | Action | Status Codes | Auth |
| :--- | :--- | :--- | :--- | :--- |
| `POST` | `/api/register` | Register a new user & issue token | `201 Created`, `422` | Public |
| `POST` | `/api/login` | Authenticate user & issue token | `200 OK`, `422` | Public |
| `POST` | `/api/logout` | Revoke current access token | `200 OK`, `401` | `auth:sanctum` |
| `GET` | `/api/posts` | Paginated list of posts | `200 OK`, `401` | `auth:sanctum` |
| `POST` | `/api/posts` | Create a new post | `201 Created`, `401`, `422` | `auth:sanctum` |
| `GET` | `/api/posts/{post}` | Show a single post | `200 OK`, `401`, `404` | `auth:sanctum` |
| `PUT/PATCH` | `/api/posts/{post}` | Update an existing post | `200 OK`, `401`, `403`, `422` | `auth:sanctum` |
| `DELETE` | `/api/posts/{post}` | Delete a post | `204 No Content`, `401`, `403` | `auth:sanctum` |

---

## Quick Start

```bash
composer install
php artisan migrate --seed
php artisan serve
```

### Default Seeded Credentials
- **Email:** `juan@example.com`
- **Password:** `password123`
