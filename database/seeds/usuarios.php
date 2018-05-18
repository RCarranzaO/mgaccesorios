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
            'password' => bcrypt('adminroot'),
            'rol' => 'administrador',
            'estatus' => '1'
        ));
        DB::table('users')->insert(array(
            'name' => 'Cecilia',
            'lastname' => 'Pech',
            'username' => 'cpech',
            'password' => bcrypt('userpech'),
            'rol' => 'administrador',
            'estatus' => '1'
        ));
        DB::table('users')->insert(array(
            'name' => 'Jorge',
            'lastname' => 'Bencomo',
            'username' => 'jbencomo',
            'password' => bcrypt('userben'),
            'rol' => 'vendedor',
            'estatus' => '1'
        ));
    }
}
