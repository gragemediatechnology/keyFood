<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../img/logos.svg">
    <title>KeyFood || {{ Route::currentRouteName() }} </title>
    <link rel="stylesheet"
        href="https://rawcdn.githack.com/jipyy/keyFood/94e3005f001914148945e309f555715db94e24f6/public/css/contact-us.css">
</head>

<body>
    <div class="contactUs">
        <div class="title">
            <h2>Contact us</h2>
        </div>
        <div class="box">
            <!-- form -->
            <div class="contact form">
                <h3>Apa masalahmu?
                    <form action="mailto:andikasupriyadi27@gmail.com" method="POST">
                        <div class="formBox">
                            <div class="row50">
                                <div class="inputBox">
                                    <span>Nama Depan</span>
                                    <input type="text" placeholder="Nama depan">
                                </div>
                                <div class="inputBox">
                                    <span>Nama Belakang</span>
                                    <input type="text" placeholder="Nama belakang">
                                </div>
                            </div>

                            <div class="row50">
                                <div class="inputBox">
                                    <span>Email</span>
                                    <input type="text" placeholder="...@gmail.com">
                                </div>
                                <div class="inputBox">
                                    <span>NO Handphome</span>
                                    <input type="text" placeholder="+62 123 456 7890">
                                </div>
                            </div>
                            <div class="row100">
                                <div class="inputBox">
                                    <span>Pesan</span>
                                    <textarea placeholder="Ketik pesan disini..."></textarea>
                                </div>
                            </div>
                            <div class="row100">
                                <div class="inputBox">
                                    <input type="submit" value="Kirim">
                                </div>
                            </div>
                        </div>
                    </form>
            </div>

            <!-- info box -->
            <div class="contact info">
                <h3>Contact Info</h3>
                <div class="infoBox">
                    <div>
                        <span><ion-icon name="pin"></ion-icon></span>
                        <p>Perubahan Kota Baru Keandra, cirebon<br>Indonesia</p>
                    </div>
                    <div>
                        <span><ion-icon name="mail"></ion-icon></span>
                        <a href="mailto:loremipsum@gmail.com">loremipsum@gmail.com</a>
                    </div>
                    <div>
                        <span><ion-icon name="call"></ion-icon></span>
                        <a href="tel:+919876543211">+62 8123456789</a>
                    </div>

                    <!-- social media links -->
                    <ul class="sci">
                        <li><a href="#"><ion-icon name="logo-facebook"></ion-icon></a></li>
                        <li><a href="#"><ion-icon name="logo-twitter"></ion-icon></a></li>
                        <li><a href="#"><ion-icon name="logo-linkedin"></ion-icon></a></li>
                        <li><a href="#"><ion-icon name="logo-instagram"></ion-icon></a></li>
                    </ul>
                </div>
            </div>

            <!-- map -->
            <div class="contact map">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d15848.025922409286!2d108.4574444772461!3d-6.7690625997904945!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1skeandra%20sumber!5e0!3m2!1sid!2sid!4v1721094248618!5m2!1sid!2sid"
                    style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
</body>

</html>
