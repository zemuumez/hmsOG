import assert from "node:assert/strict";
import { spawn } from "node:child_process";
import { once } from "node:events";
import { createServer } from "node:http";
import { setTimeout } from "node:timers/promises";
import { after, before, test } from "node:test";

let backendUnavailable = false;
const fixture = {
  settings: { app_name: "Test Hospital", hospital_phone: "123456", hospital_email: "hello@example.test" },
  content: { home_page_title: "Test hospital care", privacy_policy: "Test privacy policy" },
  services: [{ id: 1, name: "Test service", description: "Test service description" }],
  doctors: [{ id: 7, name: "Test Doctor", department: "Test department", specialist: "Test specialty", qualification: "Test qualification" }],
  testimonials: [{ id: 1, name: "Test visitor", description: "Test experience" }],
  hours: [{ day: "Monday", start: "08:00", end: "17:00" }],
};
const api = createServer((request, response) => {
  assert.equal(request.url, "/api/public/website");
  response.writeHead(backendUnavailable ? 503 : 200, { "Content-Type": "application/json" });
  response.end(JSON.stringify(backendUnavailable ? { error: "unavailable" } : { data: fixture }));
});
let app;
let output = "";
const base = "http://127.0.0.1:3199";

before(async () => {
  api.listen(0, "127.0.0.1");
  await once(api, "listening");
  app = spawn(process.execPath, ["node_modules/next/dist/bin/next", "start", "--hostname", "127.0.0.1", "--port", "3199"], {
    env: { ...process.env, LARAVEL_URL: `http://127.0.0.1:${api.address().port}`, NEXT_TELEMETRY_DISABLED: "1" },
    stdio: ["ignore", "pipe", "pipe"],
  });
  app.stdout.on("data", chunk => { output += chunk; });
  app.stderr.on("data", chunk => { output += chunk; });
  for (let i = 0; i < 150; i++) {
    if (app.exitCode !== null) throw new Error(output);
    try {
      const response = await fetch(base);
      if (response.ok) return;
    } catch {}
    await setTimeout(200);
  }
  throw new Error(`Next.js did not start. Run npm run build before npm test.\n${output}`);
});

after(async () => {
  if (app && app.exitCode === null) {
    const exited = once(app, "exit");
    app.kill();
    await exited;
  }
  api.close();
  api.closeAllConnections();
});

test("public routes render real API content and accessible navigation", async () => {
  for (const [route, expected] of [
    ["/", "Test hospital care"], ["/our-services", "Test service"],
    ["/our-doctors", "Test Doctor"], ["/doctor-details/7", "Test qualification"],
    ["/working-hours", "Monday"], ["/testimonial", "Test experience"],
    ["/privacy-policy", "Test privacy policy"], ["/terms-of-service", "Terms of service"],
    ["/about-us", "About our hospital"], ["/contact-us", "hello@example.test"],
    ["/appointment", "Continue to hospital booking"],
  ]) {
    const response = await fetch(base + route);
    assert.equal(response.status, 200, route);
    const html = await response.text();
    assert.ok(html.includes(expected), `${route} content`);
    assert.ok(html.includes('id="main-content"'), `${route} skip target`);
    assert.ok(html.includes('aria-label="Main navigation"'), `${route} navigation`);
  }
});

test("unknown routes and doctor IDs return not found", async () => {
  for (const path of ["/missing-page", "/doctor-details/999", "/constructor"]) {
    const response = await fetch(base + path);
    const html = await response.text();
    assert.ok(html.includes("Page not found"), path);
    assert.ok(response.status === 404 || html.includes('name="robots" content="noindex"'), path);
  }
});

test("backend outage is visible and does not fabricate catalog content", async () => {
  backendUnavailable = true;
  try {
    const response = await fetch(base + "/our-doctors");
    const html = await response.text();
    assert.equal(response.status, 200);
    assert.ok(html.includes("Hospital information is temporarily unavailable"));
    assert.ok(html.includes("No doctors are available"));
    assert.ok(!html.includes("Test Doctor"));
  } finally {
    backendUnavailable = false;
  }
});
