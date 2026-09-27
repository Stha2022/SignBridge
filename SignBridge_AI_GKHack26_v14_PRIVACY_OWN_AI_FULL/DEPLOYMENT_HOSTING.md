# SignBridge AI — Deployment Guide

## Recommended for the hackathon demo

Use a PHP/MySQL host with HTTPS. InfinityFree currently advertises PHP 8.3, MySQL 8.0/MariaDB 11.4, free SSL, FTP and `.htaccess` support. The free plan is suitable for a lightweight demonstration, while production use should move to paid hosting with stronger resources and support.

### Before upload
1. Export your local `signbridge` MySQL database or run `api/schema.sql` in the host's phpMyAdmin.
2. Update `api/config.php` with the host-provided database name, username, password and host.
3. Never publish the local XAMPP database password or `.env` secrets.

### Upload
Upload the contents of this project so `public/index.html` is the web root. If the host cannot set a subdirectory as the document root, place the contents of `public/` in `htdocs`/`public_html` and keep `api/` one level above it only if the PHP paths are adjusted accordingly. For the simplest deployment, keep the project structure intact and set the web root to `public`.

### Test
- Open the HTTPS URL.
- Register a new user.
- Confirm the row appears in MySQL/phpMyAdmin.
- Sign out and sign in again.
- Test camera permission.
- Test Text → Sign.
- Test Learn SASL video embeds.

## Production option
Hostinger supports PHP, MySQL, MySQLi/PDO and phpMyAdmin on its web/cloud hosting plans. It is a better long-term option if SignBridge moves beyond the hackathon prototype.

## QR code
Once the final HTTPS URL exists, generate a QR code pointing to that URL. Do not generate the final QR code before the production URL is known.


## Privacy deployment checklist — GKHack26
- Serve the site over HTTPS.
- Run `api/migration_privacy.sql` if the `users` table already exists.
- Verify the registration Privacy Notice is visible and required.
- Do not add an external LLM/API key for the core recognition demo.
- Confirm browser camera input is not uploaded by inspecting Network requests.
- Confirm no raw camera/video files are written to the server.
- Keep database credentials in `api/config.php` and never commit them to a public repository.
- Review hosting-provider logs, backups and database location before any production deployment.
