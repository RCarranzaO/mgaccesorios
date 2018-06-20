<?php

use Illuminate\Database\Seeder;

class sucursales extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('sucursales')->insert(array(
          'nombre_sucursal' => 'sucursal1',
          'direccion' => 'calle 56 plaza tecnologia',
          'telefono' => '12345678',
          'estatus' => '1'
      ));
    }
}
