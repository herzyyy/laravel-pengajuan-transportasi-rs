# Laravel Scheduler - Auto Reject Expired Requests

## Deskripsi
Sistem ini secara otomatis mengubah status pengajuan transportasi yang masih berstatus "diajukan" menjadi "kadaluarsa" jika sudah melewati waktu transportasi yang diajukan.

## Command Manual
Untuk menjalankan command secara manual:
```bash
php artisan transport:auto-reject-expired
```

## Scheduler Otomatis
Command ini sudah dijadwalkan untuk berjalan otomatis setiap jam melalui Laravel Scheduler.

### Cara Mengaktifkan Scheduler (Production)

#### Windows
Tambahkan task di Windows Task Scheduler:
1. Buka Task Scheduler
2. Create Basic Task
3. Trigger: Daily, repeat every 1 hour
4. Action: Start a program
5. Program: `php`
6. Arguments: `E:\TugasKuliah\MagangRSAzra\laravel-transportasi-rsazra\artisan schedule:run`
7. Start in: `E:\TugasKuliah\MagangRSAzra\laravel-transportasi-rsazra`

Atau gunakan command ini di Command Prompt (Run as Administrator):
```cmd
schtasks /create /tn "Laravel Scheduler" /tr "php E:\TugasKuliah\MagangRSAzra\laravel-transportasi-rsazra\artisan schedule:run" /sc minute /mo 1
```

#### Linux/Mac
Tambahkan cron job:
```bash
crontab -e
```

Tambahkan baris ini:
```
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

## Status yang Digunakan
- **diajukan**: Pengajuan baru yang menunggu persetujuan
- **diproses**: Pengajuan yang sudah disetujui
- **digunakan**: Kendaraan sedang digunakan
- **selesai**: Transportasi selesai
- **ditolak**: Pengajuan ditolak oleh admin
- **kadaluarsa**: Pengajuan yang terlewat waktu (otomatis)

## Cara Kerja
1. Command berjalan setiap jam (atau manual)
2. Mencari semua pengajuan dengan status "diajukan"
3. Membandingkan tanggal + jam pengajuan dengan waktu sekarang
4. Jika sudah lewat, status diubah menjadi "kadaluarsa"
5. Log ditampilkan untuk setiap pengajuan yang diubah

## Testing
Untuk testing, jalankan command manual:
```bash
php artisan transport:auto-reject-expired
```

Output akan menampilkan:
- Daftar pengajuan yang diubah statusnya
- Total pengajuan yang kadaluarsa
- Atau pesan "Tidak ada pengajuan yang kadaluarsa" jika tidak ada
