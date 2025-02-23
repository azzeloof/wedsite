<?php

include_once('./classes/profile.php');

$profile = new Profile();
$profile->name = 'Heila Precel';
$profile->type = 'Creature - AI Ethics Scientist';
$profile->cost = '<i class="ms ms-g ms-cost ms-shadow"></i><i class="ms ms-w ms-cost ms-shadow"></i>';
$profile->image = '/party_profiles/images/heila.jpg';
$profile->description = "Heila met Adam and Sara freshman year of college and then 5 years later they became friends. She is talented at debating pointless topics such as the cube rule and coffee vs soda. Heila will be officiating the wedding and is our only friend good at public speaking";
$profile->quote = 'Worst case, I will wear stilts.';
$profile->powerToughness= "1/1";

?>