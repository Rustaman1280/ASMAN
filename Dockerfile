FROM php:8.3-cli

# Install dependencies, including Node.js for Vite
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev libzip-dev unzip nodejs \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

# Install PHP dependencies, Node modules, and build assets
RUN composer install --optimize-autoloader --no-scripts --no-interaction \
    && npm install \
    && npm run build

# Set proper permissions for Laravel directories
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache

# Use default port 8000 if PORT environment variable is missing
CMD php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
