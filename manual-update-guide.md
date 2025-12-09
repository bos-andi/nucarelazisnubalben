# 📋 Panduan Update Manual untuk Hostinger Premium

## ✅ Update Manual BISA Dilakukan!

Meskipun auto-update tidak berfungsi, Anda tetap bisa update website secara manual dengan mudah.

---

## 🔄 Workflow Update Manual

### **Step 1: Development di Local**
```bash
# 1. Develop fitur baru di local
# 2. Test semua fitur
# 3. Commit ke Git
git add .
git commit -m "Update: Add new feature"
git push origin main
```

### **Step 2: Identifikasi File yang Berubah**
```bash
# Lihat file apa saja yang berubah
git diff HEAD~1 --name-only

# Atau lihat perubahan dari commit tertentu
git diff [commit-hash] --name-only
```

### **Step 3: Upload File ke Hostinger**

**Via File Manager (cPanel):**
1. Login ke Hostinger cPanel
2. Buka **File Manager**
3. Navigate ke folder project
4. Upload file yang berubah (replace yang lama)

**Via FTP (FileZilla/WinSCP):**
1. Connect ke server Hostinger
2. Navigate ke folder project
3. Upload file yang berubah

---

## 📦 Cara Update Berdasarkan Jenis Perubahan

### **1. Update Code PHP (Controller, Model, dll)**
```
✅ Yang perlu di-upload:
- app/Http/Controllers/...
- app/Models/...
- app/Services/...
- routes/web.php (jika ada perubahan)

❌ Yang TIDAK perlu di-upload:
- vendor/ (jika tidak ada dependency baru)
- node_modules/
- .env (jangan di-upload!)
```

### **2. Update View/Template**
```
✅ Yang perlu di-upload:
- resources/views/...
- resources/css/...
- resources/js/...

⚠️ Setelah upload:
- Clear browser cache
- Clear Laravel view cache (jika bisa akses terminal)
```

### **3. Update Database (Migration)**
```
⚠️ PENTING: Backup database dulu!

Via phpMyAdmin:
1. Login ke phpMyAdmin di cPanel
2. Pilih database
3. Export/Backup dulu
4. Jalankan SQL migration manual
5. Atau import SQL file yang sudah disiapkan
```

### **4. Update Dependencies (Composer)**
```
❌ TIDAK BISA di Hostinger Premium
✅ Solusi: Install di local, upload folder vendor/
```

---

## 🛠️ Tools yang Dibutuhkan

### **1. FileZilla (FTP Client)**
- Download: https://filezilla-project.org/
- Untuk upload file via FTP

### **2. WinSCP (Alternative)**
- Download: https://winscp.net/
- Windows SCP client

### **3. Git (di Local)**
- Untuk tracking perubahan
- Untuk backup code

---

## 📝 Checklist Update Manual

### **Sebelum Update:**
- [ ] Backup database via phpMyAdmin
- [ ] Backup file project (download via FTP)
- [ ] Test semua fitur di local
- [ ] Commit semua perubahan ke Git
- [ ] Catat file apa saja yang berubah

### **Saat Update:**
- [ ] Upload file yang berubah via FTP/File Manager
- [ ] Update database (jika ada migration)
- [ ] Update .env jika ada config baru
- [ ] Set permission file (755 untuk folder, 644 untuk file)

### **Setelah Update:**
- [ ] Test website berfungsi normal
- [ ] Test fitur yang di-update
- [ ] Clear browser cache
- [ ] Cek error log (jika ada)

---

## 🚨 Troubleshooting

### **Error: File Permission Denied**
```
Solusi:
- Set folder permission: 755
- Set file permission: 644
- Storage folder: 775
```

### **Error: Database Connection Failed**
```
Solusi:
- Cek .env file
- Pastikan database credentials benar
- Test connection via phpMyAdmin
```

### **Error: White Screen**
```
Solusi:
- Cek error log di cPanel
- Pastikan semua file ter-upload
- Clear cache
- Cek .env configuration
```

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

4. **Dokumentasi Perubahan**
   - Catat file apa yang diubah
   - Catat perubahan database
   - Simpan SQL migration

5. **Test di Staging Dulu** (jika ada)
   - Test semua fitur sebelum production
   - Pastikan tidak ada breaking changes





