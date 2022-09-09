<?php

require __DIR__ . '/../vendor/autoload.php';

use CCUFFS\Scrap\UniversityRestaurantUFFS;

$ur = new UniversityRestaurantUFFS();

$list = $ur->getMenuByCampus($ur->campus["realeza"]);
print_r($list);
