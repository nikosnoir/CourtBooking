#!/bin/bash
# Build script for Render deployment

echo "Starting build process..."

# Install Composer if composer.json exists
if [ -f composer.json ]; then
    echo "Installing PHP dependencies..."
    composer install --no-dev --optimize-autoloader
fi

# Install Node.js dependencies
echo "Installing Node.js dependencies..."
npm install --production

# Create necessary directories
echo "Creating required directories..."
mkdir -p data
chmod 755 data

# Copy production environment file if it exists
if [ -f .env.production ]; then
    cp .env.production .env
fi

echo "Build completed successfully!"
