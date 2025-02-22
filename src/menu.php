<?php ($pg=='') ? $nav_class='nav-masthead-light' : $nav_class='nav-masthead-dark';?>

<header class="mb-auto">
    <div>
        <?php
            if($pg!='') {
                echo("<h3 class='float-md-start mb-0'>Adam & Sara Are Getting Married</h3>");
            }
        ?>
        <nav class="nav <?php echo $nav_class ?> justify-content-center float-md-end">
            <?php foreach ($pages as $pageId => $pageTitle): ?>
                <span <?=(($pg == $pageId) ? 'class="nav-link fw-bold py-1 px-0 active" aria-current="page"' : 'class="nav-link fw-bold py-1 px-0"')?> onclick="transitionToPage('/<?=$pageId?>.php')"><?=$pageTitle?></span>
            <?php endforeach; ?>
        </nav>
    </div>
</header>