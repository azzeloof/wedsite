<?php

include_once('./classes/profile.php');

$profile = new Profile();
$profile->name = 'Eric Reeder';
$profile->type = 'Creature - Human Engineer';
$profile->cost = '<i class="ms ms-w ms-cost ms-shadow"></i><i class="ms ms-w ms-cost ms-shadow"></i>';
$profile->image = '/party_profiles/images/eric.jpg';
$profile->description = "Eric did not live with Adam or Sara during undergrad but did spend many nights falling asleep on the \"Eric chair\" in Sara's living room. He is always down to party and by party we mean nap. Eric likes to share details about his bowel movements, and is a talented bluegrass banjo player.";
$profile->quote = 'I need to go to bed.';
$profile->powerToughness= "1/1";

?>