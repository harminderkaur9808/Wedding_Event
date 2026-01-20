# Fix Database Error - SQLite Database File Missing

## The Problem
Your Laravel app is configured to use SQLite, but the database file doesn't exist on the server.

## Solution 1: Switch to MySQL (Recommended for Production)

### Step 1: Create MySQL Database in cPanel
1. Log into cPanel
2. Go to "MySQL Databases"
3. Create a new database (e.g., `wedding_event`)
4. Create a database user and password
5. Add the user to the database with ALL PRIVILEGES

### Step 2: Update .env File
Edit your `.env` file on the server and change:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

Replace:
- `your_database_name` with the database name you created
- `your_database_user` with the database username
- `your_database_password` with the database password

### Step 3: Run Migrations
Via SSH or cPanel Terminal:
```bash
php artisan migrate
```

## Solution 2: Create SQLite Database File (Quick Fix)

### Step 1: Create Database File
Via cPanel File Manager or SSH:
1. Navigate to `/database/` folder (in root, NOT in public_html)
2. Create a new file named `database.sqlite`
3. Set permissions to 644 (readable/writable)

### Step 2: Verify .env Configuration
Make sure your `.env` has:
```env
DB_CONNECTION=sqlite
# Remove or comment out DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD
```

### Step 3: Run Migrations
```bash
php artisan migrate
```

## Solution 3: Disable Database (If Not Using Database)

If your wedding site doesn't need a database, you can disable sessions:

### Step 1: Change Session Driver
In `.env`:
```env
SESSION_DRIVER=array
```

### Step 2: Clear Config Cache
```bash
php artisan config:clear
```

## Quick Fix Steps (Choose One)

### Option A: Use MySQL (Best for Production)
1. Create MySQL database in cPanel
2. Update `.env` with MySQL credentials
3. Run `php artisan migrate`
4. Clear cache: `php artisan config:clear`

### Option B: Create SQLite File
1. Create `database/database.sqlite` file
2. Set permissions to 644
3. Run `php artisan migrate`
4. Clear cache: `php artisan config:clear`

### Option C: Disable Database
1. Set `SESSION_DRIVER=array` in `.env`
2. Clear cache: `php artisan config:clear`

## Important Notes

- **Database location**: Should be in `/database/` folder in project root, NOT in `public_html/database/`
- **Permissions**: Database file needs to be writable (644 or 666)
- **For production**: MySQL is recommended over SQLite
- **After changes**: Always run `php artisan config:clear`
