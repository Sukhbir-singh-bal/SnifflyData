import express from 'express';
import { randomUUID } from 'node:crypto';
import { chromium } from 'playwright';

const app = express();

app.use(
  express.json({
    limit: '1mb',
  }),
);
app.disable('x-powered-by');

const PORT = process.env.PORT ? Number(process.env.PORT) : 3000;
const SCRAPE_TIMEOUT_MS = process.env.SCRAPE_TIMEOUT_MS
  ? Number(process.env.SCRAPE_TIMEOUT_MS)
  : 10_000;

let browser;

function isBlockedErrorText(text) {
  if (!text) return false;
  return /ERR_BLOCKED|blocked|BLOCKED_REQUEST/i.test(String(text));
}

async function scrapeHtml(url) {
  const page = await browser.newPage();

  // Hard cap so a single request cannot hang the service.
  page.setDefaultTimeout(SCRAPE_TIMEOUT_MS);
  page.setDefaultNavigationTimeout(SCRAPE_TIMEOUT_MS);

  let blocked = false;
  const blockedFailures = [];

  page.on('requestfailed', (request) => {
    const failure = request.failure();
    const errorText = failure?.errorText || failure?.message || '';

    if (isBlockedErrorText(errorText)) {
      blocked = true;
      blockedFailures.push({
        url: request.url(),
        errorText,
      });
    }
  });

  try {
    await page.goto(url, {
      waitUntil: 'load',
      timeout: SCRAPE_TIMEOUT_MS,
    });

    if (blocked) {
      const err = new Error('Blocked requests detected.');
      err.code = 'blocked_requests';
      err.details = blockedFailures;
      throw err;
    }

    const html = await page.content();
    return html;
  } finally {
    // Always release the page, even on errors.
    await page.close().catch(() => {});
  }
}

app.post('/scrape', async (req, res) => {
  const requestId = randomUUID();
  const startedAt = Date.now();

  const url = req?.body?.url;
  console.info(`[scrape] requestId=${requestId} url=${url}`);

  if (!url || typeof url !== 'string') {
    return res.status(400).json({
      success: false,
      status_code: 400,
      error: 'invalid_request',
      message: '`url` must be a string',
    });
  }

  let parsedUrl;
  try {
    parsedUrl = new URL(url);
  } catch {
    return res.status(400).json({
      success: false,
      status_code: 400,
      error: 'invalid_url',
      message: '`url` must be a valid URL',
    });
  }

  try {
    const html = await scrapeHtml(parsedUrl.toString());
    const elapsedMs = Date.now() - startedAt;

    console.info(
      `[scrape] requestId=${requestId} success=true elapsedMs=${elapsedMs}`,
    );

    return res.status(200).json({
      success: true,
      html,
      status_code: 200,
    });
  } catch (err) {
    const elapsedMs = Date.now() - startedAt;

    const message =
      err instanceof Error ? err.message : 'Unknown scraping error';

    let status = 500;
    let error = 'internal_error';

    if (err?.code === 'blocked_requests' || isBlockedErrorText(message)) {
      status = 403;
      error = 'blocked_requests';
    } else if (err?.name === 'TimeoutError') {
      status = 504;
      error = 'timeout';
    }

    console.warn(
      `[scrape] requestId=${requestId} success=false error=${error} elapsedMs=${elapsedMs}`,
    );

    return res.status(status).json({
      success: false,
      status_code: status,
      error,
      message,
    });
  }
});

async function start() {
  browser = await chromium.launch({
    headless: true,
  });

  const server = app.listen(PORT, () => {
    console.info(`scraper-service listening on port ${PORT}`);
  });

  const shutdown = async () => {
    server.close();
    if (browser) await browser.close().catch(() => {});
    process.exit(0);
  };

  process.on('SIGINT', shutdown);
  process.on('SIGTERM', shutdown);
}

start().catch((err) => {
  console.error('Failed to start scraper-service', err);
  process.exit(1);
});

