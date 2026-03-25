# scraper-service

Minimal Express + Playwright microservice.

## Run

From `scraper-service/`:

```bash
npm install
# Install Playwright browser binaries (needed if your environment skips downloads).
npx playwright install chromium
npm run start
```

It exposes:

- `POST /scrape`
  - Body: `{ "url": "https://example.com" }`
  - Returns: `{ success: true, html: "...", status_code: 200 }` on success

## Config

- `PORT` (default: `3000`)
- `SCRAPE_TIMEOUT_MS` (default: `10000`)

