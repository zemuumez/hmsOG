# Hospital frontend

Next.js App Router, strict TypeScript, and Tailwind CSS. Laravel owns the database,
permissions, authentication, booking rules, and payment integrations.

## Run locally

1. Install Node.js 20.9+ and the existing Laravel PHP dependencies.
2. Run `npm ci` in this directory.
3. Copy `.env.example` to `.env.local`.
4. Set `LARAVEL_URL` to the direct Laravel origin reachable by the Next.js server.
5. Set `NEXT_PUBLIC_LARAVEL_URL` to the Laravel origin reachable by the browser.
6. Start Laravel separately (for example `php artisan serve`).
7. Run `npm run dev` and open http://localhost:3000.

Laravel must expose `GET /api/public/website` from this checkout. The public API
projects approved fields only; it must never return full User or Setting models.
Do not point either Laravel URL back at Next.js. Public environment variables are
embedded at build time; configure them before building. Use HTTPS origins in production.

## Structure and reuse

- `src/components/ui.tsx`: shared containers, cards, links, headings, empty states.
- `src/components/catalog.tsx`: shared doctor and service grids.
- `src/components/site-*.tsx`: responsive navigation and footer.
- `src/lib/website.ts`: server-only backend access and shared domain types.
- `src/lib/links.ts`: navigation and links to Laravel workflows.
- `src/app`: route composition, loading, error, and not-found boundaries.

Use server components for data and page composition. Limit client components to
interactive UI. No jQuery, Bootstrap, remote fonts, browser tokens, or duplicated
hospital records are needed by this frontend. Backend failures show an explicit
unavailable state; no sample patients, doctors, or hospital statistics are substituted.

## Migration coverage

This is a public-site migration stage, not full Blade/Livewire feature parity.

| Route | Implementation |
| --- | --- |
| `/` | Next.js home with live services and doctors |
| `/our-services`, `/our-doctors` | Next.js catalogs |
| `/doctor-details/:id` | Next.js public profile; Laravel schedule/booking link |
| `/about-us`, `/working-hours`, `/testimonial` | Next.js content pages |
| `/privacy-policy`, `/terms-of-service` | Next.js plain-text policy content |
| `/contact-us` | Next.js contact details; Laravel enquiry form link |
| `/appointment` | Next.js handoff to Laravel booking |
| Login, registration, 2FA, portals, payments, QR records | Existing Laravel UI |

Public content currently displays in English. Blade localization, rich policy HTML,
images, catalog pagination, and full transactional forms remain migration work.
Do not remove Blade views or legacy assets until their replacements have verified
feature parity. No production traffic is automatically redirected by this change.

## Verify and deploy

Run `npm run lint`, `npm run typecheck`, `npm run build`, then `npm test`.
The integration smoke suite uses a mock public API and a running Next.js server;
see `tests/smoke.test.mjs`. It does not exercise a live Laravel database.
Run `php artisan test` in the repository root once PHP is available, and verify
the new public endpoint against a seeded database before routing public traffic.

Run `npm run start` after building. Host Next.js and Laravel on separate origins,
with the configured Laravel origin retaining its existing routes and session cookies.
Switch only migrated public routes at your reverse proxy after acceptance testing;
keep payment callbacks and all authenticated workflows on Laravel. Because reads
are server-to-server and transactional forms stay on Laravel, no permissive CORS
policy or cookie forwarding proxy is introduced.

The Tailwind integration follows the generated Next.js template; reference:
https://tailwindcss.com/docs/installation/framework-guides/nextjs

## Validation notes

Verified locally: lint, strict type checking, production build, all three smoke
tests (eleven public routes, missing pages, and backend outages), live Laravel
public API response, PHP controller syntax, and mobile menu navigation.

The existing Laravel feature example fails against its empty SQLite test database
because the `settings` table is absent. The unit example passes. This fixture/setup
issue must be resolved before claiming that the full backend suite passes.

`npm audit --omit=dev` reports no production advisories. The full audit currently
reports five high-severity development-tool entries from one `braces` advisory
propagated through the Next.js ESLint plugin. The registry has no patched `braces`
release; avoid an automatic forced downgrade of Next.js lint tooling. Recheck
the advisory when updating dependencies.
