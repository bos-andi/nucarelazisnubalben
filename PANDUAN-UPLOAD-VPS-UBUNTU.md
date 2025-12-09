# 🚀 Panduan Upload ke VPS Ubuntu

## 📋 Persiapan di Lokal (Windows)

### 1. Commit & Push Semua Perubahan ke Git

```bash
# Cek file yang berubah
git status

# Tambahkan semua file
git add .

# Commit dengan pesan jelas
git commit -m "Update: Fitur resize gambar, permission system, dan verifikasi user"

# Push ke repository
git push origin main
```

**Pastikan semua file sudah di-push!** Cek di GitHub/GitLab apakah semua file sudah ada.

---

## 🖥️ Setup di VPS Ubuntu

### **Langkah 1: Login ke VPS via SSH**

```bash
# Di Windows, gunakan PowerShell atau PuTTY
ssh root@your-vps-ip
# atau
ssh username@your-vps-ip
```

### **Langkah 2: Install Dependencies**

```bash
# Update sistem
sudo apt update && sudo apt upgrade -y

# Install Git
sudo apt install git -y

# Install PHP 8.1 dan extensions
sudo apt install php8.1 php8.1-fpm php8.1-mysql php8.1-mbstring php8.1-xml php8.1-curl php8.1-zip php8.1-gd php8.1-bcmath -y

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
sudo chmod +x /usr/local/bin/composer

# Install Nginx (jika belum ada)
sudo apt install nginx -y

# Install MySQL
sudo apt install mysql-server -y
```

### **Langkah 3: Clone Repository**

```bash
# Masuk ke direktori web server
cd /var/www/html

# Clone repository (ganti URL dengan repository Anda)
sudo git clone https://github.com/username/lazisnubalongbendo.git

# Masuk ke folder project
cd lazisnubalongbendo

# Atau jika sudah ada, pull update terbaru
cd /var/www/html/lazisnubalongbendo
sudo git pull origin main
```

### **Langkah 4: Setup Environment**

```bash
# Copy file .env
sudo cp .env.example .env

# Edit .env (gunakan nano atau vi)
sudo nano .env
```

**Isi file `.env` dengan konfigurasi VPS:**
```env
APP_NAME="Lazisnu Balongbendo"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=http://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=nama_user
DB_PASSWORD=password_database
```

**Generate APP_KEY:**
```bash
sudo php artisan key:generate
```

### **Langkah 5: Set Permissions**

```bash
# Set ownership ke web server user
sudo chown -R www-data:www-data /var/www/html/lazisnubalongbendo

# Set permissions
sudo chmod -R 755 /var/www/html/lazisnubalongbendo
sudo chmod -R 775 /var/www/html/lazisnubalongbendo/storage
sudo chmod -R 775 /var/www/html/lazisnubalongbendo/bootstrap/cache
```

### **Langkah 6: Install Dependencies & Setup Database**

```bash
# Install Composer dependencies
sudo -u www-data composer install --no-dev --optimize-autoloader

# Buat database (jika belum ada)
sudo mysql -u root -p
```

**Di MySQL:**
```sql
CREATE DATABASE nama_database CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'nama_user'@'localhost' IDENTIFIED BY 'password_database';
GRANT ALL PRIVILEGES ON nama_database.* TO 'nama_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

**Kembali ke terminal:**
```bash
# Run migrations
sudo -u www-data php artisan migrate

# Run seeders (jika perlu)
sudo -u www-data php artisan db:seed

# Clear dan cache config
sudo -u www-data php artisan config:clear
sudo -u www-data php artisan cache:clear
sudo -u www-data php artisan view:clear
sudo -u www-data php artisan config:cache
sudo -u www-data php artisan route:cache
sudo -u www-data php artisan view:cache
```

### **Langkah 7: Setup Nginx**

```bash
# Buat file konfigurasi Nginx
sudo nano /etc/nginx/sites-available/lazisnubalongbendo
```

**Isi dengan konfigurasi berikut:**
```nginx
server {
    listen 80;
    server_name yourdomain.com www.yourdomain.com;
    root /var/www/html/lazisnubalongbendo/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

**Aktifkan konfigurasi:**
```bash
# Enable site
sudo ln -s /etc/nginx/sites-available/lazisnubalongbendo /etc/nginx/sites-enabled/

# Test konfigurasi Nginx
sudo nginx -t

# Restart Nginx
sudo systemctl restart nginx
```

### **Langkah 8: Setup SSL (Opsional - Let's Encrypt)**

```bash
# Install Certbot
sudo apt install certbot python3-certbot-nginx -y

# Generate SSL certificate
sudo certbot --nginx -d yourdomain.com -d www.yourdomain.com

# Auto-renewal (sudah otomatis)
sudo certbot renew --dry-run
```

---

## 🔄 Update dari Lokal ke VPS (Setelah Setup Pertama)

### **Cara 1: Via Git Pull (Recommended)**

**Di Lokal (Windows):**
```bash
# Commit dan push perubahan
git add .
git commit -m "Update: Deskripsi perubahan"
git push origin main
```

**Di VPS (Ubuntu):**
```bash
# Login ke VPS
ssh root@your-vps-ip

# Masuk ke folder project
cd /var/www/html/lazisnubalongbendo

# Pull update terbaru
sudo -u www-data git pull origin main

# Install dependencies baru (jika ada)
sudo -u www-data composer install --no-dev --optimize-autoloader

# Run migrations baru (jika ada)
sudo -u www-data php artisan migrate

# Clear cache
sudo -u www-data php artisan config:clear
sudo -u www-data php artisan cache:clear
sudo -u www-data php artisan view:clear

# Re-cache
sudo -u www-data php artisan config:cache
sudo -u www-data php artisan route:cache
sudo -u www-data php artisan view:cache
```

### **Cara 2: Via System Updates (Admin Panel)**

1. Login ke admin panel: `http://yourdomain.com/dashboard`
2. Masuk ke menu **System Updates**
3. Klik **Check Updates** untuk cek update terbaru
4. Jika ada update, klik **Deploy** untuk update otomatis

**Catatan:** Pastikan Git repository sudah terkonfigurasi dengan benar di VPS.

---

## 🛠️ Troubleshooting

### **Error: Permission Denied**

```bash
# Fix permissions
sudo chown -R www-data:www-data /var/www/html/lazisnubalongbendo
sudo chmod -R 755 /var/www/html/lazisnubalongbendo
sudo chmod -R 775 /var/www/html/lazisnubalongbendo/storage
sudo chmod -R 775 /var/www/html/lazisnubalongbendo/bootstrap/cache
```

### **Error: Composer Memory Limit**

```bash
# Increase memory limit
php -d memory_limit=-1 /usr/local/bin/composer install
```

### **Error: Database Connection Failed**

```bash
# Cek konfigurasi database
sudo nano /var/www/html/lazisnubalongbendo/.env

# Test koneksi MySQL
sudo mysql -u nama_user -p nama_database
```

### **Error: 500 Internal Server Error**

```bash
# Cek error log
sudo tail -f /var/log/nginx/error.log
sudo tail -f /var/www/html/lazisnubalongbendo/storage/logs/laravel.log

# Clear cache
sudo -u www-data php artisan config:clear
sudo -u www-data php artisan cache:clear
```

### **Error: Storage Link Not Found**

```bash
# Create storage link
sudo -u www-data php artisan storage:link
```

---

## ✅ Checklist Deployment

### **Sebelum Upload:**
- [ ] Semua perubahan sudah di-commit dan di-push ke Git
- [ ] File `.env.example` sudah lengkap
- [ ] Database migration sudah siap
- [ ] Test semua fitur di lokal

### **Saat Setup VPS:**
- [ ] Git terinstall
- [ ] PHP 8.1 dan extensions terinstall
- [ ] Composer terinstall
- [ ] Nginx terkonfigurasi
- [ ] Database dibuat dan user dibuat
- [ ] File `.env` sudah dikonfigurasi
- [ ] Permissions sudah benar
- [ ] Migration sudah dijalankan
- [ ] Cache sudah di-clear dan di-re-cache

### **Setelah Setup:**
- [ ] Website bisa diakses
- [ ] Login admin berfungsi
- [ ] Semua fitur berfungsi
- [ ] System Updates berfungsi (jika menggunakan Git)

---

## 📝 Catatan Penting

1. **Jangan upload file `.env` dari lokal ke VPS!** Setiap environment punya konfigurasi sendiri.

2. **Selalu backup database sebelum update:**
   ```bash
   mysqldump -u nama_user -p nama_database > backup_$(date +%Y%m%d).sql
   ```

3. **Gunakan `sudo -u www-data`** untuk menjalankan perintah Laravel agar file ownership tetap benar.

4. **Monitor log files** untuk debugging:
   ```bash
   sudo tail -f /var/www/html/lazisnubalongbendo/storage/logs/laravel.log
   ```

5. **Setup firewall** untuk keamanan:
   ```bash
   sudo ufw allow 22/tcp
   sudo ufw allow 80/tcp
   sudo ufw allow 443/tcp
   sudo ufw enable
   ```

---

## 🎯 Quick Commands Reference

```bash
# Pull update
cd /var/www/html/lazisnubalongbendo && sudo -u www-data git pull origin main

# Run migration
sudo -u www-data php artisan migrate

# Clear all cache
sudo -u www-data php artisan config:clear && sudo -u www-data php artisan cache:clear && sudo -u www-data php artisan view:clear

# Re-cache all
sudo -u www-data php artisan config:cache && sudo -u www-data php artisan route:cache && sudo -u www-data php artisan view:cache

# Check permissions
ls -la /var/www/html/lazisnubalongbendo

# Restart services
sudo systemctl restart nginx
sudo systemctl restart php8.1-fpm
```

---

## ✅ Selesai!

Dengan panduan ini, Anda bisa upload dan mengupdate aplikasi ke VPS Ubuntu dengan mudah!

**Pertanyaan?** Jangan ragu untuk bertanya! 🚀

