# مجمع لوزان التخصصي الطبي

Arabic RTL medical center website built with Laravel, Blade, Tailwind CSS, and Alpine.js.

## Requirements

- PHP 8.2+
- Composer
- Node.js 18+
- MySQL (or SQLite for local development)

## Setup

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm run build
php artisan serve
```

## Admin Access

- URL: `/admin/login`
- Email: `admin@luzan.com`
- Password: `password` (change immediately after first login in production)

> **Security:** The default password is for local development only. Run `php artisan db:seed` only in dev/staging, and update the admin password before deploying to production.

## Doctor Portrait Crop Script

Crops circular portraits from `Doctor_s Pics/` into `public/images/doctors/`:

```bash
pip install -r scripts/requirements.txt
python3 scripts/crop_doctor_portraits.py
```

Output: `doctor1.png` through `doctor15.png`

Enter doctor details manually in Admin → الأطباء. Use photo path like `doctors/doctor1.png`.

## Public Site

Single homepage with sections:
- Hero + booking form
- Services
- Branches + Doctors slider
- Footer

## Tech Stack

- Laravel 13 (laravel/laravel latest)
- Blade templates
- Tailwind CSS v4 + Vite
- Alpine.js
- SQLite/MySQL
