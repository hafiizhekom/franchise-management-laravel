# Franchise Management

A franchise management application built with Laravel 11, Jetstream, Livewire, and Tailwind CSS.

## Features

- Authentication and authorization (Jetstream)
- Franchise data management
- Modern UI based on Sneat Bootstrap Admin Template
- Livewire for real-time interactive components
- File and media management
- Database migration and seeder
- Docker support for local development

## Installation

1. **Clone the repository**
   ```sh
   git clone <repository-url>
   cd franchise-management
   ```

2. **Install dependencies**
   ```sh
   composer install
   npm install
   ```

3. **Copy environment file**
   ```sh
   cp .env.example .env
   ```

4. **Generate application key**
   ```sh
   php artisan key:generate
   ```

5. **Run database migration and seeder**
   ```sh
   php artisan migrate --seed
   ```

6. **Start development server**
   ```sh
   php artisan serve
   npm run dev
   ```

7. **(Optional) Run with Docker**
   ```sh
   docker-compose up -d
   ```
