<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Seeder;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $response = Http::get('https://www.apicountries.com/countries');

        if ($response->successful()) {
            $countries = json_decode($response->getBody(), true);

            foreach($countries as $country){

                Country::create([
                    'sortname' => $country['alpha2Code'],
                    'alpha3code' => $country['alpha3Code'],
                    'numeric_code' => $country['numericCode'],
                    'name' => $country['name'],
                    'nationality' => $country['demonym'],
                    'capital' => isset($country['capital']) ? $country['capital'] : null,
                    'phonecode' => $country['callingCodes'][0],
                    'currency' => isset($country['currencies']) ? $country['currencies'][0]['code'] : null,
                    'currency_name' => isset($country['currencies']) ? $country['currencies'][0]['name'] : null,
                    'currency_symbol' => isset($country['currencies']) ? $country['currencies'][0]['symbol'] : null,
                    'time_zones' => $country['timezones'],
                    'flag' => $country['flag'],
                    'region' => $country['region'],
                    'subregion' => $country['subregion'],
                ]);
            }
        }
    }
}
