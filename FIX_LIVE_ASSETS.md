# Fix CSS/JS Files Not Loading on Live Site

## Problem
CSS and JS files are not loading on your live site (palegoldenrod-lemur-907257.hostingersite.com).

## Solutions

### Solution 1: Update .env File on Live Server

On your live server, edit the `.env` file and ensure:

```env
APP_URL=https://palegoldenrod-lemur-907257.hostingersite.com
APP_ENV=production
APP_DEBUG=false
```

**Important:** Make sure there's NO trailing slash after the URL.

### Solution 2: Clear All Caches

SSH into your live server and run:

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
php artisan optimize:clear
```

### Solution 3: Set File Permissions

```bash
chmod -R 755 public
chmod -R 755 public/css
chmod -R 755 public/js
chmod -R 755 public/Images
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

### Solution 4: Verify Document Root

On Hostinger, make sure your **Document Root** points to the `public` folder:
- Go to Hostinger Control Panel
- Find your domain settings
- Set Document Root to: `/public_html/public` (or wherever your public folder is)

### Solution 5: Check .htaccess Files

**Root .htaccess** should redirect to public folder:
```apache
RewriteCond %{REQUEST_URI} !^/public/
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ public/$1 [L]
```

**public/.htaccess** should handle Laravel routing (already correct).

### Solution 6: Use secure_asset() for HTTPS

If your site uses HTTPS, update your views to use `secure_asset()` instead of `asset()`:

```blade
{{ secure_asset('css/style.css') }}
```

Or add this to your `.env`:
```env
ASSET_URL=https://palegoldenrod-lemur-907257.hostingersite.com
```

### Solution 7: Verify Files Are Uploaded

Make sure ALL these folders are uploaded to your live server:
- ✅ `public/css/` (all CSS files)
- ✅ `public/js/` (all JS files)
- ✅ `public/Images/` (all image folders)
- ✅ `public/Fonts/` (all font files)

### Solution 8: Test Direct Access

Test if files are accessible directly:
- https://palegoldenrod-lemur-907257.hostingersite.com/css/style.css
- https://palegoldenrod-lemur-907257.hostingersite.com/js/header.js

If these return 404, the files aren't uploaded or the path is wrong.

## Quick Fix Commands (Run on Live Server)

```bash
# Navigate to your project
cd /path/to/your/project

# Clear all caches
php artisan optimize:clear

# Set permissions
chmod -R 755 public
chmod -R 755 storage
chmod -R 755 bootstrap/cache

# Verify .env
cat .env | grep APP_URL
# Should show: APP_URL=https://palegoldenrod-lemur-907257.hostingersite.com
```

## Most Common Issue

**90% of the time, it's one of these:**
1. ❌ APP_URL has trailing slash (should be NO slash)
2. ❌ Cache not cleared after deployment
3. ❌ Files not uploaded to public folder
4. ❌ Document root not pointing to public folder

## Still Not Working?

1. Check browser console (F12) for exact error messages
2. Check Network tab to see what URLs are being requested
3. Verify the URLs match your actual file locations
4. Check if there are any 404 errors in the console
