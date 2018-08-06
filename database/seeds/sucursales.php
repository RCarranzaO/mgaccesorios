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
          'nombre_sucursal' => 'Local 24',
          'direccion' => 'calle 56 plaza tecnologia local 24',
          'telefono' => '12345678',
          'estatus' => '1'
      ));
      DB::table('sucursales')->insert(array(
          'nombre_sucursal' => 'Local 129',
          'direccion' => 'calle 56 plaza tecnologia local 129',
          'telefono' => '996586498',
          'estatus' => '1'
      ));
      DB::table('sucursales')->insert(array(
          'nombre_sucursal' => 'Local 77',
          'direccion' => 'calle 56 plaza tecnologia local 77',
          'telefono' => '995843621',
          'estatus' => '1'
      ));
    }
}
