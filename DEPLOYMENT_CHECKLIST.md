# Deployment Checklist for CSS/JS Files

## Common Issues and Solutions

### 1. **APP_URL Configuration**
Make sure your `.env` file on the live server has the correct `APP_URL`:

```env
APP_URL=https://palegoldenrod-lemur-907257.hostingersite.com
APP_ENV=production
APP_DEBUG=false
```

### 2. **Clear Laravel Cache**
After deploying, run these commands on your live server:

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

**Important for email:** If you change any `MAIL_*` settings in `.env` on live, run `php artisan config:clear` (then optionally `php artisan config:cache`). Otherwise Laravel may keep using the old mail driver and emails won’t send. See **EMAIL_LIVE_FIX.md** for full email troubleshooting.

### 3. **Check File Permissions**
Ensure your `public` folder and its contents are readable:

```bash
chmod -R 755 public
chmod -R 755 public/css
chmod -R 755 public/js
chmod -R 755 public/Images
```

### 4. **Verify .htaccess Files**
- Root `.htaccess` should redirect to `public/` folder
- `public/.htaccess` should handle Laravel routing

### 5. **Check Document Root**
On Hostinger, make sure your document root points to the `public` folder, not the root directory.

### 6. **Build Assets (if using Vite)**
If you're using Vite for any assets, build them:

```bash
npm run build
```

Then upload the `public/build` folder.

### 7. **Verify Asset Paths**
All CSS/JS files should be in:
- `public/css/` folder
- `public/js/` folder
- `public/Images/` folder

### 8. **Browser Cache**
Clear browser cache or test in incognito mode to ensure you're seeing the latest files.

## Quick Fix Script

Run this on your live server after deployment:

```bash
cd /path/to/your/project
php artisan config:clear
php artisan cache:clear
php artisan view:clear
chmod -R 755 public
```

## Testing

1. Check browser console (F12) for 404 errors on CSS/JS files
2. Verify URLs in page source - they should start with your domain
3. Test direct access: `https://yourdomain.com/css/style.css`
