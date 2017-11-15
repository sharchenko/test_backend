<?php

use app\models\Category;
use Faker\Factory;

$faker = Factory::create();
$data = [];

foreach (Category::find()->all() as $category) {
    $len = $faker->numberBetween(10, 20);
    while ($len > 0) {
        $data[] = [
            'name' => $faker->sentence(3),
            'description' => $faker->text(),
            'price' => $faker->numberBetween(100, 500),
            'category_id' => $category->id,
            'created_at' => time(),
            'updated_at' => time(),
        ];
        $len--;
    }
}

return $data;