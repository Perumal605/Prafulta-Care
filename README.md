# Prafulta Care

Prafulta Care is a Laravel 13 application for counselling bookings and training programme registrations.

It includes:
- Public home page and training catalogue
- Guest booking flow with simulated/real Razorpay callback support
- Role-based dashboards (`admin`, `training_manager`, `counsellor`, `client`)
- Filament admin panel at `/admin`
- Demo seed data (users, counsellors, bookings, programmes, registrations)

## Tech Stack

- PHP `^8.3`
- Laravel `^13.0`
- Filament `^5.4`
- Node.js + Vite + Tailwind
- SQLite (default) or MySQL (DDEV config uses MySQL 8)

## 1) Fresh Setup (Local, without Docker)

Follow these steps from a clean clone.

### Step 1: Clone and enter project

```bash
git clone <your-repo-url>
cd Prafulta-Care
```

### Step 2: Install PHP dependencies

```bash
composer install
```

### Step 3: Create environment file

```bash
cp .env.example .env
```

### Step 4: Generate app key

```bash
php artisan key:generate
```

### Step 5: Prepare database

Default `.env.example` uses SQLite:
- `DB_CONNECTION=sqlite`
- Database file: `database/database.sqlite`

If file is missing, create it:

```bash
touch database/database.sqlite
```

### Step 6: Run migrations and seed demo data

```bash
php artisan migrate --seed
```

### Step 7: Install frontend dependencies

```bash
npm install
```

### Step 8: Build or run frontend assets

For development:

```bash
npm run dev
```

For production build:

```bash
npm run build
```

### Step 9: Start Laravel app

```bash
php artisan serve
```

Open:
- App: `http://127.0.0.1:8000`
- Admin panel: `http://127.0.0.1:8000/admin`

## 2) One-Command Setup Option

This project includes a Composer setup script:

```bash
composer run setup
```

It runs install + env copy + key generation + migrate + npm install + npm build.

## 3) Run Dev Services Together

You can run app server, queue listener, logs, and Vite in one command:

```bash
composer run dev
```

## 4) Demo Login Credentials (Seeded)

After `php artisan migrate --seed`, these users are available:

- `admin@prafulta.local` / `password`
- `training@prafulta.local` / `password`
- `counsellor@prafulta.local` / `password`
- `client@prafulta.local` / `password`

Notes:
- Filament `/admin` is accessible only for `admin` and `training_manager` roles.
- In this codebase, `/login` redirects guests to `/register`.

## 5) Payments (Razorpay)

The booking flow supports two modes:

- Simulation mode (default): used when `RAZORPAY_KEY_ID` is not set or equals `simulate`.
- Razorpay mode: enabled when valid keys are present in `.env`.

Add in `.env` when using real Razorpay:

```env
RAZORPAY_KEY_ID=your_key_id
RAZORPAY_KEY_SECRET=your_key_secret
```

Current callback implementation accepts simulated and real callbacks and marks payment as paid; production-grade signature verification should be tightened before go-live.

## 6) DDEV Setup (Optional)

This repo already contains a `.ddev` setup (`type: laravel`, MySQL 8, PHP 8.4).

### Step 1: Start DDEV

```bash
ddev start
```

### Step 2: Install dependencies in container

```bash
ddev composer install
ddev npm install
```

### Step 3: Configure environment

```bash
cp .env.example .env
ddev artisan key:generate
```

### Step 4: Set DB for DDEV MySQL in `.env`

Use DDEV DB values:

```env
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=db
DB_USERNAME=db
DB_PASSWORD=db
```

### Step 5: Migrate + seed

```bash
ddev artisan migrate --seed
```

### Step 6: Run frontend and open site

```bash
ddev npm run dev
ddev launch
```

## 7) Useful Commands

```bash
# Run tests
php artisan test

# Alternative test command from composer script
composer test

# Clear and rebuild caches
php artisan optimize:clear

# Reseed database from scratch
php artisan migrate:fresh --seed
```

## 8) Project Structure (Quick View)

- `app/Filament` - Admin resources/panels
- `app/Http/Controllers` - Booking, training, dashboard, auth flows
- `database/migrations` - Core schema (bookings, training, payments, roles)
- `database/seeders/PrafultaDemoSeeder.php` - Demo records + credentials
- `routes/web.php` - Public + role-protected app routes
- `routes/auth.php` - Registration/auth routes

## 9) Troubleshooting

### Node/Vite issues

```bash
rm -rf node_modules package-lock.json
npm install
npm run dev
```

### Vendor/autoload missing

```bash
composer install
```

### DB errors after schema changes

```bash
php artisan migrate:fresh --seed
```

### Permission issues (Linux)

```bash
chmod -R ug+rwx storage bootstrap/cache
```
