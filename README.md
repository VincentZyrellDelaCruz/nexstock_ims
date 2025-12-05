# NexStack - Inventory Management System

A comprehensive inventory management system built with Laravel, PHP, HTML, CSS, and Bootstrap.

## Features

- **Dashboard**: Overview with KPIs, top selling products, and recent orders
- **Inventory Management**: Track and manage inventory items
- **Product Management**: Add, edit, and delete products
- **Category Management**: Organize products by categories
- **Supplier Management**: Manage supplier information
- **Transaction Management**: Track incoming and outgoing transactions
- **Reports**: Generate sales, inventory, and supplier reports
- **Admin Settings**: User management and system administration
- **Authentication**: User login and registration system

## Technology Stack

- Laravel 10
- PHP 8.0+
- HTML5
- CSS3 (Custom styling with Bootstrap 5)
- Bootstrap 5.3
- MySQL Database

## Installation

1. Clone the repository
2. Install dependencies: (Optional if no composer yet)
   ```bash
   composer install 
   ```

3. Copy the environment file: (Important)
   ```bash
   cp .env.example .env
   ```

4. Generate application key: (Important)
   ```bash
   php artisan key:generate
   ```

5. Configure your database in `.env` file: (Optional)
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nexstock_db
   DB_USERNAME=root
   DB_PASSWORD=your_password
   ```

6. PDF Library Installation(Optional For now if not needed yet)
   Install DomPDF package:
   ```bash
   composer require barryvdh/laravel-dompdf
   ```

7. Storage Configuration (Important)
   Ensure storage link is created:
   ```bash
   php artisan storage:link
   ```

8. Run migrations: (Important)
   ```bash
   php artisan migrate
   ```

9. Start the development server:
   ```bash
   php artisan serve
   ```

10. Open your browser and navigate to `http://localhost:8000`

## Project Structure

- `app/Http/Controllers/` - All controllers
- `app/Models/` - Eloquent models
- `database/migrations/` - Database migrations
- `resources/views/` - Blade templates
- `public/css/` - Custom CSS files
- `routes/web.php` - Web routes

## Color Scheme

- Dark Green (#1a4d2e) - Primary background
- Light Green (#90EE90) - Accents and highlights
- Medium Green (#2d7a3f) - Secondary elements
- White (#ffffff) - Text and cards

## Default User

After running migrations, you can create a user through the registration page or create one manually in the database.

## License

MIT License

## Support

For support, please contact the development team.

