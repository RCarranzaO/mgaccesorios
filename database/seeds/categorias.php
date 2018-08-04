<?php

use Illuminate\Database\Seeder;

class categorias extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $categoria = [
          [
                'Auricular',
                '1',
            ],
            [
                'Cable',
                '1',
            ],
            [
                'Funda',
                '1',
            ],
            [
                'Mica',
                '1',
            ],
            [
                'S/M',
                '1',
            ]
        ];

        $cont = count($categoria);
        for ($i=0; $i < $cont ; $i++) {
            DB::table('categorias')->insert([
              'nombrec' => $categoria[$i][0],
              'estatus' => $categoria[$i][1],
            ]);
        }
    }
}
