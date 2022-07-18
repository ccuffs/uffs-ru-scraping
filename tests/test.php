<?php

require __DIR__ . '/../vendor/autoload.php';

use CCUFFS\Scrap\UniversityRestaurantUFFS;

$hello = new UniversityRestaurantUFFS();
print_r($hello->getMenuByWeekDay($hello->campus["chapeco"], 'ter'));
