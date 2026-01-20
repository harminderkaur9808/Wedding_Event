# Fix 500 Server Error - Step by Step Guide

## Common Causes and Solutions

### 1. Check Server Error Logs
First, check your hosting error logs in cPanel:
- Go to cPanel → Metrics → Errors
- Look for the specific error message
- This will tell you exactly what's wrong

### 2. Fix .htaccess File
The root `.htaccess` has been simplified. If you still get errors, try this:

**Option A: Use the simplified .htaccess (already updated)**
The root `.htaccess` now only redirects to public folder.

**Option B: If document root is set to public folder**
If your hosting allows you to set document root to `public/` folder:
- Delete or rename the root `.htaccess`
- Point document root to `public/` directory
- Use only `public/.htaccess`

### 3. Check PHP Version
- Go to cPanel → Select PHP Version
- Make sure PHP 8.1 or higher is selected
- Required extensions: OpenSSL, PDO, Mbstring, Tokenizer, XML, Ctype, JSON

### 4. Set Correct Permissions
Via cPanel File Manager or SSH:
```bash
chmod 755 storage
chmod 755 bootstrap/cache
chmod 644 .env
```

### 5. Verify .env File Exists
Make sure `.env` file exists in root with:
```
APP_NAME="Wedding Event"
APP_ENV=production
APP_KEY=base64:your-key-here
APP_DEBUG=false
APP_URL=http://your-domain.com
```

### 6. Generate Application Key
If APP_KEY is missing, run via SSH or cPanel Terminal:
```bash
php artisan key:generate
```

### 7. Install Dependencies
Make sure `vendor/` folder is uploaded. If missing:
```bash
composer install --no-dev --optimize-autoloader
```

### 8. Clear All Caches
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

### 9. Check File Structure
Make sure these folders exist and have correct permissions:
- `/storage` (755)
- `/storage/logs` (755)
- `/bootstrap/cache` (755)
- `/public` (755)

### 10. Test Direct Access
Try accessing directly:
- `http://your-domain.com/public/` - Should show Laravel welcome or your site
- `http://your-domain.com/public/index.php` - Should work

### 11. Alternative: Point Document Root to Public
**Best Solution for Hostinger:**
1. In cPanel, go to "Subdomains" or "Addon Domains"
2. Change document root from `/public_html` to `/public_html/public`
3. Delete root `.htaccess` and `index.php`
4. Access site directly without `/public` in URL

### 12. Disable Problematic Modules
If still getting errors, temporarily disable security headers in `.htaccess`:
- Comment out `<IfModule mod_headers.c>` section
- Comment out `<IfModule mod_deflate.c>` section
- Comment out `<IfModule mod_expires.c>` section

## Quick Fix Checklist

- [ ] Check error logs in cPanel
- [ ] Verify PHP version is 8.1+
- [ ] Check `.env` file exists and has APP_KEY
- [ ] Set correct permissions (755 for folders, 644 for files)
- [ ] Verify `vendor/` folder is uploaded
- [ ] Clear all Laravel caches
- [ ] Test if `public/` folder is accessible directly
- [ ] Try setting document root to `public/` folder

## Still Not Working?

1. **Enable Error Display Temporarily:**
   In `.env` set: `APP_DEBUG=true` (change back to false after fixing)

2. **Check Apache Error Log:**
   Usually located at: `/home/username/logs/error_log`

3. **Contact Hosting Support:**
   Ask them to:
   - Check if mod_rewrite is enabled
   - Verify PHP version and extensions
   - Check error logs for your domain
