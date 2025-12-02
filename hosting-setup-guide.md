# Setup Sistem Update di VPS Hosting

## 1. Install Dependencies
```bash
# Install Git
sudo apt update
sudo apt install git

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Install Node.js (jika diperlukan)
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt-get install -y nodejs
```

## 2. Clone Repository
```bash
cd /var/www/html
sudo git clone https://github.com/username/lazisnubalongbendo.git
cd lazisnubalongbendo
```

## 3. Set Permissions
```bash
# Set ownership ke web server user
sudo chown -R www-data:www-data /var/www/html/lazisnubalongbendo
sudo chmod -R 755 /var/www/html/lazisnubalongbendo
sudo chmod -R 775 storage bootstrap/cache
```

## 4. Setup Environment
```bash
# Copy environment file
cp .env.example .env
nano .env  # Edit database dan config lainnya

# Install dependencies
composer install --no-dev --optimize-autoloader
php artisan key:generate
php artisan migrate
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 5. Setup Web Server (Nginx)
```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /var/www/html/lazisnubalongbendo/public;
    
    index index.php;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

## 6. Test Sistem Update
1. Buka yourdomain.com/dashboard/system-updates
2. Login sebagai superadmin
3. Cek status Git Repository
4. Test "Check Updates"
5. Jika ada update, test "Deploy"




