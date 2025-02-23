<?php

include_once('./classes/profile.php');

$profile = new Profile();
$profile->name = 'Shahar Elisha';
$profile->type = 'Creature - Audio Scientist';
$profile->cost = '<i class="ms ms-w ms-cost ms-shadow"></i><i class="ms ms-w ms-cost ms-shadow"></i>';
$profile->image = '/party_profiles/images/shahar.jpg';
$profile->description = "Shahar met Sara during their AI music masters program in London, and introduced Sara to important cultural touchstones such as Eurovision and Dishoom (the best indian restaurant ever). They explored London and went to music shows when they weren't busy studying.";
$profile->quote = 'I wasn\'t sure what a wedding party was.';
$profile->powerToughness= "1/1";

?>