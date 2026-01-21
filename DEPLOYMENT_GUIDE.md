# Wedding Event Project - Complete Deployment Guide

## 📋 Table of Contents
1. [Project Overview](#project-overview)
2. [Project Structure](#project-structure)
3. [Features Implemented](#features-implemented)
4. [Server Configuration](#server-configuration)
5. [Database Setup](#database-setup)
6. [Deployment Steps](#deployment-steps)
7. [Troubleshooting](#troubleshooting)
8. [File Checklist](#file-checklist)

---

## 🎯 Project Overview

**Project Name:** Wedding Event Website  
**Framework:** Laravel 12.47.0  
**PHP Version:** 8.1+  
**Database:** MySQL (for production) / SQLite (for development)

This is a wedding event website featuring:
- Hero section with carousel
- "Our Story" section with couple information
- Countdown timer section
- Responsive design for all devices

---

## 📁 Project Structure

```
Wedding_Event/
├── app/                    # Laravel application core
├── bootstrap/              # Bootstrap files
├── config/                 # Configuration files
├── database/               # Database migrations
├── public/                 # Public assets (web root)
│   ├── css/               # Stylesheets
│   │   ├── hero-section.css
│   │   ├── our-story-section.css
│   │   ├── third-section.css
│   │   ├── style.css
│   │   └── footer.css
│   ├── js/                # JavaScript files
│   │   ├── countdown.js
│   │   ├── header.js
│   │   └── our-story-animation.js
│   ├── Images/            # Image assets
│   │   ├── Header/
│   │   ├── Home/
│   │   │   ├── SecSection/
│   │   │   └── thirdsec/
│   │   └── footer/
│   └── Fonts/             # Custom fonts
├── resources/
│   └── views/             # Blade templates
│       ├── Homepages/
│       │   └── partials/
│       │       ├── hero-section.blade.php
│       │       ├── our-story-section.blade.php
│       │       └── third-section.blade.php
│       ├── layouts/
│       │   └── app.blade.php
│       └── welcome.blade.php
├── routes/
│   └── web.php            # Web routes
├── .htaccess              # Apache configuration (root)
├── index.php              # Entry point (root)
└── .env                   # Environment configuration
```

---

## ✨ Features Implemented

### 1. Hero Section (`hero-section.blade.php`)
- **Location:** `resources/views/Homepages/partials/hero-section.blade.php`
- **CSS:** `public/css/hero-section.css`
- **Features:**
  - Image carousel with multiple slides
  - Heart overlay with couple names and wedding date
  - Sparkle animations
  - Responsive design
  - Mobile height: 32vh

### 2. Our Story Section (`our-story-section.blade.php`)
- **Location:** `resources/views/Homepages/partials/our-story-section.blade.php`
- **CSS:** `public/css/our-story-section.css`
- **JS:** `public/js/our-story-animation.js`
- **Features:**
  - Couple information (Vickram & Nisha)
  - Decorative frames on left and right (visible on screens < 1300px)
  - Text bubbles with descriptions
  - Timeline animation
  - Couple images with scroll animation
  - Responsive layout

### 3. Countdown Timer Section (`third-section.blade.php`)
- **Location:** `resources/views/Homepages/partials/third-section.blade.php`
- **CSS:** `public/css/third-section.css`
- **JS:** `public/js/countdown.js`
- **Features:**
  - Dynamic countdown timer (Days, Hours, Minutes)
  - Automatically detects user's timezone
  - Wedding date: December 31, 2026
  - Background image with decorative elements
  - Section height: 50vh
  - White countdown boxes with colored bottom border (#054C82)

### 4. Header Navigation
- **Location:** `resources/views/partials/header.blade.php`
- **CSS:** `public/css/style.css`
- **Features:**
  - Animated underline on hover (centered, expands from center)
  - Login button
  - Responsive mobile menu
  - Wedding date display

---

## ⚙️ Server Configuration

### Files Created for Server Deployment

#### 1. Root `.htaccess` File
**Location:** `/Wedding_Event/.htaccess`

**Purpose:** Routes all requests to Laravel's public directory when document root is set to project root.

**Content:**
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    
    # Redirect to public directory
    RewriteCond %{REQUEST_URI} !^/public/
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

#### 2. Root `index.php` File
**Location:** `/Wedding_Event/index.php`

**Purpose:** Entry point that routes requests to Laravel's public/index.php when document root is project root.

#### 3. Public `.htaccess` File
**Location:** `/Wedding_Event/public/.htaccess`

**Purpose:** Laravel's standard URL rewriting for clean URLs.

---

## 🗄️ Database Setup

### Configuration Options

#### Option 1: MySQL (Recommended for Production)

**In `.env` file:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_STORE=database
```

**Steps:**
1. Create MySQL database in cPanel
2. Create database user
3. Add user to database with ALL PRIVILEGES
4. Update `.env` with credentials
5. Run: `php artisan migrate`

#### Option 2: SQLite (Development Only)

**In `.env` file:**
```env
DB_CONNECTION=sqlite
# Remove DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD

SESSION_DRIVER=file
```

**Steps:**
1. Create `database/database.sqlite` file
2. Set permissions: `chmod 644 database/database.sqlite`
3. Run: `php artisan migrate`

#### Option 3: File Sessions (No Database)

**In `.env` file:**
```env
SESSION_DRIVER=file
# No database needed
```

**Steps:**
1. Just change `SESSION_DRIVER=file`
2. Run: `php artisan config:clear`

---

## 🚀 Deployment Steps

### Pre-Deployment Checklist

- [ ] All files uploaded to server
- [ ] PHP version 8.1+ installed
- [ ] MySQL database created (if using MySQL)
- [ ] mod_rewrite enabled in Apache
- [ ] File permissions set correctly

### Step 1: Upload Files to Server

1. **Via FTP/SFTP:**
   - Upload entire project folder to server
   - Maintain folder structure

2. **Via cPanel File Manager:**
   - Upload project files
   - Extract if uploaded as ZIP

### Step 2: Set Document Root

**Option A: Document Root = Project Root (Current Setup)**
- Keep root `.htaccess` and `index.php`
- Access site: `http://your-domain.com`

**Option B: Document Root = Public Folder (Recommended)**
- Point document root to `public/` folder
- Remove root `.htaccess` and `index.php`
- Access site: `http://your-domain.com`

### Step 3: Configure Environment

1. **Copy `.env.example` to `.env`:**
   ```bash
   cp .env.example .env
   ```

2. **Edit `.env` file:**
   ```env
   APP_NAME="Wedding Event"
   APP_ENV=production
   APP_KEY=base64:your-generated-key
   APP_DEBUG=false
   APP_URL=https://your-domain.com
   
   # Database Configuration
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_user
   DB_PASSWORD=your_database_password
   
   # Session Configuration
   SESSION_DRIVER=database
   SESSION_LIFETIME=120
   ```

3. **Generate Application Key:**
   ```bash
   php artisan key:generate
   ```

### Step 4: Set File Permissions

**Via SSH:**
```bash
cd /path/to/your/project

# Set directory permissions
chmod -R 755 storage
chmod -R 755 bootstrap/cache

# Set file permissions
chmod 644 .env
```

**Via cPanel File Manager:**
- Right-click `storage/` → Change Permissions → 755
- Right-click `bootstrap/cache/` → Change Permissions → 755
- Right-click `.env` → Change Permissions → 644

### Step 5: Database Setup

**If using MySQL:**

1. **Create Database:**
   - cPanel → MySQL Databases
   - Create database: `wedding_event`
   - Create user and password
   - Add user to database

2. **Run Migrations:**
   ```bash
   php artisan migrate
   ```

**If using SQLite:**

1. **Create Database File:**
   - Create `database/database.sqlite`
   - Set permissions: 644

2. **Run Migrations:**
   ```bash
   php artisan migrate
   ```

**If not using database:**

1. **Change Session Driver:**
   ```env
   SESSION_DRIVER=file
   ```

2. **Clear Config:**
   ```bash
   php artisan config:clear
   ```

### Step 6: Clear All Caches

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

### Step 7: Test Website

1. **Visit your domain:**
   ```
   https://your-domain.com
   ```

2. **Check:**
   - [ ] Homepage loads
   - [ ] Images display correctly
   - [ ] CSS styles applied
   - [ ] JavaScript works (countdown timer)
   - [ ] Navigation links work
   - [ ] No errors in browser console

---

## 🔧 Troubleshooting

### Common Issues and Solutions

#### 1. 500 Server Error

**Cause:** Configuration or permission issues

**Solutions:**
- Check error logs: cPanel → Metrics → Errors
- Verify `.env` file exists and is configured
- Check file permissions (storage, bootstrap/cache)
- Verify PHP version (8.1+)
- Check if mod_rewrite is enabled

#### 2. Database Connection Error

**Error:** `Database file does not exist` or `Access denied`

**Solutions:**
- Verify database credentials in `.env`
- Check if database exists in phpMyAdmin
- Ensure `DB_CONNECTION=mysql` (not `sqlite`)
- Test database connection in phpMyAdmin
- Run: `php artisan config:clear`

#### 3. Images Not Loading

**Cause:** Incorrect paths or permissions

**Solutions:**
- Verify images exist in `public/Images/`
- Check file permissions (644 for files)
- Clear browser cache
- Verify `asset()` helper is used in Blade templates
- Check `.htaccess` is working

#### 4. CSS/JS Not Loading

**Cause:** Incorrect paths or cache

**Solutions:**
- Clear browser cache
- Check file paths in browser console
- Verify files exist in `public/css/` and `public/js/`
- Check `.htaccess` allows static files
- Run: `php artisan view:clear`

#### 5. Countdown Timer Not Working

**Cause:** JavaScript error or date configuration

**Solutions:**
- Check browser console for errors
- Verify `countdown.js` is loaded
- Check wedding date in `public/js/countdown.js` (line 12)
- Ensure JavaScript is enabled

#### 6. Frames Not Visible (Our Story Section)

**Cause:** CSS display settings

**Solutions:**
- Check screen width (frames show on < 1300px)
- Verify `our-story-section.css` is loaded
- Check if frames are outside container in HTML
- Clear browser cache

---

## 📝 File Checklist

### Required Files for Deployment

#### Configuration Files
- [ ] `.env` (configured with production settings)
- [ ] `.htaccess` (root - if document root is project root)
- [ ] `public/.htaccess` (Laravel URL rewriting)
- [ ] `index.php` (root - if document root is project root)
- [ ] `public/index.php` (Laravel entry point)

#### Application Files
- [ ] All files in `app/` directory
- [ ] All files in `bootstrap/` directory
- [ ] All files in `config/` directory
- [ ] All files in `routes/` directory
- [ ] All files in `resources/` directory
- [ ] `composer.json` and `composer.lock`
- [ ] `vendor/` directory (or run `composer install`)

#### Public Assets
- [ ] All CSS files in `public/css/`
- [ ] All JS files in `public/js/`
- [ ] All images in `public/Images/`
- [ ] All fonts in `public/Fonts/`

#### Storage
- [ ] `storage/` directory (with correct permissions)
- [ ] `storage/logs/` directory
- [ ] `bootstrap/cache/` directory (with correct permissions)

---

## 🎨 Customization Guide

### Change Wedding Date

**Countdown Timer:**
Edit `public/js/countdown.js`:
```javascript
const weddingDate = new Date('2026-12-31T12:00:00');
```

### Change Colors

**Countdown Box Border:**
Edit `public/css/third-section.css`:
```css
border-bottom: 3px solid #054C82; /* Change this color */
```

### Adjust Section Heights

**Hero Section (Mobile):**
Edit `public/css/hero-section.css`:
```css
@media (max-width: 575.98px) {
    .wedding-mele-slide-image {
        height: 32vh; /* Change this */
    }
}
```

**Third Section:**
Edit `public/css/third-section.css`:
```css
.wedding-mele-third-section {
    height: 50vh; /* Change this */
}
```

### Modify Frame Visibility

**Our Story Frames:**
Edit `public/css/our-story-section.css`:
```css
@media (max-width: 1300px) {
    .wedding-mele-left-frame,
    .wedding-mele-right-frame {
        display: flex; /* Show frames */
    }
}
```

---

## 📞 Support

### Useful Commands

```bash
# Clear all caches
php artisan optimize:clear

# Generate application key
php artisan key:generate

# Run migrations
php artisan migrate

# Check Laravel version
php artisan --version

# List all routes
php artisan route:list
```

### Important URLs

- **Laravel Documentation:** https://laravel.com/docs
- **Hostinger Support:** https://www.hostinger.com/contact

---

## ✅ Final Checklist Before Going Live

- [ ] `.env` configured with production settings
- [ ] `APP_DEBUG=false` in `.env`
- [ ] `APP_URL` set to your domain
- [ ] Database configured and migrations run
- [ ] File permissions set correctly
- [ ] All caches cleared
- [ ] Images uploaded and accessible
- [ ] CSS and JS files loading
- [ ] Countdown timer working
- [ ] Navigation links working
- [ ] Mobile responsive design tested
- [ ] Error logs checked (no errors)
- [ ] Website tested on different browsers
- [ ] SSL certificate installed (HTTPS)

---

## 📄 Version History

- **v1.0** - Initial deployment
  - Hero section with carousel
  - Our Story section with frames
  - Countdown timer section
  - Responsive design
  - Server configuration files

---

**Last Updated:** 2024  
**Maintained By:** Development Team
