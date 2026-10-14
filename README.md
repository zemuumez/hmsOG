
<p><img src="https://track.infyom.com/assets/img/logo-red-black.png"></p>

## Hospital Management System

## Next.js frontend

The public website is being migrated to `frontend/` using Next.js App Router,
TypeScript, and Tailwind CSS. Laravel remains the backend. This is the first
migration stage: booking, enquiries, authentication, payments, and staff/patient
portals still run in Laravel. See [frontend setup and migration coverage](frontend/README.md).

- Install the frontend with `npm run frontend:install` (Node.js 20.9 or newer).
- Copy `frontend/.env.example` to `frontend/.env.local` and configure Laravel URLs.
- Start Laravel separately, then run `npm run dev` for Next.js on port 3000.
- Run `npm run lint`, `npm run typecheck`, and `npm run build` before deployment.
- Existing Blade assets still use `npm run legacy:dev` or `npm run production`.

## Installation Step

Clone a Project

- Run `composer install`
- Run `php artisan key:generate`
- Run `php artisan jwt:secret`
- **Setup .env file**
- **Run migration `php artisan migrate`**
- **Run seeder `php artisan db:seed`**
- **Create virtual host with name `local.hms.com`**
- **Run `npm install`**
- **Run `npm run legacy:dev` to compile the existing Blade portal assets**
