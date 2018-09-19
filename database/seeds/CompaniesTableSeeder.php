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
            'activated'         => TRUE,
        ]);
        // add init capital
        \App\Models\Transaction::create([
            'type'          => 'initial',
            'addition'      => TRUE,
            'company_id'    => $company->id,
            'amount'        => '100000000' * $company->id,
        ]);

        $company = \App\Models\Company::create([
            'name'              => "Cty Khánh Băng 2",
            'phone'             => "0123456782",
            'district_id'       => "061",
            'address'           => "122 Tính Tiền",
            'represent'         => "Nolan Le",
            'activated'         => TRUE,
        ]);
        \App\Models\Transaction::create([
            'type'          => 'initial',
            'addition'      => TRUE,
            'company_id'    => $company->id,
            'amount'        => '100000000' * $company->id,
        ]);

        $company = \App\Models\Company::create([
            'name'              => "Cty Khánh Băng 3",
            'phone'             => "0123456783",
            'district_id'       => "660",
            'address'           => "123 Tính Tiền",
            'represent'         => "Nolan Le",
            'activated'         => TRUE,
        ]);
        \App\Models\Transaction::create([
            'type'          => 'initial',
            'addition'      => TRUE,
            'company_id'    => $company->id,
            'amount'        => '100000000' * $company->id,
        ]);
    }
}
