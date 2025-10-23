FROM php:8.3-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libsqlite3-dev \
    zip \
    unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql pdo_sqlite mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy application files
COPY . /var/www

# Set permissions
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage \
    && chmod -R 755 /var/www/bootstrap/cache

# Create startup script
RUN echo '#!/bin/bash\n\
set -e\n\
\n\
echo "Starting Laravel application setup..."\n\
\n\
# Install dependencies\n\
echo "Installing dependencies..."\n\
composer install --no-interaction --optimize-autoloader\n\
\n\
# Create .env if not exists\n\
if [ ! -f .env ]; then\n\
    echo "Creating .env file..."\n\
    cp .env.example .env\n\
fi\n\
\n\
# Always generate application key to ensure it exists\n\
echo "Generating application key..."\n\
php artisan key:generate --force\n\
\n\
# Wait for database\n\
echo "Waiting for database..."\n\
sleep 10\n\
\n\
# Run migrations and seeders\n\
echo "Running migrations..."\n\
php artisan migrate --force\n\
\n\
echo "Running seeders..."\n\
php artisan db:seed --force\n\
\n\
# Optimize application\n\
echo "Optimizing application..."\n\
php artisan config:cache\n\
php artisan route:cache\n\
php artisan view:cache\n\
\n\
echo "Starting PHP-FPM..."\n\
php-fpm' > /usr/local/bin/start.sh \
    && chmod +x /usr/local/bin/start.sh

EXPOSE 9000

CMD ["/usr/local/bin/start.sh"]
