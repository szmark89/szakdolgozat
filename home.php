<?php session_start(); ?>
   
    <!-- Hero section -->
    <section id="home" class="hero text-center">
        <div class="container">
            <div class="text-background">
                <h2 class="hero-title">A Nagy Nap Szervezése</h2>
                <p class="hero-subtitle">Minden, amire szükséged lehet, egy helyen!</p>
                <a href="shop.php" data-page="shop"><button class="btn btn-custom mt-3">Fedezd fel a kínálatot</button></a>
            </div>
        </div>
    </section>

    <!-- Bemutatkozó szekció -->
    <section class="about-us py-5">
        <div class="container text-center">
            <h2>Rólunk</h2>
            <p class="lead mt-3">
                Az M. Tailor's Weddings egy olyan esküvőszervező cég, amely elkötelezett amellett, hogy a Nagy Napot tökéletesen megszervezze. Díszek bérlése, vőfély és DJ szolgáltatások – minden, amire szükséged lehet egy emlékezetes esküvőhöz, egy helyen. Tapasztalt csapatunk a legapróbb részletekről is gondoskodik, hogy ti csak a boldog pillanatokra koncentrálhassatok.
            </p>
            <a href="shop.php" data-page="shop" class="btn btn-custom mt-4">Látogass el a webshopunkba</a>
        </div>
    </section>

    <!-- Carousel section -->
    <section id="slider" class="carousel slide slider-custom-height" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#slider" data-slide-to="0" class="active"></li>
            <li data-target="#slider" data-slide-to="1"></li>
            <li data-target="#slider" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="img/slider1.png" class="d-block w-100" alt="Outdoor Wedding Setup">
                <div class="carousel-caption d-none d-md-block caption-bg">
                    <h3>360 Selfie</h3>
                    <p>Menő képek széles látószögben!</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="img/slider2.png" class="d-block w-100" alt="Couple Dancing at Wedding">
                <div class="carousel-caption d-none d-md-block caption-bg">
                    <h3>Videós</h3>
                    <p>Boldog és emlékezetes felvételek!</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="img/slider3.png" class="d-block w-100" alt="Wedding Cake Setup">
                <div class="carousel-caption d-none d-md-block caption-bg">
                    <h3>Vidámság</h3>
                    <p>Mulatás reggeltől estig!</p>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#slider" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Előző</span>
        </a>
        <a class="carousel-control-next" href="#slider" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Következő</span>
        </a>
    </section>

    <!-- Product categories section -->
    <section id="categories" class="product-categories py-5">
        <div class="container">
            <h2 class="text-center">Mit kínálunk?</h2>
            <div class="row">
                <div class="col-md-4 text-center">
                    <div class="category-container">
                        <img src="img/kellékek.jpg" alt="Esküvői kellékek" class="img-fluid category-img">
                        <h3 class="category-text">Esküvői Kellékek</h3>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="category-container">
                        <img src="img/ruhak.jpg" alt="Menyasszonyi ruhák" class="img-fluid category-img">
                        <h3 class="category-text">Esküvői Ruhák</h3>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="category-container">
                        <img src="img/szolgaltatasok.jpg" alt="Szolgáltatások" class="img-fluid category-img">
                        <h3 class="category-text">Szolgáltatások</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services section -->
    <section id="services" class="services py-5">
        <div class="container">
            <h2 class="text-center mb-4">Mi ott leszünk veletek!</h2>
            <div class="row">
                <div class="col-md-6 text-center">
                    <div class="service-wrapper">
                        <img src="img/products/szolgaltatas/ceremoniamester.jpg" alt="Ceremóniamester" class="img-fluid mb-3 service-image">
                    </div>
                    <h3>Ceremóniamester Szolgáltatás</h3>
                    <p>Profi ceremóniamester, aki biztosítja a zökkenőmentes és vidám esküvőt. Vezeti a programot, és gondoskodik a vendégek jó hangulatáról.</p>
                </div>
                <div class="col-md-6 text-center">
                    <div class="service-wrapper">
                        <img src="img/products/szolgaltatas/dj.jpg" alt="DJ" class="img-fluid mb-3 service-image">
                    </div>
                    <h3>DJ Szolgáltatás</h3>
                    <p>Tapasztalt DJ, aki gondoskodik a felejthetetlen hangulatról és a tökéletes zenéről az esküvődön. Garantáltan mindenki táncolni fog!</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Kapcsolat szekció -->
    <section id="contact" class="contact py-5">
        <div class="container text-center">
            <h2>Kapcsolat</h2>
            <p>Kérdéseid vannak? Vedd fel velünk a kapcsolatot az alábbi űrlap segítségével!</p>
            <form>
                <input type="text" placeholder="Név" required>
                <input type="email" placeholder="Email cím" required>
                <textarea placeholder="Üzenet" rows="4" required></textarea>
                <input type="submit" value="Küldés">
            </form>
        </div>
    </section>
    