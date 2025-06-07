# Franchise Management

Aplikasi manajemen franchise berbasis Laravel 11, Jetstream, Livewire, dan Tailwind CSS.

## Fitur

- Autentikasi dan otorisasi (Jetstream)
- Manajemen data franchise
- UI modern berbasis Sneat Bootstrap Admin Template
- Livewire untuk komponen interaktif real-time
- Pengelolaan file dan media
- Migrasi dan seeder database
- Dukungan Docker untuk pengembangan lokal

## Instalasi

1. **Clone repository**
   ```sh
   git clone <repository-url>
   cd franchise-management
   ```

2. **Install dependencies**
   ```sh
   composer install
   npm install
   ```

3. **Copy file environment**
   ```sh
   cp .env.example .env
   ```

4. **Generate application key**
   ```sh
   php artisan key:generate
   ```

5. **Migrasi dan seeder database**
   ```sh
   php artisan migrate --seed
   ```

6. **Jalankan server pengembangan**
   ```sh
   php artisan serve
   npm run dev
   ```

7. **(Opsional) Jalankan dengan Docker**
   ```sh
   docker-compose up -d
   ```
