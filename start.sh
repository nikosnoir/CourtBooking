#!/bin/bash
# Start script for Render deployment

echo "Starting UiTM Court Booking System on Render..."

# Get the port from environment (Render provides this)
export PORT=${PORT:-8080}

# Start PHP built-in server
echo "Starting PHP server on port $PORT..."
php -S 0.0.0.0:$PORT &
PHP_PID=$!

# Start Node.js server on port 3000
echo "Starting Node.js API server on port 3000..."
export NODE_PORT=3000
node server.js &
NODE_PID=$!

echo "Servers started successfully!"
echo "PHP Server PID: $PHP_PID"
echo "Node.js Server PID: $NODE_PID"

# Function to handle shutdown
shutdown() {
    echo "Shutting down servers..."
    kill $PHP_PID $NODE_PID 2>/dev/null
    exit 0
}

# Set up signal handlers
trap shutdown SIGTERM SIGINT

# Wait for any process to exit
wait -n

# If we get here, one of the processes exited
echo "One of the servers stopped. Shutting down..."
shutdown
