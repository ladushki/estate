<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Property;
use Faker\Generator as Faker;


$factory->define(Property::class, function (Faker $faker) {

    return [
        'uuid' => $faker->uuid,
        'property_type_id' => 1,
        'county' => $faker->country,
        'country' => $faker->city(),
        'postcode' => $faker->postcode(),
        'town' => $faker->city(),
        'description' => $faker->text(),
        'address' => $faker->address(),
        'image_full' => $faker->imageUrl(),
        'image_thumbnail'=> $faker->imageUrl(),
        'latitude' => $faker->latitude(),
        'longitude' => $faker->longitude(),
        'num_bedrooms' => $faker->randomDigit(),
        'num_bathrooms'=>$faker->randomDigit(),
        'price'=>$faker->randomDigit(),
        'type'=> array_rand(['sale'=>'sale', 'rent'=>'rent']),
        'last_modified' => $faker->date('Y-m-d'),
        'is_locked' => 0,
    ];
});
