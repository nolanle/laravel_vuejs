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
        $company = \App\Models\Company::create([
            'name'              => "Cty Khánh Băng 1",
            'phone'             => "0123456781",
            'district_id'       => "836",
            'address'           => "121 Tính Tiền",
            'represent'         => "Nolan Le",
            'interested'        => 100000000,
            'total_investment'  => 100000000,
            'activated'         => TRUE,
        ]);

        $company = \App\Models\Company::create([
            'name'              => "Cty Khánh Băng 2",
            'phone'             => "0123456782",
            'district_id'       => "061",
            'address'           => "122 Tính Tiền",
            'represent'         => "Nolan Le",
            'interested'        => 100000000,
            'total_investment'  => 100000000,
            'activated'         => TRUE,
        ]);

        $company = \App\Models\Company::create([
            'name'              => "Cty Khánh Băng 3",
            'phone'             => "0123456783",
            'district_id'       => "660",
            'address'           => "123 Tính Tiền",
            'represent'         => "Nolan Le",
            'interested'        => 100000000,
            'total_investment'  => 100000000,
            'activated'         => TRUE,
        ]);
    }
}
