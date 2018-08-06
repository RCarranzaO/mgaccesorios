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
            'name' => 'Jozabeth',
            'lastname' => 'Franco',
            'username' => 'jfranco',
            'email' => 'rcarranza1390@gmail.com',
            'password' => bcrypt('adminj'),
            'rol' => '1',
            'id_sucursal' => '2',
            'estatus' => '1'
        ));
        DB::table('users')->insert(array(
            'name' => 'Cecilia',
            'lastname' => 'Pech',
            'username' => 'cpech',
            'email' => 'rcarranza1390@gmail.com',
            'password' => bcrypt('adminc'),
            'rol' => '1',
            'id_sucursal' => '3',
            'estatus' => '1'
        ));
        DB::table('users')->insert(array(
            'name' => 'Jorge',
            'lastname' => 'Bencomo',
            'username' => 'jbencomo',
            'email' => 'rcarranza1390@gmail.com',
            'password' => bcrypt('vendej'),
            'rol' => '2',
            'id_sucursal' => '1',
            'estatus' => '1'
        ));
        DB::table('users')->insert(array(
            'name' => 'Manuel',
            'lastname' => 'Medina',
            'username' => 'mmedina',
            'email' => 'rcarranza1390@gmail.com',
            'password' => bcrypt('vendem'),
            'rol' => '2',
            'id_sucursal' => '2',
            'estatus' => '1'
        ));
        DB::table('users')->insert(array(
            'name' => 'Rodrigo',
            'lastname' => 'Fernandez',
            'username' => 'rfernandez',
            'email' => 'rcarranza1390@gmail.com',
            'password' => bcrypt('vender'),
            'rol' => '2',
            'id_sucursal' => '3',
            'estatus' => '1'
        ));
    }
}
