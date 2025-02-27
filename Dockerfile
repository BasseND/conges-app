FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy existing application directory
COPY . /app/

# Install Composer dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Install NPM dependencies
RUN npm ci && npm run build

# Set permissions
RUN chown -R www-data:www-data /app \
    && chmod -R 755 /app/storage

# Expose port 9000
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]
