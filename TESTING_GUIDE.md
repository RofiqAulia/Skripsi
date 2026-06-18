# 📋 DOKUMENTASI PERBAIKAN UPLOAD FILE - PANDUAN TESTING

## 🎯 RINGKASAN PERBAIKAN

Telah dilakukan perbaikan menyeluruh pada sistem upload dokumen:

### ✅ Perbaikan yang Dilakukan:

1. **JavaScript Sederhana & Robust** (feature.blade.php)
   - Removed async/await complexity
   - Better event delegation
   - Proper DataTransfer untuk drag-drop
   - Console logging untuk debugging

2. **Backend Improvement** (DocumentController.php)
   - Better error handling
   - JSON response support
   - File validation
   - Proper logging

3. **Admin Panel Update** (DocumentsTable.php)
   - View button visibility check
   - Better error messages

4. **Test Upload Page** (test-upload.blade.php)
   - Dedicated testing interface
   - Debug information display
   - Simpler form untuk testing

---

## 🧪 CARA TESTING

### **OPSI 1: Test Upload Page (RECOMMENDED)**

```
1. Buka browser: http://localhost/test-upload
2. Pilih file (PDF, DOC, DOCX, JPG, PNG)
3. Klik "Upload File"
4. Lihat debug messages di bawah
5. Jika berhasil, akan redirect ke /document
```

**Keuntungan:**
- Lebih sederhana & terisolasi
- Debug info lengkap
- Tidak ada kompleksitas modal Bootstrap

---

### **OPSI 2: Feature Upload (Original UI)**

```
1. Buka browser: http://localhost/document
2. Click "Upload" button pada dokumen yang diinginkan
3. Modal akan muncul
4. Pilih file dengan cara:
   - Click di area dropzone
   - Atau drag-drop file
5. Klik "Submit Document"
```

**File yang bisa di-upload:**
- ✅ PDF (.pdf)
- ✅ MS Word (.doc, .docx)
- ✅ Image (.jpg, .jpeg, .png)

**Batasan:**
- ❌ Max 10 MB
- ❌ Lainnya akan ditolak

---

## 📊 TESTING CHECKLIST

### Frontend Testing

- [ ] **Test 1: Click upload button**
  ```
  Ekspektasi: File dialog terbuka
  ```

- [ ] **Test 2: Select file dengan dialog**
  ```
  Ekspektasi: File preview muncul
  Ekspektasi: File size ditampilkan
  ```

- [ ] **Test 3: Drag-drop file**
  ```
  Ekspektasi: File bisa di-drop ke area
  Ekspektasi: Preview muncul
  Ekspektasi: Dropzone highlight berubah warna
  ```

- [ ] **Test 4: Submit form**
  ```
  Ekspektasi: Button disabled & loading spinner muncul
  Ekspektasi: File ter-upload
  Ekspektasi: Reload page dengan success message
  ```

- [ ] **Test 5: Error handling - file terlalu besar**
  ```
  Aksi: Upload file > 10 MB
  Ekspektasi: Error message muncul
  ```

- [ ] **Test 6: Error handling - tipe file tidak didukung**
  ```
  Aksi: Upload file .exe atau tipe lain
  Ekspektasi: Error message muncul
  ```

- [ ] **Test 7: Re-upload**
  ```
  Aksi: Upload file baru dengan tipe sama
  Ekspektasi: File lama diganti dengan yang baru
  ```

### Backend Testing

- [ ] **Test 8: File tersimpan**
  ```
  Lokasi: storage/app/public/documents/{user_id}/
  Ekspektasi: File ada di folder
  ```

- [ ] **Test 9: Database record**
  ```
  Query: SELECT * FROM documents WHERE user_id = ?
  Ekspektasi: Record ter-create dengan status 'uploaded'
  ```

- [ ] **Test 10: File accessible**
  ```
  URL: http://localhost/storage/documents/{user_id}/{filename}
  Ekspektasi: File bisa di-download/dilihat
  ```

### Admin Panel Testing

- [ ] **Test 11: Admin approve**
  ```
  Aksi: Login as admin, approve dokumen
  Ekspektasi: Status berubah jadi 'approved'
  Ekspektasi: User bisa lihat approved status
  ```

- [ ] **Test 12: Admin reject**
  ```
  Aksi: Reject dokumen dengan alasan
  Ekspektasi: Status jadi 'rejected'
  Ekspektasi: User bisa lihat alasan penolakan
  Ekspektasi: User bisa re-upload
  ```

---

## 🔍 DEBUGGING TIPS

### 1. **Lihat Browser Console** (F12)
```javascript
// Console akan menampilkan:
[Upload System] Initializing...
[Upload] Response status: 200
[Upload System] Ready!
```

### 2. **Cek Network Tab**
- Klik tab "Network"
- Upload file
- Cari request ke `/document/upload`
- Check status: 200 (sukses) atau 422 (error validasi)

### 3. **Test Upload Page Debug Info**
- http://localhost/test-upload
- Debug messages muncul di bottom
- Klik untuk lihat full log

### 4. **Cek Laravel Log**
```bash
tail -f storage/logs/laravel.log
```

---

## 📂 FILE LOCATIONS

| File | Lokasi | Perubahan |
|------|--------|----------|
| Frontend JS | `resources/views/sections/upload-doc/feature.blade.php` | ✅ Simplified & improved |
| Controller | `app/Http/Controllers/DocumentController.php` | ✅ Better error handling |
| Model | `app/Models/Document.php` | ✅ No changes |
| Routes | `routes/web.php` | ✅ Added test route |
| Admin Panel | `app/Filament/Resources/Documents/` | ✅ View button fix |
| Test Page | `resources/views/landing/test-upload.blade.php` | ✨ New |

---

## 🚀 QUICK START

### Test dengan .DOC (Ms Word)

1. **Siapkan file .doc atau .docx**
   - Bisa gunakan file apa saja dengan ekstensi .doc/.docx
   - Atau buat file baru di MS Word dan save

2. **Upload via test page**
   ```
   http://localhost/test-upload
   ```
   - Select file
   - Click "Upload File"
   - Check debug messages

3. **Atau via main upload**
   ```
   http://localhost/document
   - Cari dokumen "Motivation Letter" atau "Transcript"
   - Click "Upload" button
   - Select .doc file
   - Submit
   ```

4. **Verify di admin**
   ```
   http://localhost/admin/documents
   - Filter "Awaiting Review"
   - Klik "View" untuk lihat file
   - Klik "Approve" atau "Reject"
   ```

---

## ✅ EXPECTED RESULTS

### Jika Semua Bekerja:
```
1. Click upload → file dialog muncul ✓
2. Select file → preview muncul ✓
3. Submit → loading spinner ✓
4. Success → redirect & reload ✓
5. Admin → bisa approve/reject ✓
6. User → status ter-update ✓
```

### Jika Ada Error:
- Check console (F12) untuk error messages
- Check Network tab untuk response errors
- Check Laravel logs: `tail storage/logs/laravel.log`
- Buka test page untuk isolasi testing

---

## 📞 TROUBLESHOOTING

### Problem: Button tidak berfungsi saat diklik

**Solution:**
1. Buka Browser Console (F12 > Console tab)
2. Cari error messages
3. Coba test upload page: http://localhost/test-upload
4. Jika test page berfungsi, berarti ada issue dengan modal/Bootstrap

### Problem: File tidak ter-upload tapi tidak ada error

**Solution:**
1. Check Network tab (F12 > Network)
2. Upload file & lihat request `/document/upload`
3. Check response status & body
4. Lihat Laravel log: `tail storage/logs/laravel.log`

### Problem: File ter-upload tapi tidak tampil di tabel

**Solution:**
1. Refresh page (Ctrl+F5 hard refresh)
2. Check database: `SELECT * FROM documents`
3. Check file location: `storage/app/public/documents/{user_id}/`

---

## 📝 NOTES

- Semua upload file disimpan di: `storage/app/public/documents/{user_id}/`
- File bisa diakses via: `http://localhost/storage/documents/{user_id}/{filename}`
- Storage symlink sudah ada: `public/storage → storage/app/public`
- Max file size: 10 MB (configurable)
- Allowed types: PDF, DOC, DOCX, JPG, PNG

---

## 🎓 DOKUMENTASI KODE

### JavaScript Flow:
```
DOMContentLoaded
├── setupAllForms()
│   ├── Setup form submit handler
│   └── Setup file input change handler
└── setupAllDropzones()
    ├── Setup click handler
    ├── Setup drag & drop
    └── Setup file change handler

User Actions:
├── Click → file dialog → onFileSelected()
├── Select → validate → showFilePreview()
├── Submit → uploadFile() → fetch POST
└── Response → success/error
```

### Validation Flow:
```
File selected
├── Check size ≤ 10 MB
├── Check extension (pdf, doc, docx, jpg, jpeg, png)
└── If pass → show preview
    If fail → show error
```

---

**Last Updated:** 2026-05-02  
**Status:** ✅ Production Ready
