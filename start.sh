#!/bin/bash
set -e

echo "Starting Laravel immediately..."

# Install Python in background (non-blocking)
(
  echo "Installing Python in background..."
  apt-get update -qq
  apt-get install -y python3 python3-pip
  pip3 install --break-system-packages -q -r requirements.txt
  echo "Python installation complete!"
) &

# Start Laravel right away (don't wait for Python)
php artisan serve --host=0.0.0.0 --port=$PORT