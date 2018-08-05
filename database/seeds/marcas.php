<?php

use Illuminate\Database\Seeder;

class marcas extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $marca = [
        	[
                'Apple',
                '1',
            ],
            [
                'SAMSUNG',
                '1',
            ],
            [
                'LG',
                '1',
            ],
            [
                'HUAWEI',
                '1',
            ],
            [
                'S/M',
                '1',
            ]
        ];

        $cont = count($marca);
        for ($i=0; $i < $cont ; $i++) {
            DB::table('marcas')->insert([
              'nombrem' => $marca[$i][0],
              'estatus' => $marca[$i][1],
            ]);
        }
    }
}
