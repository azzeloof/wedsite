<?php

include_once('./classes/profile.php');

$profile = new Profile();
$profile->name = 'Eric Reeder';
$profile->type = 'Creature - Human Engineer';
$profile->cost = '<i class="ms ms-w ms-cost ms-shadow"></i><i class="ms ms-w ms-cost ms-shadow"></i>';
$profile->image = '/party_profiles/images/eric.jpg';
$profile->description = 'words';
$profile->quote = 'I need to go to bed.';
$profile->powerToughness= "1/1";

?>