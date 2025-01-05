<?php

include_once('./classes/profile.php');

$profile = new Profile();
$profile->name = 'Sam Zeloof';
$profile->type = 'Creature - Human Engineer';
$profile->cost = '<i class="ms ms-g ms-cost ms-shadow"></i><i class="ms ms-2 ms-cost ms-shadow"></i>';
$profile->image = '/party_profiles/images/sam.jpg';
$profile->description = 'words';
$profile->quote = 'quote';

?>