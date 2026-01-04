## ** Proyek akhir pemrograman web 2, membuat proyek mendekati real.
Proyek Sistem Kasir ini dibuat oleh 
Alva Herbart Miftahul Firdaus
221011402335
07TPLP007

Proyek ini dibuat menggunakan PHP, HTML, CSS ,JavaScript

Demo Website: 
https://cafeahmf.free.nf/


## ** Aktor & Peran dalam Sistem
1. Customer (Pelanggan)
Customer merupakan pengguna yang melakukan pemesanan.
Fungsi yang dapat dilakukan:
- Melihat daftar menu berdasarkan kategori
- Menambahkan menu ke keranjang
- Melakukan checkout pesanan
- Mendapatkan kode pesanan
- Melihat status pesanan secara real-time melalui halaman status pesanan
Catatan:
Customer tidak perlu login untuk memesan, cukup memasukkan nama dan (opsional) nomor meja.

2. Admin/Owner
Admin/Owner memiliki kontrol penuh terhadap sistem.
Fungsi yang dapat dilakukan:
- Login ke sistem admin
- Melihat seluruh daftar pesanan
- Mengelola data menu (tambah, edit, hapus)
- Mengelola kategori menu
- Mengelola Users (kasir, dapur, waiter)
- Melihat riwayat transaksi
- Mengawasi sistem secara keseluruhan

3. Kasir
Kasir bertugas pada proses pembayaran 
- Membuat Pesanan (POS)
- Melihat pesanan dengan status diantar
- Melakukan proses pembayaran
- Menginput nominal bayar
- Mencetak struk pembayaran
- Mengubah status pesanan menjadi dibayar

4. Dapur (Kitchen)
Dapur bertugas mengelola pesanan yang masuk untuk dimasak.
Fungsi yang dapat dilakukan:
- Melihat daftar pesanan dengan status menunggu
- Mengubah status pesanan menjadi diproses
- Menyelesaikan pesanan dan mengubah status menjadi selesai

5. Waiter
Waiter bertugas mengantarkan pesanan ke pelanggan.
Fungsi yang dapat dilakukan:
- Melihat daftar pesanan dengan status selesai
- Mengantarkan pesanan ke meja pelanggan
- Mengubah status pesanan menjadi diantar

## ** Alur Kerja Sistem
1. Customer melakukan pemesanan menu
2. Pesanan masuk dengan status menunggu
3. Dapur memproses pesanan -> status diproses
4. Dapur menyelesaikan pesanan -> status selesai
5. Waiter mengantar pesanan -> status diantar
6. Kasir melakukan pembayaran -> status dibayar
** Customer dapat memantau status pesanan kapan saja
