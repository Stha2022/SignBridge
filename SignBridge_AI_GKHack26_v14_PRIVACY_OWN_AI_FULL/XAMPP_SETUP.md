# SignBridge AI — XAMPP + MySQL setup

## 1. Put the project in XAMPP
Copy this entire folder to:

`C:\xampp\htdocs\signbridge-v2\`

Keep `public`, `api`, `package.json`, `server.js`, etc. inside the project.

## 2. Start XAMPP
Start **Apache** and **MySQL**.

## 3. Create the database
Open:

`http://localhost/phpmyadmin`

Choose **Import** and import:

`api/schema.sql`

This creates the `signbridge` database and the `users` table.

## 4. Configure PHP
Copy:

`api/config.php.example`

to:

`api/config.php`

Default XAMPP values are:

- Host: 127.0.0.1
- Database: signbridge
- User: root
- Password: blank (unless you changed your MySQL password)

## 5. Open the app through Apache
Use:

`http://localhost/signbridge-v2/public/`

Do **not** use VS Code Live Server for the MySQL login demonstration.

## Where account data goes
Create Account → PHP `api/auth.php` → MySQL `signbridge.users`.

Passwords are stored as secure password hashes using PHP `password_hash()`; the plain password is not stored in MySQL.

Authentication is intentionally NOT stored in localStorage.
- registration and sign-in require the PHP + MySQL backend
- PHP creates a server-side session after successful authentication
- training samples stay in browser localStorage on this device
- no raw camera video is uploaded by the app

## Camera
Camera access works on `localhost` and on HTTPS deployments. When Chrome asks for camera permission, choose **Allow**.

If the camera says it is busy, close Zoom/Teams/OBS/other camera tabs and retry.

## Optional Node server
The Node server is still included for local development and the online AI-assist endpoint. The PHP/MySQL path above is the recommended hackathon demonstration path because it matches the team's PHP/MySQL stack.
