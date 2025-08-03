<?php

include_once('./classes/profile.php');

$profile = new Profile();
$profile->name = 'Sam Zeloof';
$profile->type = 'Creature - Human Engineer';
$profile->cost = '<i class="ms ms-u ms-cost ms-shadow"></i><i class="ms ms-u ms-cost ms-shadow"></i>';
$profile->image = '/party_profiles/images/sam.jpg';
$profile->description = "Sam is Adam's brother and is far and away the smarter of the two. He taught Adam everything he knows about electronics, and is the CEO of Atomic Semi, a nanofab startup in California. His first company (when he was twelve) was modifying Nerf guns.";
$profile->quote = 'This is inefficient.';
$profile->powerToughness= "1/1";

?>
