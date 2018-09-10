<?php

use Illuminate\Database\Seeder;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        for($i = 1; $i <= 10; $i++) {
            $company = \App\Models\Company::create([
                'name'              => "Công Ty $i",
                'phone'             => "0123456$i",
                'district_id'       => "030",
                'address'           => "$i Quốc Lộ 13",
                'represent'         => "Nolan Le $i",
                'interested'        => 100000000,
                'total_investment'  => 100000000,
                'activated'         => TRUE,
            ]);
        }
    }
}
