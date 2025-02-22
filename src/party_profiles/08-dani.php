<?php

include_once('./classes/profile.php');

$profile = new Profile();
$profile->name = 'Dani Quan';
$profile->type = 'Creature - Human Engineer';
$profile->cost = '<i class="ms ms-u ms-cost ms-shadow"></i><i class="ms ms-u ms-cost ms-shadow"></i>';
$profile->image = '/party_profiles/images/dani.jpg';
$profile->description = "Dani met Adam during sophmore year of college while she was sitting on top of a bridgeport fixing it, and they've been friends since. She's a talented textile artist (she wove the scarf Adam is wearing above) and engineer. She loves Star Wars, musicals, and board games.";
$profile->quote = '';
$profile->powerToughness= "1/1";

?>