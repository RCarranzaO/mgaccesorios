<?php

use Illuminate\Database\Seeder;

class usuarios extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(array(
            'name' => 'Daniel',
            'lastname' => 'Domínguez',
            'username' => 'ddominguez',
            'email' => 'leinad_6991@hotmail.com',
            'password' => bcrypt('admind'),
            'rol' => '1',
            'id_sucursal' => '1',
            'estatus' => '1'
        ));
    }
}
