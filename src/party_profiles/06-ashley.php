<?php

include_once('./classes/profile.php');

$profile = new Profile();
$profile->name = 'Ashley Wong';
$profile->type = 'Creature - Human Calculator';
$profile->cost = '<i class="ms ms-r ms-cost ms-shadow"></i><i class="ms ms-r ms-cost ms-shadow"></i>';
$profile->image = '/';
$profile->description = 'words';
$profile->quote = '';
$profile->powerToughness= "1/1";

?>