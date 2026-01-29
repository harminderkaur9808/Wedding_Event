# Email Not Working on Live – Fix Guide

Emails (signup welcome, admin notifications, approval/rejection) were not sending on the **live** server. Here’s what was wrong and how to fix it.

---

## Root causes

1. **Duplicate `MAIL_MAILER` in `.env`**  
   Having both `MAIL_MAILER=log` and `MAIL_MAILER=smtp` can lead to the wrong driver being used. With `log`, Laravel only writes emails to the log file and does **not** send them.

2. **Cached config on live**  
   In production Laravel caches config. If the server was ever run with `MAIL_MAILER=log`, that value can stay in the cache even after you change `.env`.

3. **Missing `MAIL_ENCRYPTION`**  
   For Gmail (port 587) you need `MAIL_ENCRYPTION=tls`. For Hostinger (port 465) use `MAIL_ENCRYPTION=ssl`.

---

## Fix on the live server

### 1. Fix `.env` on the live server

Edit the **live** `.env` and make sure the mail section looks like this (no duplicate `MAIL_MAILER`, only one line):

**If using Gmail:**

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-gmail@gmail.com
MAIL_PASSWORD="your-app-password"
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="your-gmail@gmail.com"
MAIL_FROM_NAME="${APP_NAME}"
```

**If using Hostinger SMTP:**

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=465
MAIL_USERNAME=info@yourdomain.com
MAIL_PASSWORD="your-password"
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=info@yourdomain.com
MAIL_FROM_NAME="${APP_NAME}"
```

- Remove any **second** `MAIL_MAILER=log` line so you have only **one** `MAIL_MAILER=smtp`.
- Do **not** leave `MAIL_MAILER=log` as the only (or first) mailer if you want real emails to be sent.

### 2. Clear config cache on live

After changing `.env`, run on the **live** server (SSH or hosting terminal):

```bash
cd /path/to/your/project
php artisan config:clear
```

Then optionally recache:

```bash
php artisan config:cache
```

If you don’t clear (or recache) config, Laravel may keep using the old mail driver and emails will still not send.

### 3. Gmail: use an App Password

- Do **not** use your normal Gmail password.
- Enable 2-Step Verification on the Google account.
- Create an **App Password**: Google Account → Security → 2-Step Verification → App passwords.
- Put that 16-character password in `MAIL_PASSWORD` (with quotes if it contains spaces).

### 4. Check logs if it still fails

On the server:

```bash
tail -f storage/logs/laravel.log
```

Trigger a signup or action that sends an email. Look for mail-related errors (SMTP auth, connection, etc.).

---

## What was changed in this project

- **`.envlive`**  
  - Removed duplicate `MAIL_MAILER=log`, kept only `MAIL_MAILER=smtp`.  
  - Added `MAIL_ENCRYPTION=tls` for Gmail.

- **`config/mail.php`**  
  - Added `'encryption' => env('MAIL_ENCRYPTION')` to the `smtp` mailer so `MAIL_ENCRYPTION` is used.

- **Your local `.env`**  
  - If you have both `MAIL_MAILER=log` and `MAIL_MAILER=smtp`, remove the `MAIL_MAILER=log` line and keep only `MAIL_MAILER=smtp` (and set `MAIL_ENCRYPTION` as above).  
  - You can use `.envlive` as a reference for the live server.

---

## Where emails are sent in this app

| Action              | Email(s)                     |
|---------------------|------------------------------|
| User signup         | Welcome email to user; new user notification to admins |
| Admin approves user | User approval email          |
| Admin rejects user  | User rejection email         |

All of these use Laravel’s `Mail` facade and the default mailer. Once `MAIL_MAILER=smtp` is set correctly and config cache is cleared on live, these should work.
