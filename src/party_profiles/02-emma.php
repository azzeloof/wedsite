<?php

include_once('./classes/profile.php');

$profile = new Profile();
$profile->name = 'Emma Seely';
$profile->type = 'Creature - Human Writer';
$profile->cost = '<i class="ms ms-c ms-cost ms-shadow"></i><i class="ms ms-c ms-cost ms-shadow"></i>';
$profile->image = '/party_profiles/images/emma.jpg';
$profile->description = '';
$profile->quote = '';
$profile->powerToughness= "1/1";


?>