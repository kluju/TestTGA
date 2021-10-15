<?php

namespace Database\Seeders;

use Database\Seeders\Traits\TruncateTable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Database\Seeders\Traits\DisableForeignKeys;

/**
 * Class ClienteSeeder.
 */
class AlternativaSeeder extends Seeder
{
    use DisableForeignKeys;
    use TruncateTable;
    
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->disableForeignKeys();

        DB::table('alternativas')->delete();
        
        DB::table('alternativas')->insert(array (
            0 =>array ( 'name' => 'Hombre','id_pregunta'=> 2,'alternativa'=>true),
            1 =>array ( 'name' => 'Mujer','id_pregunta'=> 2,'alternativa'=>true),
            
            2 =>array ( 'name' => 'Ninguno','id_pregunta'=> 3,'alternativa'=>true),
            3 =>array ( 'name' => 'Deporte','id_pregunta'=> 3,'alternativa'=>true),
            4 =>array ( 'name' => 'Musical','id_pregunta'=> 3,'alternativa'=>true),
            5 =>array ( 'name' => 'Cocina','id_pregunta'=> 3,'alternativa'=>true),
            6 =>array ( 'name' => 'Literario','id_pregunta'=> 3,'alternativa'=>true),
            7 =>array ( 'name' => 'Manualidades','id_pregunta'=> 3,'alternativa'=>true),
            8 =>array ( 'name' => 'Juegos','id_pregunta'=> 3,'alternativa'=>true),
            9 =>array ( 'name' => 'Modelismo','id_pregunta'=> 3,'alternativa'=>true),
            10 =>array ( 'name' => 'Baile','id_pregunta'=> 3,'alternativa'=>true),
            11 =>array ( 'name' => 'Cine','id_pregunta'=> 3,'alternativa'=>true),
            12 =>array ( 'name' => 'Otro','id_pregunta'=> 3,'alternativa'=>true),
            
        ));

        $this->enableForeignKeys();
    }
}
