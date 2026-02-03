# Testing – Error Categories

A simple list of error types to check when testing the Wedding Event app. Grouped by **Server**, **Frontend**, and **API / Request** (overall, not framework-specific).

---

## 1. Server related

| Error / Area | What to check |
|--------------|----------------|
| **Server / environment** | Wrong PHP version, missing extensions, `.env` missing or wrong (DB, mail, `APP_KEY`). |
| **Web server / .htaccess** | Wrong document root, rewrite rules not applied, 403/404 on correct URLs, `mod_rewrite` off. |
| **Database** | Connection failed, wrong credentials, missing tables/migrations, query timeouts. |
| **File system** | No write permission on `storage/` and `bootstrap/cache/`, upload folder not writable, missing `public/storage` link. |
| **Mail** | Mail config wrong, test email fails, approval/rejection/welcome emails not sent. |
| **Internal server error (500)** | Uncaught exception, missing class/file, fatal error – check server/PHP error logs. |

---

## 2. Frontend related

| Error / Area | What to check |
|--------------|----------------|
| **Session messages** | Success/error messages after login, signup, updates, uploads, approvals not shown or wrong page. |
| **Validation on screen** | Form validation errors (e.g. required field, email format, password length) not shown next to fields. |
| **Forms** | Submit does nothing, wrong action URL, file upload form missing `enctype="multipart/form-data"`. |
| **Layout / assets** | CSS/JS/images 404, broken layout, wrong base URL for assets. |
| **Auth state in UI** | Logged-in user sees “Login” or logged-out user sees dashboard links; role (admin vs user) not reflected. |
| **Redirects** | After login/signup/action, user sent to wrong page or gets blank/error page. |

---

## 3. API / Request related

| Error / Area | What to check |
|--------------|----------------|
| **Route not found (404)** | Wrong URL, typo in route name, missing route for a link or form action. |
| **Validation (422 / bad input)** | Server rejects invalid input but no error message shown, or wrong field highlighted. |
| **Auth required** | Accessing protected page without login – should redirect to login with a clear message, not 500 or blank page. |
| **Permission denied** | User hits admin-only or user-only URL; should get “Access denied” (or similar) and redirect, not 500. |
| **POST / GET failures** | Form submit returns 500, timeout, or empty response; check request URL, method, and server logs. |
| **File upload** | Upload returns error or 500; check max size, allowed types, and write permissions. |
| **Download** | Download link returns 404 or 403; check auth and file path. |

---

## Quick checklist

- **Server:** Env, DB, storage permissions, mail, 500s in logs.  
- **Frontend:** Session messages, validation display, forms, assets, auth state, redirects.  
- **API / Request:** 404s, validation errors, auth/permission redirects, POST/upload/download.

Use this to plan tests and when debugging (e.g. “is this server, frontend, or request/API?”).
