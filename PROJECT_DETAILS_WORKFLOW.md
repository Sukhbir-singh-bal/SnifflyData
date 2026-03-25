# Project Details & Current Workflow

## Project Overview

This Laravel project (UI name: `ScrapeFlow`) provides:
- A web dashboard for authenticated users to view/generate API keys.
- A v1 JSON API (prefix `v1`) for user auth, API key management, and creating scrape requests.
- Admin endpoints for listing users and toggling whether accounts are active.

## Tech/Architecture (from code)

- Laravel routing:
  - Web routes: `routes/web.php`
  - API routes: `routes/api.php` (mounted under `api`, with `v1` prefix inside the file)
  - Auth scaffold: included from `routes/auth.php`
- API authentication: Laravel Sanctum token (`Authorization: Bearer <token>`)
- API key model concept:
  - API keys are generated and stored in the DB as a hash (`key_hash`) with a `key_last4` hint.
  - API key usage is tracked via `usage_count` and limited by `usage_limit`.
  - Scrape requests associate to a key via `api_key_id`.

## Security / Middleware Notes

### Sanctum authentication for the API
Most v1 API endpoints use:
- `auth:sanctum`
- `active.user` (user must be marked active)

The scraping endpoint (`POST /api/v1/scrape`) is an exception and uses:
- `api.key` (authenticate via plaintext `x-api-key` header)
- `active.user`

### Optional `x-api-key` middleware exists (but not currently used by v1 routes)
There is a middleware alias:
- `api.key` -> `AuthenticateApiKey`

This middleware:
- Expects header `x-api-key`
- Hashes it with SHA-256 and matches against stored `key_hash`
- Enforces `usage_limit`
- Increments `usage_count`

In other words: clients do not need Sanctum for scraping; they only provide `x-api-key`.

## Workflow (How a user uses the system)

### Step 1: Register or Login (get a Sanctum token)
1. `POST /api/v1/register`
2. or `POST /api/v1/login`

Both return a Sanctum token (`token`) you will use for authenticated API calls:
- `Authorization: Bearer YOUR_SANCTUM_TOKEN`

Registration also generates a default API key and returns:
- `plain_text_api_key` (the plaintext key, shown once in the response)
- `api_key` (resource with metadata like `id` and `key_last4`)

### Step 2: Choose (or generate) an API key
Authenticated endpoints let you manage keys:
- `GET /api/v1/api-keys` (list keys; includes `id` and `key_last4`)
- `POST /api/v1/api-keys/generate` (creates a new key; returns `plain_text_api_key`)
- `DELETE /api/v1/api-keys/{id}` (remove a key)

Important: for scraping, the API key you select is referenced by `api_key_id`.

### Step 3: Create a scrape request
Call:
- `POST /api/v1/scrape`

Auth:
- Provide the plaintext API key in header `x-api-key: <plain_key>`

Request body:
- `url` (required, valid URL, max 2048)

Response (`202 Accepted`):
- `request_id` (the stored scrape request id)

Internally, this dispatches a queued job (`ScrapeWebsiteJob`) on queue `scraping`.
Note: the current `ScrapeWebsiteJob::handle()` is intentionally blank, so no actual scraping implementation is present yet.

### Step 4: View results / status
Use dashboard endpoints to see scrape requests:
- `GET /api/v1/dashboard/recent-requests` (latest 10)
- `GET /api/v1/dashboard/stats` (aggregate counts + credits used)

## Web UI Workflow (optional)

### Auth pages
- `GET /login` and `GET /register` return the Blade pages.
- `POST /register` and `POST /login` are handled by the scaffold controllers in `routes/auth.php`.

### Dashboard API keys
- `GET /dashboard` renders `resources/views/dashboard/index.blade.php`
- `POST /dashboard/api-keys/generate` generates a key and redirects back
- The plaintext key is displayed once using session values (`new_api_key`) and the dashboard shows:
  - key `name`
  - `key_last4` hint (not full key)
  - usage `usage_count / usage_limit`

## Admin Workflow (optional)

Admin endpoints are:
- `GET /api/v1/admin/users`
- `PATCH /api/v1/admin/users/{id}/status`

They require:
- Sanctum auth (`auth:sanctum`)
- Account active check (`active.user`)
- Role check (`role:admin`)

## What we created so far

- `API_ENDPOINTS.md`: a generated reference listing:
  - all discovered endpoints (web + API)
  - request/response fields
  - example `curl` commands for testing the API

