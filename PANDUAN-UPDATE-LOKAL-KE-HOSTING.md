# 📤 Panduan Update dari Lokal ke Hosting

## 🎯 Ringkasan Proses

Ketika Anda sudah membuat perubahan di lokal dan ingin update ke hosting, ada beberapa cara:

---

## 🔄 **CARA 1: Update Manual via FTP/File Manager** (Paling Mudah)

### **Langkah 1: Identifikasi File yang Berubah**

Di lokal, jalankan perintah ini untuk melihat file apa saja yang berubah:

```bash
# Lihat file yang berubah dari commit terakhir
git status

# Atau lihat file yang berubah dari commit tertentu
git diff --name-only HEAD~1

# Contoh output:
# app/Http/Controllers/Admin/KhutbahController.php
# resources/views/admin/khutbah/create.blade.php
# database/migrations/2025_11_26_233312_merge_arabic_and_indonesian_content_in_khutbah_jumats_table.php
```

### **Langkah 2: Backup Database di Hosting** ⚠️ PENTING!

1. Login ke cPanel Hostinger
2. Buka **phpMyAdmin**
3. Pilih database website Anda
4. Klik **Export** → **Go**
5. Simpan file backup (untuk jaga-jaga)

### **Langkah 3: Upload File ke Hosting**

**Opsi A: Via File Manager (cPanel)**
1. Login ke Hostinger cPanel
2. Buka **File Manager**
3. Navigate ke folder project (biasanya `public_html`)
4. Upload file yang berubah:
   - Drag & drop file dari lokal
   - **Replace** file yang sudah ada
   - Pastikan path folder sama dengan di lokal

**Opsi B: Via FTP (FileZilla) - Lebih Cepat**
1. Download FileZilla: https://filezilla-project.org/
2. Connect ke server:
   ```
   Host: ftp.yourdomain.com
   Username: [dari Hostinger]
   Password: [dari Hostinger]
   Port: 21
   ```
3. Drag & drop file yang berubah dari lokal ke server
4. Replace file yang sudah ada

### **Langkah 4: Update Database (Jika Ada Migration Baru)**

Jika ada file migration baru (di folder `database/migrations/`):

1. Buka **phpMyAdmin** di cPanel
2. Pilih database website
3. Klik tab **SQL**
4. Buka file migration di lokal (misal: `2025_11_26_233312_merge_arabic_and_indonesian_content_in_khutbah_jumats_table.php`)
5. Copy isi SQL-nya (bagian `up()` method)
6. Paste di phpMyAdmin SQL tab
7. Klik **Go**

**Contoh SQL dari migration:**
```sql
ALTER TABLE `khutbah_jumats` 
ADD COLUMN `content` LONGTEXT NULL AFTER `slug`;

UPDATE khutbah_jumats 
SET content = CONCAT(
    '<div class="arabic-content" dir="rtl">',
    arabic_content,
    '</div>',
    '<div class="indonesian-content">',
    indonesian_content,
    '</div>'
);

ALTER TABLE `khutbah_jumats` 
DROP COLUMN `arabic_content`,
DROP COLUMN `indonesian_content`;
```

### **Langkah 5: Clear Cache**

**Jika ada akses Terminal di cPanel:**
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

**Jika tidak ada akses Terminal:**
- Hapus folder `bootstrap/cache/*` (kecuali file `.gitignore`)
- Hapus folder `storage/framework/cache/*`

### **Langkah 6: Test Website**

1. Buka website di browser
2. Test halaman yang di-update
3. Test fitur baru
4. Clear browser cache (Ctrl+Shift+Delete)

---

## 🔄 **CARA 2: Via Git Pull** (Jika Hosting Support Git)

### **Persyaratan:**
- Hosting support SSH access
- Git sudah terinstall di server
- Repository sudah di-clone di server

### **Langkah:**

**1. Di Lokal - Push ke Git:**
```bash
git add .
git commit -m "Update: Tambah fitur khutbah Jum'at"
git push origin main
```

**2. Di Server - Pull Update:**
```bash
# Login via SSH ke server
ssh user@yourdomain.com

# Masuk ke folder project
cd /path/to/project

# Pull update terbaru
git pull origin main

# Run migration (jika ada)
php artisan migrate

# Clear cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

---

## 📋 **Checklist Update**

### ✅ **Sebelum Update:**
- [ ] Test semua fitur di lokal
- [ ] Commit semua perubahan ke Git
- [ ] Backup database di hosting
- [ ] Catat file apa saja yang berubah
- [ ] Catat migration apa saja yang baru

### ✅ **Saat Update:**
- [ ] Upload file yang berubah via FTP/File Manager
- [ ] Jalankan migration SQL di phpMyAdmin (jika ada)
- [ ] Update .env jika ada config baru (jangan upload .env dari lokal!)
- [ ] Set file permissions (755 untuk folder, 644 untuk file)

### ✅ **Setelah Update:**
- [ ] Test website berfungsi normal
- [ ] Test fitur yang di-update
- [ ] Clear browser cache
- [ ] Cek error log di cPanel (jika ada)

---

## 📦 **File yang HARUS Di-upload**

### ✅ **Yang HARUS Upload:**
- `app/Http/Controllers/...` (jika ada perubahan)
- `app/Models/...` (jika ada perubahan)
- `resources/views/...` (jika ada perubahan)
- `routes/web.php` (jika ada perubahan)
- `database/migrations/...` (untuk reference SQL)
- `public/...` (jika ada asset baru)

### ❌ **Yang TIDAK Perlu Upload:**
- Folder `.git/`
- Folder `node_modules/`
- File `.env` (jangan upload dari lokal!)
- Folder `vendor/` (kecuali ada dependency baru)
- Folder `storage/logs/` (isi log)

---

## 🗄️ **Update Database - Detail**

### **Jika Ada Migration Baru:**

1. **Buka file migration di lokal:**
   - Contoh: `database/migrations/2025_11_26_233312_merge_arabic_and_indonesian_content_in_khutbah_jumats_table.php`

2. **Lihat method `up()`:**
   - Copy semua perintah SQL-nya

3. **Jalankan di phpMyAdmin:**
   - Login phpMyAdmin
   - Pilih database
   - Tab SQL
   - Paste SQL
   - Klik Go

4. **Verifikasi:**
   - Cek struktur tabel sudah berubah
   - Test fitur yang menggunakan tabel tersebut

---

## 🛠️ **Tools yang Dibutuhkan**

### **1. FileZilla (FTP Client)**
- Download: https://filezilla-project.org/
- Gratis, mudah digunakan
- Untuk upload file ke server

### **2. Git (di Lokal)**
- Untuk tracking perubahan
- Untuk backup code
- Sudah terinstall di komputer Anda

### **3. Notepad++ (Optional)**
- Untuk edit file jika perlu
- Download: https://notepad-plus-plus.org/

---

## ⚠️ **PENTING: Yang Harus Diperhatikan**

### **1. Jangan Upload .env dari Lokal**
- `.env` di lokal berbeda dengan di hosting
- Edit `.env` di hosting langsung via File Manager
- Jangan pernah upload `.env` dari lokal ke hosting!

### **2. Backup Database Dulu**
- Selalu backup database sebelum update
- Export via phpMyAdmin
- Simpan file backup

### **3. Test di Lokal Dulu**
- Pastikan semua fitur bekerja di lokal
- Fix semua error sebelum upload ke hosting

### **4. Update Bertahap**
- Jangan update semua sekaligus
- Test setiap perubahan
- Jika ada error, rollback file yang bermasalah

---

## 🆘 **Troubleshooting**

### **Error: White Screen**
**Solusi:**
1. Cek error log di cPanel → Error Log
2. Pastikan semua file ter-upload dengan benar
3. Cek `.env` configuration
4. Clear cache

### **Error: Database Connection Failed**
**Solusi:**
1. Cek `.env` file di hosting
2. Pastikan database credentials benar
3. Test connection via phpMyAdmin

### **Error: Permission Denied**
**Solusi:**
1. Set folder permission: **755**
2. Set file permission: **644**
3. Storage folder: **775**

### **Error: Migration Failed**
**Solusi:**
1. Cek SQL syntax di phpMyAdmin
2. Pastikan backup database sudah dibuat
3. Rollback jika perlu (restore backup)

---

## 💡 **Tips & Best Practices**

1. **Selalu Backup Dulu**
   - Database: Export via phpMyAdmin
   - Files: Download via FTP sebelum update

2. **Gunakan Git untuk Tracking**
   - Commit setiap perubahan
   - Buat branch untuk fitur besar
   - Tag release version

3. **Dokumentasi Perubahan**
   - Catat file apa yang diubah
   - Catat perubahan database
   - Simpan SQL migration

4. **Test Setelah Update**
   - Test semua halaman utama
   - Test fitur yang di-update
   - Test admin panel

---

## 📝 **Contoh Kasus: Update Fitur Khutbah Jum'at**

**File yang Berubah:**
```
app/Http/Controllers/Admin/KhutbahController.php
app/Models/KhutbahJumat.php
resources/views/admin/khutbah/create.blade.php
resources/views/admin/khutbah/edit.blade.php
resources/views/pages/khutbah-detail.blade.php
routes/web.php
database/migrations/2025_11_26_233312_merge_arabic_and_indonesian_content_in_khutbah_jumats_table.php
```

**Langkah Update:**
1. ✅ Upload semua file di atas via FTP
2. ✅ Jalankan migration SQL di phpMyAdmin
3. ✅ Clear cache
4. ✅ Test halaman khutbah
5. ✅ Test form tambah/edit khutbah

---

## ✅ **Selesai!**

Dengan panduan ini, Anda bisa update website dari lokal ke hosting dengan mudah dan aman!

**Pertanyaan?** Jangan ragu untuk bertanya! 🚀





