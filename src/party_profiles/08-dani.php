<?php

include_once('./classes/profile.php');

$profile = new Profile();
$profile->name = 'Dani Quan';
$profile->type = 'Creature - Human Engineer';
$profile->cost = '<i class="ms ms-u ms-cost ms-shadow"></i><i class="ms ms-u ms-cost ms-shadow"></i>';
$profile->image = '/party_profiles/images/dani.jpg';
$profile->description = 'words';
$profile->quote = 'quote';
$profile->powerToughness= "1/1";

?>