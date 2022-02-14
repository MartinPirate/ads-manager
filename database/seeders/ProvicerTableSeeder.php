<?php

namespace Database\Seeders;

use App\Models\Provider;
use Illuminate\Database\Seeder;

class ProvicerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $provider = new Provider();
       $provider->provider_name = "Google";
       $provider->save();

        $provider = new Provider();
        $provider->provider_name = "Snapchat";
        $provider->save();
    }
}
