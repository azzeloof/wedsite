<?php

include_once('./classes/profile.php');

$profile = new Profile();
$profile->name = 'Emma Seely';
$profile->type = 'Creature - Human Writer';
$profile->cost = '<i class="ms ms-u ms-cost ms-shadow"></i><i class="ms ms-u ms-cost ms-shadow"></i>';
$profile->image = '/party_profiles/images/emma.jpg';
$profile->description = "Emma met Sara in middle school jazz band, where they bonded over creating cardboard cutouts of their band directors face. Over the years, they have enjoyed badminton, road tennis, thrift shopping, exploring new cities and listening to their favorite band Jukebox the Ghost together.";
$profile->quote = 'I love that for you.';
$profile->powerToughness= "1/1";


?>