# Workflow Deployment untuk Hostinger Premium

## 🚀 Proses Development & Deployment

### 1. Local Development
```bash
# Develop di local dengan sistem update
git add .
git commit -m "Add new feature"
git push origin main

# Test sistem update di local
php artisan serve
# Buka: http://localhost:8000/dashboard/system-updates
```

### 2. Prepare for Production
```bash
# Optimize untuk production
composer install --no-dev --optimize-autoloader
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Create production build
npm run build  # jika ada assets
```

### 3. Upload ke Hostinger
**Via File Manager (cPanel):**
1. Login ke Hostinger cPanel
2. Buka File Manager
3. Upload file project (exclude: .git, node_modules, .env)
4. Extract di public_html folder

**Via FTP:**
```bash
# Gunakan FileZilla atau WinSCP
Host: ftp.yourdomain.com
Username: [hostinger username]
Password: [hostinger password]
```

### 4. Setup Database
1. Buka phpMyAdmin di cPanel
2. Import database structure
3. Update .env file dengan database credentials Hostinger

### 5. Final Configuration
```bash
# Via cPanel Terminal (jika tersedia) atau File Manager
# Edit .env file:
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=[hostinger_db_name]
DB_USERNAME=[hostinger_db_user]
DB_PASSWORD=[hostinger_db_pass]
```

## 📁 File Structure di Hostinger
```
public_html/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/          # Document root
│   ├── index.php
│   ├── css/
│   └── js/
├── resources/
├── routes/
├── storage/
├── vendor/
└── .env
```

## ⚠️ Important Notes

### Yang TIDAK Upload:
- `.git/` folder
- `node_modules/`
- `.env` (buat baru di server)
- `storage/logs/` (buat folder kosong)
- `vendor/` (upload manual atau via Composer jika ada akses)

### Yang Harus Diperhatikan:
1. **File Permissions:** Set 755 untuk folders, 644 untuk files
2. **Storage Folder:** Harus writable (775)
3. **Database:** Import via phpMyAdmin
4. **Domain:** Pointing ke /public folder

## 🔄 Update Process (Manual)

### Ketika Ada Update Baru:
1. **Local:** Develop & test
2. **Git:** Push ke repository
3. **Download:** Download updated files dari Git
4. **Upload:** Upload changed files via FTP/File Manager
5. **Database:** Run migration manual jika ada
6. **Cache:** Clear cache via cPanel atau manual delete

### Quick Update Script (Local)
```bash
#!/bin/bash
# create-update-package.sh

# Create update package
git archive --format=zip --output=update-$(date +%Y%m%d).zip HEAD

echo "Update package created: update-$(date +%Y%m%d).zip"
echo "Upload this to Hostinger and extract in public_html"
```





