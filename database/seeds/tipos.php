<?php

use Illuminate\Database\Seeder;

class tipos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipo = [
            [
                'Aluminio',
                '1',
            ],
            [
                'Araña',
                '1',
            ],
            [
                'Bluetooth',
                '1',
            ],
            [
                'Doble decorado',
                '1',
            ],
            [
                'Líquidas',
                '1',
            ],
            [
                'Robot',
                '1',
            ],
            [
                'Tela',
                '1',
            ],
            [
                'TPU',
                '1',
            ],
            [
                'USB',
                '1',
            ],
            [
                'Uso rudo',
                '1',
            ],
            [
                'S/M',
                '1',
            ]
        ];

        $cont = count($tipo);
        for ($i=0; $i < $cont ; $i++) {
            DB::table('tipos')->insert([
              'nombret' => $tipo[$i][0],
              'estatus' => $tipo[$i][1],
            ]);
        }
    }
}
