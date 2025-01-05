<?php

include_once('./classes/profile.php');

$profile = new Profile();
$profile->name = 'Matt Martone';
$profile->type = 'Creature - Human Engineer';
$profile->cost = '<i class="ms ms-g ms-cost ms-shadow"></i><i class="ms ms-2 ms-cost ms-shadow"></i>';
$profile->image = '/party_profiles/images/matt.jpg';
$profile->description = 'Adam and Sara met Matt as freshmen at CMU, when Matt was Adam\'s roommate. For some reason, they decided to continue living together for the remaining three years of college.';
$profile->quote = 'gam';

?>