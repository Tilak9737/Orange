<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Deploy on Render (Free, Fresh Start)

This repo includes `render.yaml` for a fresh Render deployment with Neon PostgreSQL.

### What your latest error means

Your newest log shows connection fallback to `127.0.0.1` and `Database: laravel`.

That means Render did **not** provide valid DB env vars at runtime, so Laravel used defaults (`DB_HOST=127.0.0.1`, `DB_DATABASE=laravel`).

### Updated blueprint behavior

`render.yaml` now hardcodes safe Neon non-secret values:

- `DB_HOST=ep-snowy-butterfly-aive3zr8.us-east-1.aws.neon.tech`
- `DB_PORT=5432`
- `DB_DATABASE=neondb`
- `DB_USERNAME=neondb_owner`

You only need to provide one DB secret in Render: `DB_PASSWORD`.

### Exact steps now

1. In Render service → **Environment**, set:
   - `APP_KEY` (from `php artisan key:generate --show`)
   - `DB_PASSWORD` (your current Neon password)
2. Make sure old `DB_URL` is removed if it exists (to avoid conflicting config).
3. Manual Deploy → **Clear build cache & deploy**.

### If it still fails

- Reset/rotate Neon password, update Render `DB_PASSWORD`, redeploy.
- Confirm no leading/trailing spaces in `DB_PASSWORD`.

### First deploy verification

After deploy succeeds:

- Open your Render URL and confirm the home page loads.
- Check logs for migration + seeding success.
- Login with demo users:
  - Admin: `admin@orange.test` / `password`
  - Customer: `customer@orange.test` / `password`

### Notes

- `php artisan config:clear` runs before migrations so latest env vars are used.
- `DB_SSLMODE=require` is set for Neon TLS.

