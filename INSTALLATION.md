# Laragon (Windows) — Quick install & setup (PowerShell)

This guide contains the Laragon-specific steps for getting this Laravel project running on Windows using PowerShell.

Follow these steps from your project root (adjust paths if needed):

1) Start Laragon services
- Open Laragon and click "Start All" to run Apache/Nginx and MySQL.

2) Open Laragon's terminal (recommended)
- In the Laragon application click the Terminal button or use the Menu -> Terminal option to open the integrated terminal. This opens a terminal already configured for Laragon and helps access the bundled MySQL client and PHP executables without changing system PATH.

Note: the terminal opens at Laragon's root. Use the same shell window for all commands below.

2) Prepare environment
```powershell
cd 'C:\Users\cedri\JCV\School\Applications\laragon\www\SAD'
copy .env.example .env -ErrorAction SilentlyContinue
notepad .env
```
Update `.env` with Laragon-friendly DB values (example):
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nexstock_db
DB_USERNAME=root
DB_PASSWORD=
SESSION_DRIVER=database
```

3) Create the database (using Laragon terminal)

If you don't already have the database listed in `.env` create it using Laragon's built-in MySQL client. Laragon defaults to `root` with an empty password unless you've changed it.

From Laragon's Terminal (replace nexstock_db with the DB name in your `.env`):

```powershell
cd 'C:\Users\cedri\JCV\School\Applications\laragon\www\SAD'
# You can run the MySQL client shipped with Laragon like this:
mysql -u root -e "CREATE DATABASE IF NOT EXISTS nexstock_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

If your MySQL root user has a password, append -p and enter it when prompted:

```powershell
mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS nexstock_db ...;"
```

Alternatively you can create the database with a GUI: Laragon -> Menu -> MySQL -> phpMyAdmin or HeidiSQL.
Or use Laragon -> Menu -> MySQL -> phpMyAdmin / HeidiSQL.

4) Run migrations (creates `sessions` table and others)
```powershell
php artisan migrate:status
php artisan migrate
```
If you don't have a session migration present for any reason, generate it and run:
```powershell
php artisan session:table
php artisan migrate
```

5) Clear caches & ensure storage
```powershell
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan optimize:clear

mkdir .\storage\framework\sessions -ErrorAction SilentlyContinue
mkdir .\bootstrap\cache -ErrorAction SilentlyContinue
```

6) Validate & run

- Visit the app in your browser (e.g. http://sad.test or as configured in Laragon) — the SQL error referencing `sessions` should be resolved after successful migration.

- Confirm the `sessions` table exists using the Laragon terminal or a GUI:

Laragon terminal / MySQL CLI:
```powershell
mysql -u root -e "USE nexstock_db; SHOW TABLES LIKE 'sessions';"
```

In phpMyAdmin/HeidiSQL (Laragon Menu -> MySQL -> phpMyAdmin / HeidiSQL) look for `sessions` under your database.

Quick local alternative (no DB sessions):
- Edit `.env` and set `SESSION_DRIVER=file`, then run `php artisan config:clear` and ensure `storage/framework/sessions` exists. This avoids needing the sessions table during development.

Troubleshooting quick checklist (Laragon Terminal)
- If you see "Access denied" when connecting to MySQL, check whether the user/password in `.env` matches a real MySQL user and port (default port 3306). Connect with `mysql -u your_user -p` to verify credentials.
- If migrations say they're already run but tables are missing, confirm you're using the correct database name in `.env` and that `php artisan migrate:status` shows which migrations ran.
- If `php` or `mysql` commands aren't found in Laragon Terminal, open Laragon's main window and ensure you've started services and used the Laragon terminal button/menu (it auto-configures PATH). If you're in Windows PowerShell outside Laragon, prepend the PHP path or run commands from Laragon's terminal instead.

If you'd like, I can add troubleshooting notes for common Laragon/MySQL issues or run the migration steps with you interactively.

