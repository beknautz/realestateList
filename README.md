# Firman Pollen — Farm-Tech Website + PHP CMS

A redesigned `firmanpollen.com` concept built with **PHP**, **HTML5**, **HTMX**, **Bootstrap 5**, and **MySQL**.

## Features

- Clean farm-tech front-end design with responsive Bootstrap layout.
- Dynamic navigation and page rendering from database content.
- CMS backend for:
  - Create / edit / delete pages.
  - Create / edit / delete page sections.
  - Manage global settings (site name, tagline, footer text).
- HTMX-powered section management for smooth in-place CRUD updates.
- Basic admin authentication through environment-configured credentials.

## Stack

- PHP 8+
- MySQL 8+
- Bootstrap 5
- HTMX

## Project Structure

- `public/index.php` — main website renderer.
- `public/admin/login.php` — CMS login.
- `public/admin/dashboard.php` — CMS main page/page settings manager.
- `public/admin/sections.php` — HTMX endpoint for section CRUD.
- `includes/db.php` / `includes/functions.php` — shared app logic.
- `templates/` — shared header/footer templates.
- `public/assets/css/style.css` — visual styling.
- `setup.sql` — database schema + starter content.

## Setup

1. Create DB and starter content:

   ```bash
   mysql -u root -p < setup.sql
   ```

2. Configure environment variables (example):

   ```bash
   export DB_HOST=127.0.0.1
   export DB_PORT=3306
   export DB_NAME=firmanpollen
   export DB_USER=root
   export DB_PASS=secret

   export ADMIN_USER=admin
   export ADMIN_PASS='replace-with-strong-password'
   ```

3. Start local PHP server:

   ```bash
   php -S 0.0.0.0:8080 -t public
   ```

4. Open:

   - Website: `http://localhost:8080`
   - CMS: `http://localhost:8080/admin/login.php`

## Notes

- For production, run behind Apache or Nginx with HTTPS.
- Move admin auth to hashed users in DB for multi-user support.
- Add CSRF tokens and audit logs for hardened security.
