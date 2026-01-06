1. Deskripsi Project

Rubik Timer merupakan aplikasi web sederhana yang digunakan untuk mencatat dan mengelola waktu penyelesaian permainan Rubik’s Cube.
Aplikasi ini Saya buat sebagai Tugas Ujian Akhir Semester (UAS) Mata Kuliah Pemrograman Web dengan menerapkan konsep Object Oriented Programming (OOP), pemrograman modular, serta routing menggunakan file .htaccess.

Aplikasi ini memiliki sistem autentikasi dengan dua role pengguna, yaitu Admin dan User, serta menyediakan fitur pengelolaan data (CRUD), pencarian, dan pagination.

2. Tujuan Pengembangan

Tujuan dari pengembangan aplikasi ini adalah:

Menerapkan konsep OOP dan struktur MVC sederhana pada PHP

Mengimplementasikan sistem login multi-role

Menerapkan routing aplikasi menggunakan .htaccess

Membuat aplikasi web yang responsif (mobile first)

Memenuhi seluruh ketentuan Project UAS Pemrograman Web

3. Fitur Aplikasi
3.1 Autentikasi

Login
<img width="1919" height="958" alt="image" src="https://github.com/user-attachments/assets/c5f5426c-3b48-403b-85c9-c8f1620f609e" />


Register
<img width="1919" height="957" alt="image" src="https://github.com/user-attachments/assets/5c56b354-8106-427c-9c74-81d31a554646" />

Hak akses berdasarkan role (Admin dan User)

3.2 User

Menambahkan data waktu solve

Melihat daftar waktu solve

Mengubah dan menghapus data solve

Melihat dashboard statistik sederhana
<img width="1919" height="959" alt="image" src="https://github.com/user-attachments/assets/8d09ce1f-b039-45db-9fe2-d2aaae366067" />

3.3 Admin

Mengelola dan melihat seluruh data solve pengguna

Monitoring data melalui halaman admin

3.4 Fitur Pendukung

CRUD (Create, Read, Update, Delete)
<img width="1919" height="959" alt="image" src="https://github.com/user-attachments/assets/3d3f1827-7605-42f2-a0cb-83998110e299" />

Pencarian data

Pagination
<img width="409" height="446" alt="image" src="https://github.com/user-attachments/assets/ed48e75a-4760-4cd6-9953-6d0c3c8e646e" />

Desain responsif berbasis mobile first

4. Teknologi yang Digunakan

Bahasa Pemrograman: PHP (Native)

Database: MySQL

Frontend: HTML, CSS, JavaScript

Framework CSS: Bootstrap 5

Web Server: Apache

Routing: .htaccess

5. Struktur Direktori
/rubik-timer/
│
├── .htaccess                # Konfigurasi routing
├── index.php                # Entry point aplikasi
│
├── config/
│   └── Database.php         # Konfigurasi koneksi database
│
├── controllers/
│   ├── AdminController.php
│   ├── AuthController.php
│   ├── DashboardController.php
│   └── SolveController.php
│
├── models/
│   ├── Solve.php
│   └── User.php
│
├── public/
│   ├── css/
│   │   └── style.css        # Styling aplikasi
│   └── js/
│       └── script.js        # Logika JavaScript
│
├── views/
│   ├── admin/               # Halaman admin
│   ├── auth/                # Halaman login & register
│   ├── dashboard/           # Halaman dashboard user
│   └── layouts/             # Header & footer
│
└── README.md

6. Cara Menjalankan Aplikasi

Clone repository:

git clone https://github.com/sfnayy/rubik-timer.git


Pindahkan folder project ke direktori:

htdocs (XAMPP)


Buat database MySQL dan sesuaikan konfigurasi pada:

config/Database.php


Jalankan Apache dan MySQL

Akses aplikasi melalui browser:

http://localhost/rubik-timer

7. Akun Demo

Admin

Username: superadmin

Password: 123

User

Registrasi melalui halaman register

8. Dokumentasi

 📄 Dokumentasi PDF: https://drive.google.com/file/d/13d1urvKuAseQA8aeyoLlBww4zc2_cAl7/view?usp=sharing

🎥 Video Demo: berupa link YouTube (durasi maksimal 10 menit)

🌐 Link Demo Hosting: https://cubertimer.rf.gd/

9. Penutup

Aplikasi Rubik Timer ini diharapkan dapat memenuhi seluruh ketentuan Project UAS Pemrograman Web.
Pengembangan lebih lanjut masih dapat dilakukan untuk meningkatkan fitur dan tampilan aplikasi.
