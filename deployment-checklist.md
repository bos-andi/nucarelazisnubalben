# Checklist Deployment & Update System

## ✅ Sebelum Upload ke Hosting

### 1. Persiapan Repository
- [ ] Push semua code ke GitHub/GitLab
- [ ] Pastikan .env.example sudah lengkap
- [ ] Test sistem update di local
- [ ] Buat dokumentasi deployment

### 2. Pilih Hosting yang Tepat
- [ ] VPS/Cloud hosting (bukan shared hosting)
- [ ] SSH access tersedia
- [ ] Git terinstall atau bisa diinstall
- [ ] PHP 8.1+ dengan extension lengkap
- [ ] MySQL/PostgreSQL database

### 3. Backup & Security
- [ ] Setup database backup otomatis
- [ ] Konfigurasi SSL certificate
- [ ] Setup firewall rules
- [ ] Buat user non-root untuk deployment

## ✅ Setelah Upload ke Hosting

### 1. Test Dasar
- [ ] Website bisa diakses
- [ ] Login admin berfungsi
- [ ] Database connection OK
- [ ] File permissions benar

### 2. Test Sistem Update
- [ ] Halaman System Updates terbuka tanpa error
- [ ] Git repository terdeteksi
- [ ] Remote origin terkonfigurasi
- [ ] "Check Updates" berfungsi
- [ ] Test deployment (jika ada update)

### 3. Monitoring
- [ ] Setup log monitoring
- [ ] Test backup restore
- [ ] Monitor performance
- [ ] Setup uptime monitoring

## 🚨 Troubleshooting Common Issues

### Git Permission Denied
```bash
sudo chown -R www-data:www-data /var/www/html/project
sudo -u www-data git pull origin main
```

### Composer Memory Limit
```bash
php -d memory_limit=-1 /usr/local/bin/composer install
```

### File Permissions
```bash
sudo chmod -R 775 storage bootstrap/cache
sudo chown -R www-data:www-data storage bootstrap/cache
```




