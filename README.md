# Sistem Manajemen & Peminjaman Ruang Meeting
### PT Medquest Jaya Global

Sistem terintegrasi pengelolaan dan reservasi ruang meeting internal **PT Medquest Jaya Global**. Dirancang untuk menertibkan jadwal agenda kantor, mencegah bentrok jadwal rapat, mengoptimalkan utilisasi ruangan secara transparan, serta meningkatkan kedisiplinan kehadiran meeting melalui integrasi verifikasi check-in berbasis QR Code dan pembatalan otomatis (*auto-cancel*).

---

## 🌟 Fitur Unggulan Sistem

1. **Struktur Hak Akses 3 Level Terintegrasi**:
   - **Admin (General Affairs / IT)**: Pengelolaan penuh master data ruangan, manajemen akun pengguna, pemantauan dashboard analitik eksekutif, dan pembatalan darurat.
   - **Resepsionis / Front Desk (Operator)**: Verifikasi persetujuan (*Approve*) & penolakan (*Reject*) pengajuan, monitoring check-in langsung, penyelesaian meeting, dan cetak rekapitulasi laporan resmi. Tidak memiliki akses ke data akun user atau CRUD ruangan.
   - **Pengguna (Karyawan / Pemohon)**: Pengecekan ketersediaan slot secara mandiri (*self-booking*), riwayat agenda meeting pribadi, dan sinkronisasi ke kalender kerja.

2. **Toleransi Check-In 10 Menit & Auto-Release Slot**:
   - Wajib konfirmasi kehadiran (Check-In) mulai dari jam jadwal meeting hingga batas maksimal 10 menit.
   - **Auto-Cancel**: Jika tidak ada yang melakukan check-in dalam 10 menit, sistem secara otomatis membatalkan peminjaman dan membebaskan slot ruangan untuk digunakan oleh rekan kerja lain yang membutuhkan.
   - Pilihan metode check-in: **1-Click Web Check-In** di Data Peminjaman atau **Scan QR Code Permanen** yang terpasang di depan pintu ruangan.

3. **Integrasi Kalender Kerja (Google Calendar & Outlook)**:
   - Satu klik untuk menyinkronkan agenda yang telah disetujui langsung ke **Google Calendar** atau mengunduh file standar vCalendar (`.ics`) untuk **Microsoft Outlook** dan **Apple Calendar**.

4. **Laporan & Ekspor Data Resmi**:
   - **Ekspor Excel (`.csv` / `.xls`)**: Dilengkapi UTF-8 BOM dan format `sep=;` sehingga otomatis terbagi rapi ke dalam kolom Microsoft Excel tanpa kendala karakter.
   - **Cetak Laporan / PDF**: Pratinjau cetak resmi ber-Kop Surat PT Medquest Jaya Global, tabel agenda lengkap, serta kolom tanda tangan pengesahan Petugas Resepsionis dan General Affairs.

5. **Dasbor Analitik & Utilisasi (Khusus Admin)**:
   - **Frekuensi Utilisasi Ruangan**: Bar chart visual utilisasi per ruang (Pulau Jawa, Bali, Papua, Sumatra, Kalimantan).
   - **KPI Tingkat Kehadiran**: Donut chart SVG interaktif yang menampilkan persentase on-time check-in vs agenda yang dibatalkan.
   - **Top 5 Departemen Teraktif**: Pemetaan departemen yang paling produktif mengadakan meeting.

6. **Buku Panduan Interaktif Terpasang (In-App User Manual)**:
   - Menu panduan SOP lengkap terintegrasi pada sistem di URL `dashboard/panduan` atau melalui menu dropdown profil pengguna.
   - Dilengkapi tombol cetak / simpan langsung ke PDF untuk orientasi karyawan baru.

---

## 👥 Akun Uji Coba (Demo Credentials)

Untuk pengujian seluruh alur skenario aplikasi, gunakan akun bawaan berikut:

| Level Akses | Username | Password | Nama Lengkap | Tugas & Hak Akses |
| :--- | :--- | :--- | :--- | :--- |
| **Admin** | `ryan` | `123123` | Ryan (Administrator) | Kelola data ruang, user, lihat analitik, & setujui agenda. |
| **Resepsionis** | `operator` | `123123` | Operator Resepsionis | Persetujuan meeting, verifikasi check-in, & cetak laporan. |
| **Pengguna** | `nawal` | `123123` | Nawwal Fadhil | Karyawan untuk booking slot & ekspor jadwal kalender. |

---

## 🏢 Daftar Ruang Meeting Bawaan

| ID | Nama Ruang Meeting | Kapasitas | Fasilitas Bawaan |
| :--- | :--- | :--- | :--- |
| **R001** | Pulau Jawa | 5 Orang | Smart TV, Whiteboard, Video Conference |
| **R002** | Pulau Bali | 6 Orang | Smart TV, Whiteboard, Video Conference |
| **R003** | Pulau Papua | 20 Orang | Smart Board, Mic Wireless, Sound System |
| **R004** | Pulau Sumatra | 30 Orang | Proyektor Laser, Dual Screen, VC System |
| **R005** | Pulau Kalimantan | 7 Orang | Smart TV, Whiteboard, High-Speed Wi-Fi |

---

## 🚀 Panduan Instalasi & Menjalankan Aplikasi

### Persyaratan Sistem:
- **Web Server**: Apache 2.4+ (Laragon / XAMPP)
- **PHP**: PHP 7.4 s/d PHP 8.3
- **Database**: MySQL 5.7+ / MySQL 8.x / MariaDB 10.4+

### Langkah-Langkah:
1. Tempatkan folder proyek di direktori web server:
   - Laragon: `C:\laragon\www\medquest-room-meet-integration`
   - XAMPP: `C:\xampp\htdocs\medquest-room-meet-integration`
2. Buka HeidiSQL / phpMyAdmin / MySQL CLI, lalu buat database baru:
   ```sql
   CREATE DATABASE db_pinjamkelas;
   ```
3. Impor skema dan data database terbaru yang berada di:
   ```text
   assets/db/db_pinjamkelas_medquest_v2.sql
   ```
4. Pastikan konfigurasi database di `developments/application/config/database.php` sesuai dengan koneksi lokal Anda:
   ```php
   'hostname' => 'localhost',
   'username' => 'root',
   'password' => '',
   'database' => 'db_pinjamkelas',
   ```
5. Buka peramban (browser) dan akses alamat:
   ```text
   http://localhost/medquest-room-meet-integration/
   ```

---

## 📖 Alur Pengoperasian Ringkas (SOP)

```
[ Karyawan / Pengguna ]
   └── Buka Ketersediaan Ruangan -> Pilih Tanggal & Slot -> Kirim Pengajuan
                                      │
[ Resepsionis / Operator ]           ▼
   └── Terima Notifikasi -> Review Detail -> Klik [Setujui] atau [Tolak]
                                      │
[ Hari Pertemuan / H-Day ]           ▼
   └── Peminjam Datang -> Check-In (Web Button / Scan QR Ruangan)
         ├── Jika Check-In <= 10 Menit  ──> Meeting Berjalan Resmi [Checked-In]
         └── Jika Tidak Hadir > 10 Menit ──> [Batal Otomatis / Slot Bebas Kembali]
                                      │
[ Pasca Pertemuan / Selesai ]        ▼
   └── Resepsionis/Admin [Selesaikan] -> Ekspor Laporan Resmi (Excel / PDF)
```

---

## 🔒 Keamanan & Pembaruan

- **Enkripsi Password**: Menggunakan `password_hash()` standar industri (Bcrypt).
- **Proteksi CSRF**: Dilengkapi token proteksi Cross-Site Request Forgery pada setiap formulir POST.
- **SQL Injection Prevention**: Menggunakan Query Builder / Active Record CodeIgniter dengan parameter binding.
- **Sanitasi Output**: Seluruh string nama peminjam, departemen, dan keterangan diamankan menggunakan `htmlspecialchars()`.

---

© 2026 **PT Medquest Jaya Global** · *Healthcare & Medical Equipment Solutions*
