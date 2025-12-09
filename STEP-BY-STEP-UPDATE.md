# 🚀 Panduan Update Manual - Step by Step

## ✅ UPDATE MANUAL BISA DILAKUKAN!

Ini adalah panduan lengkap untuk update website secara manual di Hostinger Premium.

---

## 📋 LANGKAH 1: Persiapan di Local

### 1.1. Pastikan Semua Perubahan Sudah di Git
```bash
# Cek status
git status

# Jika ada perubahan, commit dulu
git add .
git commit -m "Update: [deskripsi perubahan]"
git push origin main
```

### 1.2. Identifikasi File yang Berubah
```bash
# Lihat file yang berubah dari commit terakhir
git diff --name-only HEAD~1

# Atau lihat semua file yang modified
git status --short
```

### 1.3. Backup Database (PENTING!)
- Login ke phpMyAdmin di Hostinger cPanel
- Pilih database website Anda
- Klik **Export** → **Go**
- Simpan file backup

---

## 📤 LANGKAH 2: Upload File ke Hostinger

### 2.1. Via File Manager (Paling Mudah)

1. **Login ke Hostinger cPanel**
   - Buka: https://hpanel.hostinger.com
   - Login dengan akun Hostinger

2. **Buka File Manager**
   - Cari menu **File Manager**
   - Klik untuk membuka

3. **Navigate ke Folder Project**
   - Masuk ke folder `public_html` atau folder project Anda
   - Pastikan di folder yang benar

4. **Upload File**
   - Klik **Upload** di toolbar
   - Pilih file yang berubah dari local
   - Tunggu sampai upload selesai
   - **Replace** file yang sudah ada

### 2.2. Via FTP (FileZilla) - Lebih Cepat untuk Banyak File

1. **Download FileZilla**
   - https://filezilla-project.org/download.php?type=client
   - Install di komputer

2. **Connect ke Server**
   ```
   Host: ftp.yourdomain.com
   Username: [dari Hostinger]
   Password: [dari Hostinger]
   Port: 21
   ```

3. **Upload File**
   - Drag & drop file dari local ke server
   - Replace file yang sudah ada

---

## 🗄️ LANGKAH 3: Update Database (Jika Ada)

### 3.1. Jika Ada Migration Baru

1. **Buka phpMyAdmin**
   - Login ke cPanel Hostinger
   - Klik **phpMyAdmin**

2. **Pilih Database**
   - Klik nama database website Anda

3. **Jalankan SQL**
   - Klik tab **SQL**
   - Copy SQL dari file migration
   - Paste dan klik **Go**

### 3.2. Contoh Migration SQL
```sql
-- Contoh: Menambah kolom baru
ALTER TABLE `articles` 
ADD COLUMN `featured` TINYINT(1) DEFAULT 0 
AFTER `status`;

-- Contoh: Membuat tabel baru
CREATE TABLE IF NOT EXISTS `system_updates` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) DEFAULT NULL,
  `status` enum('pending','completed') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

---

## ⚙️ LANGKAH 4: Update Konfigurasi (Jika Perlu)

### 4.1. Update .env File
- Buka File Manager
- Edit file `.env`
- Update konfigurasi yang berubah
- **JANGAN** upload .env dari local (bisa berbeda)

### 4.2. Clear Cache (Jika Bisa)
Jika ada akses terminal:
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

Jika tidak ada akses terminal:
- Hapus folder `bootstrap/cache/*` (kecuali .gitignore)
- Hapus folder `storage/framework/cache/*`

---

## ✅ LANGKAH 5: Testing

### 5.1. Test Website
- Buka website di browser
- Test semua halaman utama
- Test fitur yang di-update
- Clear browser cache (Ctrl+Shift+Delete)

### 5.2. Test Admin Dashboard
- Login ke admin
- Test semua menu
- Pastikan tidak ada error

### 5.3. Cek Error Log
- Buka cPanel → **Error Log**
- Pastikan tidak ada error baru

---

## 📝 CONTOH KASUS: Update Fitur Baru

### Skenario: Menambah fitur "Komentar Artikel"

**File yang Berubah:**
```
app/Http/Controllers/Admin/ArticleController.php
app/Models/Comment.php
resources/views/admin/articles/show.blade.php
routes/web.php
database/migrations/2024_01_01_create_comments_table.php
```

**Langkah Update:**
1. ✅ Upload semua file di atas via FTP
2. ✅ Jalankan migration SQL di phpMyAdmin
3. ✅ Test halaman artikel
4. ✅ Test fitur komentar

---

## 🛠️ TOOLS YANG DIBUTUHKAN

### 1. FileZilla (FTP Client)
- Download: https://filezilla-project.org/
- Gratis dan mudah digunakan

### 2. Notepad++ (Text Editor)
- Untuk edit file jika perlu
- Download: https://notepad-plus-plus.org/

### 3. Git (di Local)
- Untuk tracking perubahan
- Sudah terinstall di komputer Anda

---

## ⚠️ PENTING: Yang HARUS Diperhatikan

### ❌ JANGAN Upload:
- Folder `.git/`
- Folder `node_modules/`
- File `.env` dari local
- Folder `storage/logs/` (isi log)
- File `composer.lock` (jika tidak ada Composer di server)

### ✅ HARUS Upload:
- File PHP yang berubah
- File view/template yang berubah
- File config yang berubah
- File migration (untuk reference SQL)

### 🔒 Security:
- Jangan upload file dengan password/credential
- Pastikan .env tidak ter-expose
- Set permission file dengan benar (644 untuk file, 755 untuk folder)

---

## 🆘 Troubleshooting

### Error: White Screen
**Solusi:**
1. Cek error log di cPanel
2. Pastikan semua file ter-upload
3. Cek .env configuration
4. Clear cache

### Error: Database Connection Failed
**Solusi:**
1. Cek .env file
2. Pastikan database credentials benar
3. Test connection via phpMyAdmin

### Error: Permission Denied
**Solusi:**
1. Set folder permission: 755
2. Set file permission: 644
3. Storage folder: 775

---

## 💡 Tips & Best Practices

1. **Selalu Backup Dulu**
   - Database: Export via phpMyAdmin
   - Files: Download via FTP sebelum update

2. **Update Bertahap**
   - Jangan update semua sekaligus
   - Test setiap perubahan

3. **Gunakan Git untuk Tracking**
   - Commit setiap perubahan
   - Buat branch untuk fitur besar

4. **Dokumentasi**
   - Catat file apa yang diubah
   - Simpan SQL migration
   - Catat perubahan config

---

## ✅ Checklist Update Manual

### Sebelum Update:
- [ ] Backup database
- [ ] Backup files (download via FTP)
- [ ] Test di local
- [ ] Commit ke Git
- [ ] Catat file yang berubah

### Saat Update:
- [ ] Upload file via FTP/File Manager
- [ ] Update database (jika ada migration)
- [ ] Update .env (jika perlu)
- [ ] Set file permissions

### Setelah Update:
- [ ] Test website
- [ ] Test fitur yang di-update
- [ ] Clear cache
- [ ] Cek error log
- [ ] Dokumentasi perubahan

---

## 🎉 SELESAI!

Dengan panduan ini, Anda bisa update website secara manual dengan mudah dan aman!

**Pertanyaan?** Jangan ragu untuk bertanya! 🚀





