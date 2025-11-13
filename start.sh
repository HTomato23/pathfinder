#!/bin/bash
set -e

# Install Python if not already installed
if ! command -v python3 &> /dev/null; then
    echo "Installing Python..."
    apt-get update -qq
    apt-get install -y python3 python3-pip
    pip3 install --break-system-packages -r requirements.txt
fi

# Start Laravel
php artisan serve --host=0.0.0.0 --port=$PORT