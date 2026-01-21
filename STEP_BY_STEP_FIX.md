# Step-by-Step Fix for 500 Server Error

## Problem
Your `.env` file has `DB_CONNECTION=sqlite` but you have MySQL database credentials.

## Solution: Change to MySQL

### Step 1: Access Your Server Files
1. Log into cPanel
2. Go to **File Manager**
3. Navigate to your website root (usually `public_html` or the folder where your Laravel files are)

### Step 2: Edit .env File
1. Find the `.env` file in the root directory
2. Right-click → **Edit** (or use Code Editor)
3. Find this line:
   ```
   DB_CONNECTION=sqlite
   ```
4. Change it to:
   ```
   DB_CONNECTION=mysql
   ```
5. **Save** the file

### Step 3: Verify MySQL Settings
Make sure these lines in `.env` are correct (they should already be):
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=u797489514_weddingevent
DB_USERNAME=u797489514_weddingevent
DB_PASSWORD=7b4t&EiVV~
```

### Step 4: Run Commands via SSH or Terminal
**Option A: Using cPanel Terminal**
1. Go to cPanel → **Terminal** (or **SSH Access**)
2. Navigate to your project:
   ```bash
   cd ~/public_html
   # or wherever your Laravel project is
   ```
3. Run these commands:
   ```bash
   php artisan migrate
   php artisan config:clear
   php artisan cache:clear
   php artisan view:clear
   ```

**Option B: Using SSH (if you have SSH access)**
```bash
cd /home/u797489514/domains/palegoldenrod-lemur-907257.hostingersite.com/public_html
php artisan migrate
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### Step 5: Set Permissions (if needed)
If you still get errors, set correct permissions:
```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
chmod 644 .env
```

### Step 6: Test Your Website
Refresh your browser: `https://palegoldenrod-lemur-907257.hostingersite.com`

## If You Don't Have SSH/Terminal Access

### Alternative: Use File Manager to Create Database Tables
If you can't run `php artisan migrate`, you can manually create the sessions table:

1. Go to cPanel → **phpMyAdmin**
2. Select your database: `u797489514_weddingevent`
3. Go to **SQL** tab
4. Run this SQL:
```sql
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

5. Then still change `.env` to `DB_CONNECTION=mysql`
6. Clear config cache if possible

## Quick Checklist

- [ ] Changed `DB_CONNECTION=sqlite` to `DB_CONNECTION=mysql` in `.env`
- [ ] Verified MySQL credentials are correct
- [ ] Ran `php artisan migrate` (or created sessions table manually)
- [ ] Ran `php artisan config:clear`
- [ ] Ran `php artisan cache:clear`
- [ ] Set correct file permissions
- [ ] Refreshed website

## Still Not Working?

1. **Check Error Logs:**
   - cPanel → Metrics → Errors
   - Look for specific error messages

2. **Enable Debug Mode Temporarily:**
   In `.env` change:
   ```
   APP_DEBUG=true
   ```
   (Change back to `false` after fixing)

3. **Verify Database Connection:**
   - Check if database `u797489514_weddingevent` exists in phpMyAdmin
   - Verify username and password are correct
