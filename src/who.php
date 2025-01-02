
<?php $pg='who'; include("top.php");?>

<body class="d-flex h-100 text-bg-light">
    <div class="d-flex w-100 h-100 py-3 px-4 mx-auto flex-column">
    <?php include("menu.php");?>
    <div class="container my-5">
        <div class="row text-center">
            <p>It would be weird if you've been invited to our wedding and don't know who we are, but just in case here's a bit about each of us:</p>
        </div>
        <div class="row">
            <div class="col text-end">
                <p>Text about Sara</p>
            </div>
            <div class="col-4">
                <img src="/images/engagement.jpg" class="img-fluid" alt="..." style="border-radius: var(--bs-border-radius)">
            </div>
            <div class="col text-start">
                <p>Text about Adam</p>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js" integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous" async></script>

        <div class="row my-5">
            <h4>Meet the wedding party:</h4>
        </div>
        <div class="row py-2" data-masonry='{"percentPosition": true }'>
            <div class="card profile-card">
                <img src="https://upload.wikimedia.org/wikipedia/commons/a/ac/Default_pfp.jpg?20200418092106" class="card-img-top" alt="...">
                <div class="card-body">
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
            </div>

            <div class="card profile-card">
                <img src="https://upload.wikimedia.org/wikipedia/commons/a/ac/Default_pfp.jpg?20200418092106" class="card-img-top" alt="...">
                <div class="card-body">
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
            </div>

            <div class="card profile-card">
                <img src="https://upload.wikimedia.org/wikipedia/commons/a/ac/Default_pfp.jpg?20200418092106" class="card-img-top" alt="...">
                <div class="card-body">
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
            </div>


            <div class="card profile-card">
                <img src="https://upload.wikimedia.org/wikipedia/commons/a/ac/Default_pfp.jpg?20200418092106" class="card-img-top" alt="...">
                <div class="card-body">
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
            </div>

            <div class="card profile-card">
                <img src="https://upload.wikimedia.org/wikipedia/commons/a/ac/Default_pfp.jpg?20200418092106" class="card-img-top" alt="...">
                <div class="card-body">
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
            </div>

        </div>
    </div>

<?php include("bottom.php");?>