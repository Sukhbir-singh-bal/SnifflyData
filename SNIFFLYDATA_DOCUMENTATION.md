# SnifflyData - Complete Documentation

Welcome to the **SnifflyData (ScrapeFlow)** documentation. This document serves as a comprehensive guide to what has been built, the overarching application workflow, and a reference for all available API endpoints.

---

## 1. What We Have Built So Far

We have developed a robust, production-ready web application and API service tailored for handling sophisticated scraping requests, managing API keys securely, and providing an incredible User Dashboard experience.

### Core Architecture & API
- **Authentication:** Dual-authentication system utilizing Laravel Sanctum for the UI and dashboard interactions, while employing highly secure, hashed Plaintext API Keys for machine-to-machine core scraping endpoints.
- **Background Processing System:** Real-time job passing to Laravel queues (`ScrapeWebsiteJob`) to handle heavy workloads asynchronously, preventing frontend blocking.
- **Modular Data Models:** Extensible relationships spanning `Users`, `ApiKeys`, `ScrapeRequests`, and `UsageLogs`.

### User Dashboard UI (Dark Theme / Glassmorphism)
The web dashboard is fully separated into dedicated, immersive interfaces:
1. **Overview Page (`/dashboard`):** High-level metric cards detailing total lifetime requests, success rates, credits consumed, and a consolidated table of the latest account activity.
2. **API Keys Page (`/dashboard/api-keys`):** A dedicated interface allowing users to generate new keys (with custom naming constraints), view `sk_••••_` previews, and immediately copy the one-time plaintext key securely.
3. **Requests Tracking Page (`/dashboard/requests`):** Advanced, paginated data table showcasing URL tracking, response times, and credit usage. *Features an automated real-time JavaScript polling engine* that contacts an internal status API to update pending request badges instantly upon background job completion.
4. **Usage Analytics Page (`/dashboard/usage`):** Detailed breakdown metrics calculating average response speeds and plotting consumption rates per individual API key with dynamic visual progress bars.
5. **API Playground (`/dashboard/playground`):** A native, Postman-inspired integrated testing environment. Users can toggle between HTTP methods and predefined endpoints, seamlessly pass their API Plaintext keys, and validate JSON payloads with syntax-highlighted response blocks directly in the browser.

---

## 2. Platform Workflow

Here is how users structurally interact with the SnifflyData system:

### Phase 1: Authentication & Onboarding
1. A new user signs up via the UI `POST /register` or via the API.
2. The user is instantly provisioned a Sanctum Bearer token for accessing standard API resources (`/user`, `/dashboard/*`).
3. An initial "Default" API Key is automatically generated upon registration.

### Phase 2: Key Management
1. Inside the UI's **API Keys** tab, the user can generate additional keys (e.g., "Production", "Testing", "App A").
2. The database securely hashes these keys into a `key_hash`.
3. The user stores the raw Plaintext Key (e.g., `sk_abcd1234...`) in their `.env` file or environment variables on their own server.

### Phase 3: Triggering a Scrape (Execution)
1. The user's external server sends a `POST` request to `https://snifflydata.com/api/v1/scrape`.
2. The payload contains the target website URL: `{"url": "https://example.com"}`.
3. Crucially, the external server attaches headers: `x-api-key: sk_abcd1234...`.
4. The system validates the `x-api-key`, validates available credits, logs the request, and dispatches a background worker to run the browser crawler.
5. The API immediately returns a `202 Accepted` alongside the `request_id`.

### Phase 4: Monitoring Results & Polling
1. The user's dashboard (or webhook systems) actively polls the `/dashboard/requests/{id}/status` or API equivalencies.
2. Once the background crawler completes, the status mutates from `pending` -> `success` / `failed`.
3. The response time and precise credit usage algorithms finalize the record, making the payload directly available to the user's infrastructure.

---

## 3. API Endpoints Reference

All API routes assume you are communicating with `application/json`.
Base URL path: `api/v1/...`

### Public Auth Endpoints
- **`POST /register`**
  - **Body:** `name`, `email`, `password`, `password_confirmation`.
  - **Returns (201):** User object, Sanctum token, and `plain_text_api_key`.
- **`POST /login`**
  - **Body:** `email`, `password`.
  - **Returns (200):** Sanctum `token`.

### Core Scraping Endpoint (Machine-to-Machine)
*Does not use Sanctum Bearer tokens. Requires explicit Plaintext API Secret.*
- **`POST /scrape`**
  - **Headers:** `x-api-key: YOUR_PLAINTEXT_API_KEY`
  - **Body:** `{"url": "https://example.com"}`
  - **Returns (202):** `{"request_id": 1234}` (Dispatches background scraper job).

### Authenticated Account Data (Sanctum)
*Requires header: `Authorization: Bearer YOUR_SANCTUM_TOKEN`*

**User & Profile**
- **`GET /user`**: Fetch current user entity.
- **`GET /profile`**: Fetch current profile information.
- **`PATCH /profile`**: Update `name` or `email`.
- **`POST /logout`**: Destroys active token.

**API Key Management**
- **`GET /api-keys`**: Returns a list of generated keys masking secrets (`last4`).
- **`POST /api-keys/generate`**:
  - **Body:** `name` (optional), `usage_limit` (optional).
  - **Returns (201):** Newly created key and raw `plain_text_api_key`.
- **`DELETE /api-keys/{id}`**: Revokes access to an API key instantly.

**Dashboard Analytics & Stats**
- **`GET /dashboard/stats`**: Returns aggregate figures including `total_requests`, `success_rate`, and `credits_used`.
- **`GET /dashboard/recent-requests`**: Returns paginated list of the 10 most recent `ScrapeRequest` logs for the active user.

### Administrative Control Endpoints
*Requires Sanctum token belonging to a super-user/admin.*
- **`GET /admin/users`**: List and search all global users.
- **`PATCH /admin/users/{id}/status`**: Toggle user privileges (`is_active: false/true`) locking out rogue platform accounts.
