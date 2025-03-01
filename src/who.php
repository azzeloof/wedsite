
<?php $pg='who'; include("top.php");?>

<body class="d-flex h-100 text-bg-light">
    <div class="d-flex w-100 h-100 py-3 px-4 mx-auto flex-column">
    <?php include("menu.php");?>
    <div class="container my-5">
        <div class="row text-center">
            <p>It would be weird if you've been invited to our wedding and don't know who we are, but just in case here's a bit about each of us. If you can't tell, we wrote one another's.</p>
        </div>
        <div class="row">
            <div class="col text-end">
                <h3>Sara Adkins</h3>
                <p>is a machine learning researcher, software engineer, and musician. She is a classically-trained guitarist and violist, and often performs experimental music sets incorporating live coding, generative AI, and conventional instruments.</p>
                <p>She loves playing tabletop games like Dungeons and Dragons, board games, and videogames (especially Pokemon, hence the Pokeball ring box). She's also a knitter, runner, and traveler, often finding ways to combine her passions, like the time she flew to London to run a half marathon (although she's yet to knit something while running) (she did, however, knit the hat Adam is wearing in the photo!).</p>
            </div>
            <div class="col-md-4">
                <img src="/images/engagement.jpg" class="img-fluid" alt="..." style="border-radius: var(--bs-border-radius)">
            </div>
            <div class="col text-start">
                <h3>Adam Zeloof</h3>
                <p>is just some guy. Just kidding, he actually is a very cool guy who knows how to do anything and everything. His degree says mechanical engineer but he's also an electrical engineer, jewelry designer, photographer, website designer (including this one), IT expert, piano player, spreadsheet maker, radio operator, baker, watch enthusiast and cat parent.</p>
                <p>Adam always says that everyone frustrates him, but don't be fooled he is very thoughtful and loyal to his friends and family. He moved to the UK for a year to be with Sara during grad school, and remembers all the little details about his friends. He loves Star Trek even though Sara won't watch it with him, and despite being a homebody he enjoys exploring the world with Sara.</p>
            </div>
        </div>

        <!--<script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js" integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous" async></script>-->
        <div class="row mt-5">
            <h4>Meet the wedding party</h4>
            <p>Rather than drafting our friends as if we were picking teams for a game of dodgeball, we elected to have a combined wedding party.</p>
        </div>


        <div class="row py-2"> <!-- data-masonry='{"percentPosition": true }'>-->
            <?php
            $files = glob("party_profiles/*.php");
            $profiles = array();
            foreach($files as $file) {
                include $file;
                $profiles[] = $profile;
            }
            foreach($profiles as $profile) {
                echo("<div class='mtg-card'>");
                include("mtg/mtg-card.php");
                echo('</div>');
            }
            ?>
        </div>
    </div>

<?php include("bottom.php");?>