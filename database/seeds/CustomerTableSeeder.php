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
                'issued_date'   => \Carbon\Carbon::today(),
                'issued_at'     => 'Bình Phước',

                'address'       => "$i Binh Long",
                'phone'         => "12345678$i",
                'government_id' => "12345678$i",
            ]);
        }
    }
}
