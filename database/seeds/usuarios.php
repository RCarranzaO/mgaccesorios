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
            'name' => 'Miguel',
            'lastname' => 'Avila',
            'username' => 'mavila',
            'email' => 'leinad_6991@hotmail.com',
            'password' => bcrypt('adminm'),
            'rol' => '1',
            'id_sucursal' => '1',
            'estatus' => '1'
        ));
        DB::table('users')->insert(array(
            'name' => 'Rafael',
            'lastname' => 'Carranza',
            'username' => 'rcarranza',
            'email' => 'rcarranza1390@gmail.com',
            'password' => bcrypt('adminr'),
            'rol' => '2',
            'id_sucursal' => '2',
            'estatus' => '1'
        ));
    }
}
