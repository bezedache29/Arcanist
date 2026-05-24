# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

# Instructions pour Claude

- Réponds toujours en français dans le chat.
- Les commentaires dans le code doivent être en français.
- Les tests et le code lui-même doivent être écrits en anglais.

## Project Overview

Arcanist is a PHP 8.2 B2B e-commerce application (product catalog for professionals). It runs on Apache via Docker, with MySQL 8.4, and uses Tailwind CSS for styling.

## Development Environment

Start the full stack:

```bash
docker compose up -d
```

The app is served by Traefik at `https://arcanist.localhost`. phpMyAdmin is at `https://pma-arcanist.localhost`. The MySQL port is forwarded to `3307` locally.

Import/reset the database schema:

```bash
docker compose exec arcanist.app bash -c "mysql -h mysql -u sail -ppassword arcanist_db < /var/www/html/database.sql"
```

Copy `.env.exemple` to `.env` and fill in the values before first run.

There are no automated tests. Verify changes manually via the browser.

## Architecture

### Routing and Request Flow

The app is a hybrid: the Arcane microframework (`index.php`) handles the root URL, but most pages are accessed **directly** by their file path (e.g. `/pages/dashboard.php`). Apache rewrites unmatched requests to `index.php`, but actual `.php` files in `pages/` are served directly and act as controllers.

Each page controller follows this pattern:

1. `require_once __DIR__ . '/../../bootstrap.php'` (adjust depth as needed)
2. `require_alias('@/helpers/db.php')` and `require_alias('@/helpers/view.php')`
3. `session_start()`
4. Auth/admin guard (redirect if not logged in or not admin)
5. Handle `POST` logic (validate, CSRF check, DB write, redirect)
6. Call `render_view('path/to/view', $data, 'layout')`

### Directory Structure

- `pages/` — Controllers: business logic, session checks, POST handling, CSRF
- `views/` — HTML templates, rendered by `render_view()` from `helpers/view.php`
- `layouts/` — Page shells: `app.php` (user), `auth.php` (login/register), `admin.php`
- `components/` — Reusable UI elements: `button`, `card`, `input`, `modal`, `textarea`, `title`
- `helpers/` — Global PHP functions auto-available via `require_alias()`:
  - `db.php`: `getDbConnection()` returns a PDO connection from env vars
  - `view.php`: `render_view(viewPath, data, layout)` and `render_component(componentPath, data)`
  - `debug.php`: `dd(...$vars)` dump-and-die
- `public/uploads/products/` — Uploaded product images (served statically)
- `bootstrap.php` — Defines `ROOT_PATH` constant and `require_alias('@/...')` path helper

### Path Alias

`@/` is an alias for the project root (defined in `bootstrap.php`):

```php
require_alias('@/helpers/db.php');  // loads helpers/db.php
```

### Database

Tables: `clients`, `categories`, `products`, `category_product` (pivot), `orders`. All tables support soft delete via a `deleted_at` column — always filter with `WHERE deleted_at IS NULL` for active records.

Auth uses `password_hash()` / `password_verify()`. Session stores `user_id`, `is_admin`, `company`.

### Security Patterns

- **CSRF**: Generate token with `bin2hex(random_bytes(32))` stored in `$_SESSION['csrf_token']`, validate with `hash_equals()` on POST
- **Auth guard**: Check `$_SESSION['user_id']` (user) and `$_SESSION['is_admin']` (admin pages)
- **Image uploads**: Validate via `mime_content_type()`, convert to WebP via GD if available, store in `public/uploads/products/`
- **Category IDs whitelist**: Build a whitelist array from DB results before trusting any submitted category IDs

### UI and Styling

Tailwind is loaded via CDN in layouts (dark mode: `class` strategy). The local `tailwind.config.js` defines two custom color palettes:

- `arcane-*`: dark purple (backgrounds, cards, borders)
- `mystic-*`: gold (buttons, accents, prices)

Two font families: `font-grimoire` (Playfair Display, for titles) and `font-ui` (Inter, for interface text).

Use `render_component('button', [...])` to render UI components — pass props as an associative array. See `components/button.php` for available `variant` (`primary`, `secondary`, `outline`, `ghost`, `danger`) and `size` (`sm`, `md`, `lg`) values.
