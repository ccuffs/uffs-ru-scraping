<?php

require __DIR__ . '/../vendor/autoload.php';

use CCUFFS\Scrap\UniversityRestaurantUFFS;

$ur = new UniversityRestaurantUFFS();
print_r($ur->getMenuByWeekDay($ur->campus["chapeco"], 'seg'));
