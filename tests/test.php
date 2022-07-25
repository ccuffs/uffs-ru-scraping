<?php

require __DIR__ . '/../vendor/autoload.php';

use CCUFFS\Scrap\UniversityRestaurantUFFS;

$ru = new UniversityRestaurantUFFS();
print_r($ru->getMenuByCampus($ru->campus["cerro-largo"]));
