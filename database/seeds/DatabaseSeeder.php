<?php

use App\Students;
use Illuminate\Database\Seeder;
use App\Carrera;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        // Crea registros de estudiantes
        factory(Students::class, 100)->create();

        // Crea registros de carreras
        factory(Carrera::class, 20)->create();
    }
}
