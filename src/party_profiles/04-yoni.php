<?php

include_once('./classes/profile.php');

$profile = new Profile();
$profile->name = 'Jonathan Merrin';
$profile->type = 'Creature - Computer Scientist';
$profile->cost = '<i class="ms ms-r ms-cost ms-shadow"></i><i class="ms ms-g ms-cost ms-shadow"></i>';
$profile->image = '/party_profiles/images/yoni.jpg';
$profile->description = "Jonathan was one of Sara's college roommates and is unequivocally the nicest person (and possibly the least organized person) that Sara and Adam know. You wouldn't be able to beat him at Scrabble (or likely any other game).";
$profile->quote = 'Ouch.';
$profile->powerToughness= "1/1";

?>