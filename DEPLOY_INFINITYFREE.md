# Deploying This Laravel App On InfinityFree

This app is Laravel 12 and requires PHP 8.2 or newer.

## 1. Prepare The Project Locally

Run these commands on your computer before uploading:

```bash
composer install --no-dev --optimize-autoloader
npm install
npm run build
php artisan key:generate --show
```

Copy the key printed by `php artisan key:generate --show`; you will paste it into `APP_KEY` on the server.

## 2. Create The InfinityFree Database

In InfinityFree/VistaPanel:

1. Open **MySQL Databases**.
2. Create a database.
3. Copy the database host, database name, username, and password.
4. Import your tables with phpMyAdmin.

If you cannot run `php artisan migrate` on the server, export the local database from phpMyAdmin and import that SQL file into InfinityFree phpMyAdmin.

## 3. Upload Files

Upload the Laravel project contents into InfinityFree `htdocs`.

Required files and folders include:

- `.htaccess`
- `app`
- `bootstrap`
- `config`
- `database`
- `public`
- `resources`
- `routes`
- `storage`
- `vendor`
- `.env`
- `artisan`
- `composer.json`
- `composer.lock`

Do not upload these unless you need them:

- `.git`
- `node_modules`
- `tests`

## 4. Configure `.env`

On the server, copy `.env.infinityfree.example` to `.env`, then fill in:

```env
APP_KEY=base64:your_generated_key
APP_URL=https://your-real-domain
DB_HOST=your_infinityfree_mysql_host
DB_DATABASE=your_infinityfree_database_name
DB_USERNAME=your_infinityfree_database_user
DB_PASSWORD=your_infinityfree_database_password
```

Use these production-safe values on InfinityFree:

```env
APP_ENV=production
APP_DEBUG=false
SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
```

## 5. Set PHP Version

In InfinityFree control panel, set PHP to 8.2 or newer. Laravel 12 will not run on older PHP versions.

## 6. Check Storage Folders

Make sure these folders exist after upload:

```text
storage/framework/cache/data
storage/framework/sessions
storage/framework/views
bootstrap/cache
```

If `bootstrap/cache` is missing, create it.

## 7. First Test

Visit your domain. If it fails:

1. Temporarily set `APP_DEBUG=true`.
2. Reload the page and copy the exact error.
3. Set `APP_DEBUG=false` again after fixing it.

Common fixes:

- `No application encryption key has been specified`: fill `APP_KEY`.
- `SQLSTATE[HY000] [1045]`: database username/password is wrong.
- `SQLSTATE[HY000] [2002]`: database host is wrong.
- `Class ... not found`: upload the full `vendor` folder after running Composer locally.
- Blank page or 500 error: check PHP version and confirm the root `.htaccess` was uploaded.
