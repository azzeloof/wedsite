<?php

include_once('./classes/profile.php');

$profile = new Profile();
$profile->name = 'Ashley Wong';
$profile->type = 'Creature - Human Calculator';
$profile->cost = '<i class="ms ms-r ms-cost ms-shadow"></i><i class="ms ms-r ms-cost ms-shadow"></i>';
$profile->image = '/party_profiles/images/ashley.jpg';
$profile->description = "Ashley and Sara slept 5 feet from each other for three years during college and still want to spend time together so it's safe to say their friendship is built to last. They bonded over their love of cats, so of course their chat history is filled with mostly cat pictures and shrek memes.";
$profile->quote = '*screams*';
$profile->powerToughness= "1/1";

?>