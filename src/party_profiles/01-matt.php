<?php

include_once('./classes/profile.php');

$profile = new Profile();
$profile->name = 'Matt Martone';
$profile->type = 'Creature - Human Roboticist';
$profile->cost = '<i class="ms ms-g ms-cost ms-shadow"></i><i class="ms ms-g ms-cost ms-shadow"></i>';
$profile->image = '/party_profiles/images/matt.jpg';
$profile->description = "Matt was Adam's college roommate and Sara's college lab partner. Now, he's their DM in a weekly game of D&D.\n He paints minis, plays board games, and can beat Super Mario 64 in 27 minutes, which he did once in the backseat of Adam's car during a roadtrip.";
$profile->quote = 'gam?';
$profile->powerToughness= "1/1";

?>