# Fix Images Not Showing After Upload

## Problem
Images are uploaded successfully but not displaying. The URL shows `/storage/user_media/` but images return 404.

## Root Cause
Laravel requires a **symbolic link** from `public/storage` to `storage/app/public` for uploaded files to be accessible via the web.

## Solution: Create Storage Link on Live Server

### Step 1: SSH into Your Live Server
```bash
ssh your-username@your-server
cd /path/to/your/project
```

### Step 2: Create the Storage Link
```bash
php artisan storage:link
```

This command creates a symbolic link: `public/storage` → `storage/app/public`

### Step 3: Verify the Link Was Created
```bash
ls -la public/storage
```

You should see something like:
```
lrwxrwxrwx 1 user user 20 Jan 23 12:00 public/storage -> ../storage/app/public
```

### Step 4: Check File Permissions
```bash
# Ensure storage directory is writable
chmod -R 755 storage
chmod -R 755 storage/app/public
chmod -R 755 storage/app/public/user_media

# Ensure public/storage is accessible
chmod -R 755 public/storage
```

### Step 5: Verify Files Are in Correct Location
```bash
# Check if uploaded files exist
ls -la storage/app/public/user_media/

# You should see your uploaded images here
```

### Step 6: Test Direct Access
Try accessing an image directly:
```
https://palegoldenrod-lemur-907257.hostingersite.com/storage/user_media/1769171210_1_6973690a9bb6c.jpg
```

If this works, the link is correct!

## Alternative: Manual Symlink Creation

If `php artisan storage:link` doesn't work, create the link manually:

```bash
# Remove existing link if it exists (broken or incorrect)
rm public/storage

# Create new symbolic link
ln -s ../storage/app/public public/storage

# Verify
ls -la public/storage
```

## If Using cPanel/File Manager

1. **Login to cPanel**
2. **Go to File Manager**
3. **Navigate to `public` folder**
4. **Delete** any existing `storage` folder (if it's not a symlink)
5. **Create Symbolic Link:**
   - In File Manager, look for "Symbolic Link" option
   - Or use Terminal in cPanel:
     ```bash
     cd public_html/public
     ln -s ../storage/app/public storage
     ```

## Verify Storage Configuration

Check `config/filesystems.php` - the `public` disk should be:

```php
'public' => [
    'driver' => 'local',
    'root' => storage_path('app/public'),
    'url' => env('APP_URL').'/storage',
    'visibility' => 'public',
],
```

## Common Issues

### Issue 1: "The link already exists"
**Fix:**
```bash
# Remove existing link
rm public/storage

# Create new link
php artisan storage:link
```

### Issue 2: "Permission denied"
**Fix:**
```bash
# Give proper permissions
chmod -R 755 storage
chmod -R 755 public
chown -R www-data:www-data storage
chown -R www-data:www-data public
```

### Issue 3: Files uploaded but 404 error
**Check:**
1. Is the symlink created? (`ls -la public/storage`)
2. Do files exist in `storage/app/public/user_media/`?
3. Are file permissions correct? (755 for directories, 644 for files)
4. Is `.htaccess` in `public/storage` allowing access?

### Issue 4: Symlink not working on Windows Server
**Fix:** Use absolute path:
```bash
# On Windows, use absolute path
mklink /D "C:\path\to\project\public\storage" "C:\path\to\project\storage\app\public"
```

## Quick Test Commands

```bash
# 1. Check if symlink exists
ls -la public/ | grep storage

# 2. Check if files are uploaded
ls -la storage/app/public/user_media/

# 3. Test symlink
cd public/storage && pwd
# Should show: /path/to/project/storage/app/public

# 4. Check permissions
stat storage/app/public/user_media
stat public/storage
```

## After Fixing

1. **Clear Laravel cache:**
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan view:clear
   ```

2. **Test in browser:**
   - Upload a new image
   - Check if it displays
   - Try direct URL access

3. **Check browser console:**
   - Open F12 → Network tab
   - Reload page
   - Check if image requests return 200 (success) or 404 (still broken)

## Still Not Working?

1. **Check .htaccess in public/storage:**
   Create `public/storage/.htaccess`:
   ```apache
   Options -Indexes
   ```

2. **Check web server configuration:**
   - Ensure FollowSymLinks is enabled in Apache
   - Check nginx configuration if using nginx

3. **Verify APP_URL in .env:**
   ```env
   APP_URL=https://palegoldenrod-lemur-907257.hostingersite.com
   ```
   (No trailing slash!)

4. **Check file ownership:**
   ```bash
   # Files should be owned by web server user
   ls -la storage/app/public/user_media/
   ```
