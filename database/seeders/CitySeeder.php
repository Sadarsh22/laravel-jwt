<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities=[
			'Ambala',
			'Bhiwani',
			'Faridabad',
			'Fatehabad',
			'Gurgaon',
			'Hissar',
			'Jhajjar',
			'Jind',
			'Karnal',
			'Kaithal',
			'Kurukshetra',
			'Mahendragarh',
			'Mewat',
			'Palwal',
			'Panchkula',
			'Panipat',
			'Rewari',
			'Rohtak',
			'Sirsa',
			'Sonipat',
			'Yamuna Nagar',
		];

        foreach($cities as $city)
        City::create(['name'=>$city,'state_id'=>'0183167b-80c8-44de-803a-828747ecb338']);
    }
}
