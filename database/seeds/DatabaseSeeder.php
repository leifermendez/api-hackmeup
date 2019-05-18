<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i = 0; $i < 20; $i++) {
            DB::table('available_zones')->insert([
                'code' => ($i < 10) ? 'ES' :$faker->countryCode,
                'time_zone' => ($i < 10) ? 'Europe/Andorra' :$faker->timezone,
                'currency' => ($i < 10) ? 'EUR' :$faker->currencyCode,
                'contry_name' => ($i < 10) ? 'Spain' : $faker->country,
                'language' => ($i < 10) ? 'es' : $faker->languageCode
            ]);

            DB::table('train_stations')->insert([
                'name' => $faker->streetAddress,
                'city' => $faker->city,
                'available_zone_id' => ($i+1)
            ]);

        }

        for($i = 0; $i < 20; $i++){
            DB::table('train_stations')->insert([
                'name' => $faker->streetAddress,
                'city' => $faker->city,
                'available_zone_id' => ($i+1)
            ]);
        }

        for($i = 0; $i < 10; $i++){
            DB::table('available_trips')->insert([
                'origin_available_zone_id' => $faker->numberBetween(1,10),
                'destination_available_zone_id' => $faker->numberBetween(1,10),
                'inbound_date' => $faker->dateTimeBetween($startDate = '+1 hours', $endDate = '+4 hours', $timezone = null),
                'outbound_date' => $faker->dateTimeBetween($startDate ='+8 hours', $endDate = '+14 hours', $timezone = null),
                'max_group' => $faker->numberBetween(20,100),
                'price_standar' => $faker->randomFloat(2,100,1000),
                'price_premier' =>  $faker->randomFloat(2,150,2000),
                'price_bussines' =>  $faker->randomFloat(2,300,10000),
                'type_trip' => ($i < 10) ? 'direct' : 'not_direct'
            ]);
        }

        for($i = 0; $i < 5; $i++){
            DB::table('reservations')->insert([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'email' => $faker->email,
                'phone' => $faker->phoneNumber,
                'available_trip_id' => $faker->numberBetween(1,8),
                'contact_first_name' => $faker->firstName,
                'contact_last_name' => $faker->lastName,
                'contact_email' => $faker->email,
                'contact_phone' => $faker->phoneNumber,
                'type_reservations' => ($i < 3) ? 'standar' : 'premier'
            ]);
        }

        /* Train SEED* */

        for ($i = 0; $i < 20; $i++) {
            DB::table('hotel_countries')->insert([
                'code' => ($i < 10) ? 'ES' :$faker->countryCode,
                'currency' => ($i < 10) ? 'EUR' :$faker->currencyCode,
                'contry_name' => ($i < 10) ? 'Spain' : $faker->country,
                'language' => ($i < 10) ? 'es' : $faker->languageCode
            ]);

        }

        for ($i = 0; $i < 20; $i++) {
            DB::table('hotel_availables')->insert([
                'name' => $faker->sentence(3),
                'stars' => $faker->numberBetween(1,5),
                'description' => $faker->sentence(8),
                'amount' => $faker->randomFloat(2,10,100),
                'hotel_country_id' => $faker->numberBetween(1,8)
            ]);

        }


        for ($i = 0; $i < 10; $i++) {
            DB::table('hotel_reservations')->insert([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'email' => $faker->email,
                'phone' => $faker->phoneNumber,
                'hotel_available' => $faker->numberBetween(1,8),
                'date_start' => $faker->dateTimeBetween($startDate = '+1 day', $endDate = '+2 days', $timezone = null),
                'date_finish' => $faker->dateTimeBetween($startDate = '+1 day', $endDate = '+2 days', $timezone = null),
                'type_reservations' => ($i < 3) ? 'standar' : 'premier'
            ]);

        }

        
    }

}
