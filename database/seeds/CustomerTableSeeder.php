<?php

use Illuminate\Database\Seeder;

class CustomerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 10; $i++) {
            \App\Models\Customer::create([
                'fullname'      => "Khách hàng $i",
                'activated'     => TRUE,
                'company_id'    => 1,
            ]);
        }
    }
}
