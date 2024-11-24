<!-- Webshop tartalom -->
<section class="shop-section py-5">
    <div class="container">
        <h2 class="text-center mb-5">Válogasson kedvére termékeink/szolgáltatásaink közül!</h2>
        
        <!-- Keresési mező -->
        <div class="search-bar mb-4">
            <input type="text" class="form-control" id="searchInput" placeholder="Keresés a termékek között...">
        </div>

        <!-- Szűrés kategóriák szerint -->
        <div class="filter-bar mb-4">
            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                <label class="btn btn-secondary active">
                    <input type="radio" name="category" id="all" autocomplete="off" checked> Összes
                </label>
                <label class="btn btn-secondary">
                    <input type="radio" name="category" id="ruha" autocomplete="off"> Ruhák
                </label>
                <label class="btn btn-secondary">
                    <input type="radio" name="category" id="kiegeszito" autocomplete="off"> Kiegészítők
                </label>
                <label class="btn btn-secondary">
                    <input type="radio" name="category" id="szolgaltatas" autocomplete="off"> Szolgáltatások
                </label>
            </div>
        </div>

        <!-- Termékek megjelenítése -->
        <div class="row" id="productGrid">
            <!-- JavaScript tölti be ide a termékeket -->
        </div>
    </div>
</section>

<script src="shop.js"></script>