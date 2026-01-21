# Quick Start Guide - Wedding Event Project

## 🚀 Fast Deployment (5 Minutes)

### Step 1: Upload Files
Upload all project files to your server via FTP/cPanel File Manager.

### Step 2: Configure .env
Edit `.env` file on server:

```env
APP_NAME="Wedding Event"
APP_ENV=production
APP_KEY=base64:your-key-here
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password

SESSION_DRIVER=database
```

### Step 3: Set Permissions
```bash
chmod -R 755 storage bootstrap/cache
chmod 644 .env
```

### Step 4: Run Commands
```bash
php artisan key:generate
php artisan migrate
php artisan config:clear
php artisan cache:clear
```

### Step 5: Test
Visit: `https://your-domain.com`

---

## ⚡ Quick Fixes

### 500 Error?
1. Change `DB_CONNECTION=sqlite` → `DB_CONNECTION=mysql`
2. Run: `php artisan config:clear`

### Images Not Loading?
- Check `public/Images/` folder exists
- Verify file permissions (644)

### Database Error?
- Verify MySQL credentials in `.env`
- Run: `php artisan migrate`

---

## 📁 Important Files

- `.env` - Configuration
- `.htaccess` - URL rewriting
- `public/index.php` - Entry point
- `routes/web.php` - Routes

---

## 🎯 Key Features

1. **Hero Section** - Carousel with couple images
2. **Our Story** - Couple information with frames
3. **Countdown** - Dynamic timer to wedding date

---

For detailed documentation, see: `DEPLOYMENT_GUIDE.md`
