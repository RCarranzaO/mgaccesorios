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
          'direccion' => 'calle 56 plaza tecnologia local 5',
          'telefono' => '12345678',
          'estatus' => '1'
      ));
      DB::table('sucursales')->insert(array(
          'nombre_sucursal' => 'sucursal2',
          'direccion' => 'calle 56 plaza tecnologia local 17',
          'telefono' => '996586498',
          'estatus' => '1'
      ));
      DB::table('sucursales')->insert(array(
          'nombre_sucursal' => 'sucursal3',
          'direccion' => 'calle 56 plaza tecnologia local 34',
          'telefono' => '995843621',
          'estatus' => '1'
      ));
    }
}
