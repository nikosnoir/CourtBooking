FROM php:8.1-apache

# Install Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash -
RUN apt-get install -y nodejs

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    sqlite3 \
    libsqlite3-dev

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .

# Install Node.js dependencies
RUN npm install

# Create data directory for SQLite
RUN mkdir -p data && chmod 755 data

# Expose ports
EXPOSE 80 3000

# Start both Apache and Node.js
CMD ["bash", "-c", "apache2-foreground & node server.js & wait"]
