@echo off
echo ====================================================
echo   Sistem Peminjaman Ruang Meeting PT Medquest Jaya Global
echo ====================================================
echo Menjalankan server PHP lokal di http://localhost:8000
echo Tekan Ctrl+C untuk menghentikan server.
echo.

set PATH=C:\laragon\bin\php\php-8.3.36-Win32-vs16-x64;%PATH%
"C:\laragon\bin\php\php-8.3.36-Win32-vs16-x64\php.exe" -S localhost:8000 server.php
pause
