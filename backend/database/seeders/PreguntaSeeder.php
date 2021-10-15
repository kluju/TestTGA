<?php

namespace Database\Seeders;

use Database\Seeders\Traits\TruncateTable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Database\Seeders\Traits\DisableForeignKeys;

/**
 * Class ArriendoSeeder.
 */
class PreguntaSeeder extends Seeder
{
    use DisableForeignKeys;
    use TruncateTable;
    
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->disableForeignKeys();

        DB::table('preguntas')->delete();
        
        DB::table('preguntas')->insert(array (
            0 =>array ( 'name' => 'Nombre'),
            1 =>array ( 'name' => 'Genero'),
            2 =>array ( 'name' => '¿Tienes algún hobby?'),
            3 =>array ( 'name' => '¿Cuánto tiempo le dedicas al mes?'),
            
        ));

        $this->enableForeignKeys();
    }
}
