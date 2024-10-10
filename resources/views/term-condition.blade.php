<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://rawcdn.githack.com/jipyy/keyFood/94e3005f001914148945e309f555715db94e24f6/public/css/terms.css">
    <script src="https://kit.fontawesome.com/3ef3559250.js" crossorigin="anonymous"></script>
    <link rel="icon" type="image/x-icon" href="../img/logos.svg">
    <title>KeyFood || {{ Route::currentRouteName() }} </title>
</head>

<body>

    <section class="flex_center">
        <div class="tc_main">
            <div class="tc_content">
                <div class="tc_top">
                    <div class="icon">
                        <i class="fa-solid fa-clipboard"></i>
                    </div>
                    <div class="title">
                        <p>Terms & Conditions</p>
                    </div>
                    <div class="info">
                        Selamat datang di KeyFood! Kami sangat senang Anda mengunjungi dan menggunakan layanan kami.
                        Berikut adalah syarat dan ketentuan yang mengatur penggunaan situs web dan layanan KeyFood.
                        Dengan mengakses atau menggunakan situs web kami, Anda setuju untuk mematuhi dan terikat oleh
                        syarat dan ketentuan berikut:
                    </div>

                    <div class="tc_bottom">
                        <div class="title">
                            <p>Harap baca syarat dan ketentuan ini sebelum menerima.</p>
                        </div>
                        <div class="info">
                            <h3>1. Penerimaan Syarat dan Ketentuan</h3>
                            <p>Dengan mengakses dan menggunakan situs web KeyFood, Anda setuju untuk mematuhi syarat dan
                                ketentuan ini. Jika Anda tidak setuju dengan syarat dan ketentuan ini, harap jangan
                                menggunakan situs web kami.</p>
                            <br>
                            <h3>2. Perubahan Syarat dan Ketentuan</h3>
                            <p>KeyFood berhak untuk mengubah atau memperbarui syarat dan ketentuan ini kapan saja tanpa
                                pemberitahuan terlebih dahulu. Perubahan tersebut akan efektif segera setelah
                                dipublikasikan di situs web kami. Anda disarankan untuk secara berkala memeriksa halaman
                                ini untuk mengetahui perubahan terbaru.</p>
                            <br>
                            <h3>3. Pendaftaran dan Akun</h3>
                            <p>Untuk menggunakan beberapa layanan di KeyFood, Anda mungkin perlu mendaftar dan membuat
                                akun. Anda setuju untuk memberikan informasi yang akurat, lengkap, dan terbaru selama
                                proses pendaftaran.</p>
                            <p>Anda bertanggung jawab untuk menjaga kerahasiaan informasi akun Anda, termasuk kata sandi
                                Anda, dan bertanggung jawab penuh atas semua aktivitas yang terjadi di akun Anda.</p>
                            <br>
                            <h3>4. Pembelian dan Pembayaran</h3>
                            <p>Semua pembelian produk di KeyFood harus dilakukan melalui situs web kami. Harga dan
                                ketersediaan produk dapat berubah sewaktu-waktu tanpa pemberitahuan.</p>
                            <p>Kami menerima berbagai metode pembayaran yang disebutkan di situs web kami. Anda setuju
                                untuk membayar semua biaya yang terkait dengan pembelian Anda, termasuk pajak dan biaya
                                pengiriman jika ada.</p>
                            <br>
                            <h3>5. Pengiriman dan Pengembalian</h3>
                            <p>Kami berusaha untuk mengirimkan pesanan Anda tepat waktu sesuai dengan estimasi
                                pengiriman yang disebutkan di situs web kami. Namun, kami tidak bertanggung jawab atas
                                keterlambatan pengiriman yang disebabkan oleh faktor di luar kendali kami.</p>
                            <p>Jika Anda menerima produk yang rusak atau tidak sesuai dengan pesanan Anda, harap segera
                                hubungi layanan pelanggan kami untuk proses pengembalian atau penggantian.</p>
                            <br>
                            <h3>6. Kewajiban Pengguna</h3>
                            <p>Anda setuju untuk tidak menggunakan situs web kami untuk tujuan yang melanggar hukum atau
                                tidak sah.</p>
                            <p>Anda tidak diperbolehkan untuk mengunggah, mengirim, atau menyebarkan konten yang
                                mengandung virus, malware, atau kode berbahaya lainnya.</p>
                            <br>
                            <h3>7. Privasi</h3>
                            <p>Privasi Anda penting bagi kami. Silakan baca Kebijakan Privasi kami untuk informasi lebih
                                lanjut tentang bagaimana kami mengumpulkan, menggunakan, dan melindungi informasi
                                pribadi Anda.</p>
                            <br>
                            <h3>8. Batasan Tanggung Jawab</h3>
                            <p>KeyFood tidak bertanggung jawab atas kerugian atau kerusakan yang timbul dari penggunaan
                                atau ketidakmampuan untuk menggunakan situs web kami. Kami tidak memberikan jaminan
                                bahwa situs web kami akan bebas dari kesalahan atau gangguan.</p>
                            <br>
                            <h3>9. Hak Kekayaan Intelektual</h3>
                            <p>Semua konten yang terdapat di situs web KeyFood, termasuk teks, gambar, logo, dan grafik,
                                adalah milik KeyFood dan dilindungi oleh undang-undang hak cipta. Anda tidak
                                diperbolehkan untuk menyalin, mendistribusikan, atau menggunakan konten tersebut tanpa
                                izin tertulis dari kami.</p>
                            <br>
                            <h3>10. Kontak</h3>
                            <p>Jika Anda memiliki pertanyaan atau masalah terkait dengan syarat dan ketentuan ini,
                                silakan hubungi kami melalui informasi kontak yang tersedia di situs web kami.</p>
                        </div>
                    </div>

                </div>
                <div class="tc_btns">
                    <button class="accept" onclick="window.history.back();">
                        Accept
                    </button>
                    <form method="POST" action="/logout" style="display: inline-flex">
                        @csrf
                        <a href="/logout" onclick="event.preventDefault();
this.closest('form').submit();">
                            <button class="decline">
                                Decline
                            </button>
                        </a>
                    </form>
                </div>
            </div>
    </section>
</body>

</html>
