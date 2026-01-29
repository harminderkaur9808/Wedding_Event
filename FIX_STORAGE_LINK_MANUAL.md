# Fix Storage Link When exec() is Disabled

## Problem
`php artisan storage:link` fails because `exec()` function is disabled on your server.

## Solution: Create Symlink Manually

Since you're already in the terminal, create the link manually:

### Step 1: Navigate to the public directory
```bash
cd public_html/public
```

### Step 2: Remove any existing storage folder/link (if it exists)
```bash
# Check if it exists first
ls -la public/storage

# If it exists and is NOT a symlink, remove it
rm -rf public/storage

# If it's a broken symlink, remove it
rm public/storage
```

### Step 3: Create the symbolic link manually
```bash
# Make sure you're in the public directory
cd public_html/public

# Create the symlink
ln -s ../storage/app/public storage

# Verify it was created
ls -la storage
```

You should see output like:
```
lrwxrwxrwx 1 u797489514 o1008029186 25 Jan 23 12:30 storage -> ../storage/app/public
```

### Step 4: Verify the link works
```bash
# Test if you can access the user_media folder through the link
ls -la storage/user_media/

# You should see your uploaded image:
# 1769171210_1_6973690a9bb6c.jpg
```

### Step 5: Set proper permissions
```bash
# Set permissions on the symlink (though it inherits from target)
chmod 755 storage

# Ensure the actual storage directory has correct permissions
chmod -R 755 ../storage/app/public
chmod -R 755 ../storage/app/public/user_media
```

### Step 6: Test in browser
Try accessing your image directly:
```
https://palegoldenrod-lemur-907257.hostingersite.com/storage/user_media/1769171210_1_6973690a9bb6c.jpg
```

## Complete Command Sequence

Run these commands in order:

```bash
# 1. Navigate to public directory
cd public_html/public

# 2. Remove existing storage if it exists (not a symlink)
rm -rf storage 2>/dev/null || true

# 3. Create the symlink
ln -s ../storage/app/public storage

# 4. Verify
ls -la storage

# 5. Test access
ls -la storage/user_media/

# 6. Set permissions
chmod 755 storage
chmod -R 755 ../storage/app/public
```

## Alternative: Using Absolute Path

If relative path doesn't work, use absolute path:

```bash
# First, find your full project path
pwd
# This will show something like: /home/u797489514/domains/yourdomain.com/public_html

# Then create symlink with absolute path
ln -s /home/u797489514/domains/yourdomain.com/public_html/storage/app/public /home/u797489514/domains/yourdomain.com/public_html/public/storage
```

## If Using cPanel File Manager

1. **Login to cPanel**
2. **Go to File Manager**
3. **Navigate to `public` folder**
4. **Look for "Create Symbolic Link" option** (usually in right-click menu or toolbar)
5. **Set:**
   - Link Name: `storage`
   - Target: `../storage/app/public`
6. **Click Create**

## Verify It's Working

After creating the link, test:

```bash
# 1. Check symlink exists
ls -la public/storage
# Should show: storage -> ../storage/app/public

# 2. Check you can access files
ls public/storage/user_media/
# Should list your uploaded images

# 3. Test direct URL in browser
# https://your-domain.com/storage/user_media/1769171210_1_6973690a9bb6c.jpg
```

## Troubleshooting

### Issue: "File exists" error
```bash
# Remove the existing file/folder first
rm -rf public/storage
# Then create symlink again
ln -s ../storage/app/public storage
```

### Issue: "Permission denied"
```bash
# Check current directory permissions
ls -ld public

# If needed, set permissions
chmod 755 public
```

### Issue: Symlink created but 404 error
1. Check if symlink points to correct location:
   ```bash
   readlink -f public/storage
   # Should show: /full/path/to/storage/app/public
   ```

2. Check if target directory exists:
   ```bash
   ls -la storage/app/public
   ```

3. Check file permissions:
   ```bash
   ls -la storage/app/public/user_media/
   ```

## Quick One-Liner Fix

If you're in `public_html` directory:
```bash
cd public && rm -rf storage 2>/dev/null; ln -s ../storage/app/public storage && ls -la storage
```

This will:
1. Go to public directory
2. Remove existing storage (if exists)
3. Create new symlink
4. Verify it was created
