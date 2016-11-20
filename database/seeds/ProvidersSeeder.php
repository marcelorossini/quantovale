<?php

use Illuminate\Database\Seeder;
use App\Provider;

class ProvidersSeeder extends Seeder
{
    public function run()
    {
        Provider::truncate();

        $provider = new Provider();
        $provider->id = 1;
        $provider->name = 'buscape';
        $provider->save();
    }
}
