

# Crypto-X — Crypto Exchange Dashboard

A crypto exchange dashboard built with **Laravel 12**, **Bootstrap 5**, and **Blade components** — featuring wallet balances, live market overview, buy/sell orders, deposits & withdrawals, a quick-swap tool, transaction history, and a full admin panel for managing the platform.

## Features

### User side
- **Dashboard** — USDT / TRX / PKR wallet balance cards, key stats (portfolio value, profit, trades, security score), live market overview, recent transactions, quick swap, and portfolio breakdown chart
- **Buy / Sell Crypto** — place buy and sell orders
- **Deposit / Withdraw** — fund and withdraw from wallets
- **Wallet** — view balances across all currencies with quick deposit/withdraw actions
- **Transaction History** — full log of all account activity
- **Quick Swap** — instantly exchange between supported currencies
- **Authentication** — register, login, email verification, password reset, profile management (via Laravel's built-in auth scaffolding)

### Admin side
- Admin dashboard with platform-wide overview
- Manage buy orders, sell orders, deposits, and withdrawals
- Manage exchange rates
- Role-based access via `AdminMiddleware`

## Tech Stack

- **Backend:** Laravel 12 (PHP)
- **Frontend:** Blade templates, Bootstrap 5, custom CSS (`public/assets/css/dashboard.css`)
- **Icons:** Tabler Icons
- **Build tooling:** Vite
- **Database:** MySQL (via Laravel migrations & seeders)

## Project Structure

```
app/
  Http/Controllers/          # Buy, Sell, Deposit, Withdrawal, Wallet, Swap, Transaction, Dashboard controllers
  Http/Controllers/Admin/    # Admin-side controllers
  Http/Middleware/           # AdminMiddleware for role-based access
  Models/                    # User, Wallet, Transaction, Deposit, Withdrawal, BuyOrder, SellOrder, ExchangeRate...

resources/views/
  layouts/app.blade.php      # Main dashboard layout
  partials/sidebar.blade.php # Sidebar navigation
  partials/topbar.blade.php  # Topbar navigation
  components/                # balance-cards, stats-row, market-overview, transactions-table, swap-portfolio, wallet-history
  admin/                     # Admin panel views

public/assets/
  css/dashboard.css          # Custom dashboard styling (responsive, desktop + mobile)
  js/dashboard.js            # Dashboard interactivity (sidebar toggle, swap calculator, etc.)

database/
  migrations/                # wallets, transactions, deposits, withdrawals, buy/sell orders, exchange rates
  seeders/                   # WalletSeeder, TransactionSeeder
```

## Installation

### Prerequisites
- PHP >= 8.2
- Composer
- Node.js & npm
- MySQL (or your preferred Laravel-supported database)

### Setup

```bash
# 1. Clone the repository
git clone https://github.com/Qanu91/crypto-X.git
cd crypto-X

# 2. Install PHP dependencies
composer install

# 3. Install JS dependencies
npm install

# 4. Copy the environment file and configure it
cp .env.example .env

# 5. Generate the application key
php artisan key:generate

# 6. Configure your database credentials in .env
#    DB_DATABASE=crypto_exchange
#    DB_USERNAME=root
#    DB_PASSWORD=

# 7. Run migrations and seed sample data
php artisan migrate --seed

# 8. Build frontend assets
npm run dev
# or for production
npm run build

# 9. Serve the application
php artisan serve
```

The app will be available at `http://localhost:8000`.

## Environment Variables

Key variables to set in your `.env` file (see `.env.example` for the full list):

| Variable | Description |
|---|---|
| `APP_URL` | Base URL of the application |
| `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` | Database credentials |
| `MAIL_*` | Mail settings, used for email verification and password reset |

⚠️ **Never commit your real `.env` file.** It's excluded via `.gitignore` — only `.env.example` (with placeholder values) is tracked in this repo.

## Admin Access

After seeding, promote a user to admin by setting their `role` column to `admin` in the `users` table, then log in and visit the admin routes to manage deposits, withdrawals, orders, and exchange rates.

## Responsive Design

The dashboard is fully responsive — desktop layout is preserved as designed, with dedicated mobile breakpoints (`991px` and `576px`) for cards, tables, buttons, and charts to ensure no horizontal overflow and a clean experience on phones and tablets.



## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
