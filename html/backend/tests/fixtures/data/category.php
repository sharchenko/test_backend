<?php

$faker = Faker\Factory::create();
$len = $faker->numberBetween(5, 10);
$data = [];

while ($len > 0) {
    $data[] = [
        'name' => $faker->sentence(3)
    ];
    $len--;
}

return $data;