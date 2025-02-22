<?php

include_once('./classes/profile.php');

$profile = new Profile();
$profile->name = 'Nazlı Uzgur';
$profile->type = 'Creature - Computer Scientist';
$profile->cost = '<i class="ms ms-w ms-cost ms-shadow"></i><i class="ms ms-b ms-cost ms-shadow"></i>';
$profile->image = '/party_profiles/images/nazli.jpg';
$profile->description = "Naz lived with Adam during college, and when she got fed up with being bullied by him would come visit Sara next door. Adam and Sara have enjoyed hosting Naz for Thanksgiving and Christmas with their families, and they still remember her even though she now lives in Turkey.";
$profile->quote = 'Don\'t forget me.';
$profile->powerToughness= "1/1";

?>