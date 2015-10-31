<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(HochschulkompassSeeder::class);

        $this->call(HSRMSeeder::class);
        $this->call(TUClausthalSeeder::class);
        $this->call(TUFreiberg::class);
        $this->call(FHBingen::class);
        $this->call(FernuniHagenSeeder::class);
        $this->call(UniTrierSeeder::class);

        Model::reguard();
    }
}
