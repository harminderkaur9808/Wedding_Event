# Server Setup Guide for Wedding Event Project

## Files Created for Server Deployment

1. **`index.php`** (in root) - Routes all requests to Laravel's public directory
2. **`.htaccess`** (in root) - Handles URL rewriting and security headers

## Server Configuration

### Option 1: Document Root Set to Project Root (Current Setup)
If your document root points to `/Wedding_Event/`, the setup is complete. The root `index.php` and `.htaccess` will handle routing.

### Option 2: Document Root Set to Public Directory (Recommended)
If you can change your document root, point it to `/Wedding_Event/public/` instead. This is the recommended Laravel setup.

## Required Server Settings

### PHP Requirements
- PHP >= 8.1
- Required PHP extensions:
  - OpenSSL
  - PDO
  - Mbstring
  - Tokenizer
  - XML
  - Ctype
  - JSON
  - BCMath

### Apache Requirements
- mod_rewrite must be enabled
- AllowOverride must be set to All in Apache config

### .htaccess Features Included
- URL rewriting for Laravel routes
- Security headers (X-Frame-Options, XSS Protection, etc.)
- Browser caching for static assets (images, CSS, JS)
- Gzip compression
- Protection of sensitive files (.env, .git, etc.)

## Image Paths

All images are located in `public/Images/` and are accessed using Laravel's `asset()` helper:
- `{{ asset('Images/Home/...') }}`
- `{{ asset('Images/Header/...') }}`
- `{{ asset('Images/footer/...') }}`

These paths will work correctly on the server.

## Environment Configuration

Make sure you have a `.env` file in the root directory with:
```
APP_NAME="Wedding Event"
APP_ENV=production
APP_KEY=base64:your-generated-key-here
APP_DEBUG=false
APP_URL=http://your-domain.com

# Database configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=wedding_event
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

## Steps to Deploy

1. Upload all files to your server
2. Set proper permissions:
   ```bash
   chmod -R 755 storage
   chmod -R 755 bootstrap/cache
   ```
3. Generate application key (if not set):
   ```bash
   php artisan key:generate
   ```
4. Run migrations (if needed):
   ```bash
   php artisan migrate
   ```
5. Clear and cache config:
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan view:clear
   ```

## Testing

After deployment, test:
- Homepage loads correctly
- Images display properly
- CSS and JS files load
- Navigation links work
- Countdown timer works

## Troubleshooting

### Images Not Loading
- Check file permissions on `public/Images/` directory
- Verify `.htaccess` is working
- Check browser console for 404 errors

### 500 Internal Server Error
- Check Apache error logs
- Verify mod_rewrite is enabled
- Check file permissions
- Verify `.env` file exists and is configured

### CSS/JS Not Loading
- Clear browser cache
- Check file paths in browser console
- Verify `public/` directory is accessible
