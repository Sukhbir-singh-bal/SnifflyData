# Endpoints (Web + API) and cURL Examples

This file is generated from your route files:
- `routes/web.php`
- `routes/api.php`
- `routes/auth.php`

## Base URLs / Notes

- API routes are defined in `routes/api.php` with `Route::prefix('v1')`.
- In a standard Laravel app, `routes/api.php` is mounted under `/api`, so the full paths are typically:
  - `/api/v1/...`
- If your app is configured differently, verify with:
  - `php artisan route:list`

## API Authentication (Sanctum)

The API group uses `middleware(['auth:sanctum', 'active.user'])`.

Use the token returned by `/api/v1/login` or `/api/v1/register`:

```bash
Authorization: Bearer YOUR_SANCTUM_TOKEN
```

All API requests below assume JSON:

```bash
--header "Content-Type: application/json"
```

---

## API Endpoints (`routes/api.php`)

### Public (no auth)

#### `POST /api/v1/register`
- Controller: `App\Http\Controllers\Api\V1\AuthController@register`
- Body:
  - `name` (string, required)
  - `email` (string, required, unique)
  - `password` (string, required)
  - `password_confirmation` (string, required by `confirmed`)
  - `device_name` (string, optional, max 100)
- Response (201):
  - `message`
  - `token` (Sanctum token)
  - `user` (user resource)
  - `api_key` (API key resource)
  - `plain_text_api_key` (the plaintext key)

Example:
```bash
curl -i -X POST "https://your-host/api/v1/register" \
  -H "Content-Type: application/json" \
  -d '{
    "name":"Alice",
    "email":"alice@example.com",
    "password":"Secret123!",
    "password_confirmation":"Secret123!",
    "device_name":"api-client"
  }'
```

#### `POST /api/v1/login`
- Controller: `App\Http\Controllers\Api\V1\AuthController@login`
- Body:
  - `email` (required)
  - `password` (required)
  - `device_name` (optional)
- Response (200):
  - `message`
  - `token` (Sanctum token)
  - `user` (user resource)

Example:
```bash
curl -i -X POST "https://your-host/api/v1/login" \
  -H "Content-Type: application/json" \
  -d '{
    "email":"alice@example.com",
    "password":"Secret123!",
    "device_name":"api-client"
  }'
```

---

### Authenticated (`auth:sanctum`, `active.user`)

#### `POST /api/v1/logout`
- Controller: `App\Http\Controllers\Api\V1\AuthController@logout`
- Auth: required
- Body: none
- Response (200):
  - `message`

Example:
```bash
curl -i -X POST "https://your-host/api/v1/logout" \
  -H "Authorization: Bearer YOUR_SANCTUM_TOKEN"
```

#### `GET /api/v1/user`
- Controller: `App\Http\Controllers\Api\V1\AuthController@user`
- Auth: required
- Response (200):
  - `user`

Example:
```bash
curl -i -X GET "https://your-host/api/v1/user" \
  -H "Authorization: Bearer YOUR_SANCTUM_TOKEN"
```

#### `GET /api/v1/api-keys`
- Controller: `App\Http\Controllers\Api\V1\ApiKeyController@index`
- Auth: required
- Response (200):
  - `data`: list of API keys

API key fields (from `ApiKeyResource`):
- `id`, `name`, `key_last4`, `usage_limit`, `usage_count`, `created_at`

Example:
```bash
curl -i -X GET "https://your-host/api/v1/api-keys" \
  -H "Authorization: Bearer YOUR_SANCTUM_TOKEN"
```

#### `POST /api/v1/api-keys/generate`
- Controller: `App\Http\Controllers\Api\V1\ApiKeyController@generate`
- Auth: required
- Body (optional fields):
  - `name` (string, nullable, max 100)
  - `usage_limit` (integer, nullable, min 1)
- Response (201):
  - `message`
  - `api_key` (resource)
  - `plain_text_api_key` (plaintext key)

Example:
```bash
curl -i -X POST "https://your-host/api/v1/api-keys/generate" \
  -H "Authorization: Bearer YOUR_SANCTUM_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "name":"My Scraper Key",
    "usage_limit":100000
  }'
```

#### `DELETE /api/v1/api-keys/{id}`
- Controller: `App\Http\Controllers\Api\V1\ApiKeyController@destroy`
- Auth: required
- Response (200):
  - `message`

Example:
```bash
curl -i -X DELETE "https://your-host/api/v1/api-keys/1" \
  -H "Authorization: Bearer YOUR_SANCTUM_TOKEN"
```

#### `GET /api/v1/profile`
- Controller: `App\Http\Controllers\Api\V1\ProfileController@show`
- Auth: required
- Response (200):
  - `user`

#### `PATCH /api/v1/profile`
- Controller: `App\Http\Controllers\Api\V1\ProfileController@update`
- Auth: required
- Body (optional, but if present must be valid):
  - `name` (string, max 255)
  - `email` (email, max 255, unique)
- Response (200):
  - `message`
  - `user`

Example:
```bash
curl -i -X PATCH "https://your-host/api/v1/profile" \
  -H "Authorization: Bearer YOUR_SANCTUM_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"name":"Alice Updated"}'
```

#### `POST /api/v1/scrape`
- Controller: `App\Http\Controllers\Api\V1\ScrapeController@store`
- Auth: API key via `x-api-key` header (plaintext); no Sanctum token required
- Body:
  - `url` (required, valid URL, max 2048)
- Response (202):
  - `request_id` (queued scrape request id)

Important:
- This endpoint stores a `ScrapeRequest` and dispatches `ScrapeWebsiteJob` to queue `scraping`.
- The API key from `x-api-key` is validated and used to associate the scrape request with the correct stored key (`api_key_id` in the DB).

Example:
```bash
curl -i -X POST "https://your-host/api/v1/scrape" \
  -H "x-api-key: YOUR_API_KEY" \
  -H "Content-Type: application/json" \
  -d '{
    "url":"https://example.com"
  }'
```

#### `GET /api/v1/dashboard/stats`
- Controller: `App\Http\Controllers\Api\V1\DashboardController@stats`
- Auth: required
- Response (200):
  - `total_requests`
  - `success_rate` (percentage, number)
  - `failed_requests`
  - `credits_used`

Example:
```bash
curl -i -X GET "https://your-host/api/v1/dashboard/stats" \
  -H "Authorization: Bearer YOUR_SANCTUM_TOKEN"
```

#### `GET /api/v1/dashboard/recent-requests`
- Controller: `App\Http\Controllers\Api\V1\DashboardController@recentRequests`
- Auth: required
- Response (200):
  - `data`: list (max 10) of scrape requests

Scrape request fields (from `ScrapeRequestResource`):
- `id`, `url`, `status`, `response_time`, `credits_used`, `created_at`

Example:
```bash
curl -i -X GET "https://your-host/api/v1/dashboard/recent-requests" \
  -H "Authorization: Bearer YOUR_SANCTUM_TOKEN"
```

---

### Admin (`role:admin`)

All admin endpoints also require:
- `auth:sanctum`
- `active.user`

#### `GET /api/v1/admin/users`
- Controller: `App\Http\Controllers\Api\V1\AdminUserController@index`
- Auth: required, admin role
- Response (200):
  - `users` (paginated user list)
  - `meta` (pagination info)

#### `PATCH /api/v1/admin/users/{id}/status`
- Controller: `App\Http\Controllers\Api\V1\AdminUserController@updateStatus`
- Auth: required, admin role
- Body:
  - `is_active` (boolean, required)
- Response (200):
  - `message`
  - `user`

Example:
```bash
curl -i -X PATCH "https://your-host/api/v1/admin/users/5/status" \
  -H "Authorization: Bearer YOUR_ADMIN_SANCTUM_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"is_active":false}'
```

---

## Web Endpoints (`routes/web.php` + `routes/auth.php`)

### Pages (views)

#### `GET /`
- returns view: `welcome`

#### `GET /login`
- returns view: `auth.login`

#### `GET /register`
- returns view: `auth.register`

### Authenticated dashboard

#### `GET /dashboard`
- Controller: `App\Http\Controllers\UserDashboardController@index`
- Auth: `auth` middleware

#### `POST /dashboard/api-keys/generate`
- Controller: `App\Http\Controllers\UserDashboardController@generateApiKey`
- Auth: `auth` middleware
- Response: redirect (HTML flow)

### Auth scaffolding (POST /login, POST /register, etc.)

These are defined in `routes/auth.php`:
- `POST /register` (guest) -> `RegisteredUserController@store`
- `POST /login` (guest) -> `AuthenticatedSessionController@store`
- `POST /forgot-password` (guest) -> `PasswordResetLinkController@store`
- `POST /reset-password` (guest) -> `NewPasswordController@store`
- `GET /verify-email/{id}/{hash}` -> `VerifyEmailController` (requires `auth`, `signed`, `throttle:6,1`)
- `POST /email/verification-notification` -> `EmailVerificationNotificationController` (requires `auth`, `throttle:6,1`)
- `POST /logout` (auth) -> `AuthenticatedSessionController@destroy`

