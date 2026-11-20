# JANJI
Saya Muhammad Syafiq A dengan NIM 2500254 mengerjakan TP 8 dalam mata kuliah Desain dan Pemrograman Berorientasi Objek untuk keberkahanNya maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan. Aamiin

## Struktur File
```
│   bootstrap.bundle.min.js
│   bootstrap.min.css
│   bootstrap.min.js
│   config.php
│   course.php
│   department.php
│   index.php
│   jquery.min.js
│   popper.min.js
│
├───controllers
│       CourseController.php
│       DepartmentController.php
│       LecturerController.php
│
├───database
│       db_akademik.sql
│
├───models
│       Course.php
│       DB.php
│       Department.php
│       Lecturer.php
│
├───templates
│       form.html
│       index.html
│
└───views
        CourseView.php
        DepartmentView.php
        LecturerView.php
        Template.php
```

## Desain Program 
Aplikasi manajemen data akademik ini dibangun dengan menerapkan arsitektur Model-View-Controller (MVC) berbasis PHP natif dan MySQL. Pemisahan kode dibagi menjadi tiga lapisan utama agar pengelolaan logika basis data, alur kendali permintaan, dan tampilan antarmuka berjalan secara modular:

- Lapisan Model (models/): Mengelola koneksi database, sanitasi input, serta eksekusi kueri SQL.

- Lapisan View (views/ & templates/): Mengatur penyajian data ke dalam komponen tabel maupun formulir HTML menggunakan sistem templating sederhana.

- Lapisan Controller (controllers/): Berperan sebagai perantara yang menerima input dari file entry point, meminta pengolahan data ke Model, dan menentukan tampilan yang dikirim kembali ke pengguna.

## Rancangan Basis Data 
Basis data db_akademik terdiri dari tiga tabel yang saling berelasi menggunakan Foreign Key dengan aturan ON DELETE CASCADE dan ON UPDATE CASCADE:

1. departments (Program Studi)

- Atribut: id (Primary Key, Auto Increment), department_name, faculty, accreditation.

  - Peran: Menyimpan data induk mengenai program studi, fakultas asal, dan status akreditasinya.

2. lecturers (Dosen — Tabel Utama)

- Atribut: id (Primary Key, Auto Increment), name, nidn, phone, join_date, department_id (Foreign Key).

  - Relasi: Berelasi Many-to-One ke tabel departments melalui kolom department_id, yang menandakan setiap dosen bernaung di bawah satu program studi.

3. courses (Mata Kuliah)

- Atribut: id (Primary Key, Auto Increment), course_code, course_name, credits, lecturer_id (Foreign Key).

  - Relasi: Berelasi Many-to-One ke tabel lecturers melalui kolom lecturer_id, yang menunjukkan dosen pengampu untuk setiap mata kuliah.


## Alur Kerja Program
Alur eksekusi aplikasi berjalan secara terstruktur mulai dari permintaan pengguna hingga halaman dirender di peramban:

1. Penerimaan Request di Entry Point (index.php, department.php, course.php)

- Pengguna berinteraksi dengan aplikasi melalui URL atau tombol aksi pada antarmuka.
- File entry point memeriksa parameter HTTP yang masuk:
  - Tanpa parameter: memanggil index() untuk menampilkan daftar seluruh data.
  - ?add_form=1: memanggil formAdd() untuk membuka formulir tambah data.
  - ?id_edit=<id>: memanggil formEdit($id) untuk membuka formulir ubah data sesuai ID terpilih.
  - ?id_hapus=<id>: memanggil delete($id) untuk menghapus data dari database.
  - $_POST['add'] / $_POST['update']: memanggil add($_POST) atau update($_POST) untuk menyimpan perubahan data ke database.

2. Pemrosesan Logika di Controller

- Controller membuka koneksi database melalui objek Model, memanggil metode manipulasi atau pengambilan data yang sesuai, lalu menutup koneksi setelah selesai.
- Untuk operasi penulisan data (Create, Update, Delete), Controller melakukan pengalihan halaman (header("location:...")) agar daftar data terbaru langsung dimuat.
- Untuk operasi pembacaan data (Read dan tampilan form), Controller mengambil data relasi tambahan jika diperlukan (misalnya daftar program studi untuk dropdown dosen, atau daftar dosen untuk dropdown mata kuliah) lalu meneruskannya ke View.

3. Eksekusi Kueri di Model

- Model mengeksekusi perintah SQL ke server MySQL. Khusus pada Lecturer dan Course, pengambilan seluruh data menggunakan perintah JOIN agar nama program studi maupun nama dosen pengampu dapat langsung ditampilkan alih-alih sekadar angka ID.

4. Penyusunan Antarmuka di View & Template

- View mengubah larik (array) data dari Controller menjadi baris-baris tabel (<tr>...</tr>) atau elemen pilihan (<option>...</option>).
- Kelas Template membaca kerangka statis dari templates/index.html atau templates/form.html, mengganti seluruh placeholder (seperti PAGE_TITLE, TABLE_HEADER, TABLE_BODY, dan FORM_FIELDS), lalu mencetak hasil akhir HTML ke layar.


## Penjelasan Class

1. Layer Controllers (controllers/)
- DepartmentController (controllers/DepartmentController.php): Mengatur alur CRUD untuk entitas program studi dengan menghubungkan model Department dan tampilan DepartmentView melalui metode index(), formAdd(), formEdit(), add(), update(), dan delete().
- LecturerController (controllers/LecturerController.php): Mengatur alur CRUD entitas dosen dengan mengoordinasikan model Lecturer, model Department (sebagai sumber data dropdown), dan LecturerView.
- CourseController (controllers/CourseController.php): Mengatur alur CRUD entitas mata kuliah dengan mengoordinasikan model Course, model Lecturer (sebagai sumber data dropdown pengampu), dan CourseView.

2. Layer Models (models/)
- DB (models/DB.php): Kelas induk yang menyediakan layanan dasar koneksi MySQL, meliputi pembukaan koneksi (open()), eksekusi kueri (execute()), pengambilan baris hasil (getResult()), sanitasi string input (escape()), serta penutupan koneksi (close()).
- Department (models/Department.php): Kelas turunan DB yang menangani operasi CRUD pada tabel departments melalui metode getDepartment(), getDepartmentById(), add(), update(), dan delete().
- Lecturer (models/Lecturer.php): Kelas turunan DB yang mengelola data tabel lecturers. Metode getLecturer() menjalankan kueri JOIN dengan tabel departments untuk memperoleh nama program studi dan fakultas dosen.
- Course (models/Course.php): Kelas turunan DB yang mengelola data tabel courses. Metode getCourse() menjalankan kueri JOIN dengan tabel lecturers untuk menampilkan nama dosen pengampu mata kuliah.

3. Layer Views (views/)
- Template (views/Template.php): Mesin templating sederhana yang memuat berkas HTML mentah, mengganti penanda teks menggunakan replace(), dan menampilkannya ke peramban lewat metode write().
- DepartmentView (views/DepartmentView.php): Menyusun tampilan daftar program studi (render()) serta formulir tambah/ubah program studi (renderForm()).
- LecturerView (views/LecturerView.php): Menyusun tabel daftar dosen (render()) dan formulir input dosen (renderForm()) yang dilengkapi elemen `<select>` untuk memilih program studi.
- CourseView (views/CourseView.php): Menyusun tabel daftar mata kuliah beserta jumlah SKS (render()) serta formulir input mata kuliah (renderForm()) dengan pilihan dropdown dosen pengampu.

## Dokumentasi

https://github.com/user-attachments/assets/33ca5661-8ca2-4fc9-9467-ffe259fd9ab4

