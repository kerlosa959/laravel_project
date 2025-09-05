<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Aldar Live ERP SaaS Laravel Application

Aldar Live is a modular ERP SaaS application built with Laravel, designed to provide scalable business management solutions for modern organizations.

---

## Features

- Modular architecture for easy extension and maintenance
- Multi-tenant SaaS support
- User authentication and authorization
- Expense, labor, and resource management
- RESTful API structure
- Integration with third-party services
- Responsive UI with modern frontend tools
- Automated testing with PHPUnit

---

## Requirements

- PHP >= 8.1
- Composer
- MySQL or compatible database
- Node.js & npm (for frontend assets)

---

## Installation

1. **Clone the repository**
   ```sh
   git clone <your-repo-url>
   cd aldar_live
   ```

2. **Install PHP dependencies**
   ```sh
   composer install
   ```

3. **Install Node dependencies**
   ```sh
   npm install
   ```

4. **Copy and configure environment**
   ```sh
   cp .env.example .env
   php artisan key:generate
   ```
   Update `.env` with your database and mail credentials.

5. **Run migrations and seeders**
   ```sh
   php artisan migrate --seed
   ```

6. **Build frontend assets**
   ```sh
   npm run dev
   ```

7. **Start the development server**
   ```sh
   php artisan serve
   ```

---

## Usage

- Access the application at [http://localhost:8000](http://localhost:8000) after running the server.
- Register or log in using the authentication system.
- Explore modules for managing expenses, labor, resources, and more.

---

## Useful Artisan Commands

- Clear cache: `php artisan cache:clear`
- Optimize: `php artisan optimize`
- Route cache: `php artisan route:cache`
- View clear: `php artisan view:clear`
- Storage link: `php artisan storage:link`

---

## Testing

Run the test suite with:

```sh
php artisan test
```

or

```sh
vendor/bin/phpunit
```

---

## Contributing

Contributions are welcome! Please fork the repository and submit a pull request.

---

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).