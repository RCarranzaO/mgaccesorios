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
            'name' => 'Rafael',
            'lastname' => 'Carranza',
            'username' => 'rcarranza',
            'email' => 'rcarranza1390@gmail.com',
            'password' => bcrypt('adminr'),
            'rol' => '1',
            'estatus' => '1'
        ));
    }
}
