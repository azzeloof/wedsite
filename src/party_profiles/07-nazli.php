<?php

include_once('./classes/profile.php');

$profile = new Profile();
$profile->name = 'Nazlı Uzgur';
$profile->type = 'Creature - Computer Scientist';
$profile->cost = '<i class="ms ms-w ms-cost ms-shadow"></i><i class="ms ms-w ms-cost ms-shadow"></i>';
$profile->image = '/party_profiles/images/nazli.jpg';
$profile->description = 'words';
$profile->quote = 'Don\'t forget me.';
$profile->powerToughness= "1/1";

?>