<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Tambahkan ini

class OperatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mendapatkan timestamp saat ini
        $now = now(); 

        User::insert([
            [
                'name'              => 'Tim Task Force Otsus PPS',
                'email'             => 'timtaskforce.otsus@gmail.com',
                'password'          => bcrypt('otsus@2025'),
                'kontak'            => '6282399770016',
                'is_admin'          => 1,
                'opd_id'            => 20,
                'email_verified_at' => $now, // Disarankan
                'created_at'        => $now, // Disarankan
                'updated_at'        => $now, // Disarankan
            ],
            [
                'name'              => 'Yuli Soemokil',
                'email'             => 'inspektoratpapsel123@gmail.com',
                'password'          => bcrypt('Papuaselatan@27#'),
                'kontak'            => '6282393123123',
                'is_admin'          => 0,
                'opd_id'            => 1,
                'email_verified_at' => $now, // Disarankan
                'created_at'        => $now, // Disarankan
                'updated_at'        => $now, // Disarankan
            ],
            [
                'name'              => 'Joko Mulyono',
                'email'             => 'dinkespapsel123@gmail.com',
                'password'          => bcrypt('Papuaselatan@12#'),
                'kontak'            => '6281344436338',
                'is_admin'          => 0,
                'opd_id'            => 2,
                'email_verified_at' => $now, // Disarankan
                'created_at'        => $now, // Disarankan
                'updated_at'        => $now, // Disarankan
            ],
            [
                'name'              => 'Roki A. Purba',
                'email'             => 'puprpapasel123@gmail.com',
                'password'          => bcrypt('Papuaselatan@13#'),
                'kontak'            => '6285228010787',
                'is_admin'          => 0,
                'opd_id'            => 10,
                'email_verified_at' => $now, // Disarankan
                'created_at'        => $now, // Disarankan
                'updated_at'        => $now, // Disarankan
            ],
            [
                'name'              => 'Iqbal Al Hamid',
                'email'             => 'dinsospapsel123@gmail.com',
                'password'          => bcrypt('Papuaselatan@14#'),
                'kontak'            => '6285244307154',
                'is_admin'          => 0,
                'opd_id'            => 16,
                'email_verified_at' => $now, // Disarankan
                'created_at'        => $now, // Disarankan
                'updated_at'        => $now, // Disarankan
            ],
            [
                'name'              => 'Adrian',
                'email'             => 'disnakerpapsel123@gmail.com',
                'password'          => bcrypt('Papuaselatan@15#'),
                'kontak'            => '6281319775911',
                'is_admin'          => 0,
                'opd_id'            => 13,
                'email_verified_at' => $now, // Disarankan
                'created_at'        => $now, // Disarankan
                'updated_at'        => $now, // Disarankan
            ],
            [
                'name'              => 'Jeffri Pelamonia',
                'email'             => 'pertanianpapsel123@gmail.com',
                'password'          => bcrypt('Papuaselatan@16#'),
                'kontak'            => '6285254254154',
                'is_admin'          => 0,
                'opd_id'            => 8,
                'email_verified_at' => $now, // Disarankan
                'created_at'        => $now, // Disarankan
                'updated_at'        => $now, // Disarankan
            ],
            [
                'name'              => 'Mariani',
                'email'             => 'dukcapilpapsel123@gmail.com',
                'password'          => bcrypt('Papuaselatan@17#'),
                'kontak'            => '6282297068502',
                'is_admin'          => 0,
                'opd_id'            => 4,
                'email_verified_at' => $now, // Disarankan
                'created_at'        => $now, // Disarankan
                'updated_at'        => $now, // Disarankan
            ],
            [
                'name'              => 'A. Siagian',
                'email'             => 'dishubpapsel123@gmail.com',
                'password'          => bcrypt('Papuaselatan@18#'),
                'kontak'            => '628124818650',
                'is_admin'          => 0,
                'opd_id'            => 11,
                'email_verified_at' => $now, // Disarankan
                'created_at'        => $now, // Disarankan
                'updated_at'        => $now, // Disarankan
            ],
            [
                'name'              => 'Arif Rahanar',
                'email'             => 'diskominfopapsel123@gmail.com',
                'password'          => bcrypt('Papuaselatan@19#'),
                'kontak'            => '6285244138191',
                'is_admin'          => 0,
                'opd_id'            => 9,
                'email_verified_at' => $now, // Disarankan
                'created_at'        => $now, // Disarankan
                'updated_at'        => $now, // Disarankan
            ],
            [
                'name'              => 'Eddy_L',
                'email'             => 'koperindagpapsel123@gmail.com',
                'password'          => bcrypt('Papuaselatan@20#'),
                'kontak'            => '6281392319696',
                'is_admin'          => 0,
                'opd_id'            => 7,
                'email_verified_at' => $now, // Disarankan
                'created_at'        => $now, // Disarankan
                'updated_at'        => $now, // Disarankan
            ],
            [
                'name'              => 'Thina Datu',
                'email'             => 'disporapapsel123@gmail.com',
                'password'          => bcrypt('Papuaselatan@21#'),
                'kontak'            => '6281355327723',
                'is_admin'          => 0,
                'opd_id'            => 5,
                'email_verified_at' => $now, // Disarankan
                'created_at'        => $now, // Disarankan
                'updated_at'        => $now, // Disarankan
            ],
            [
                'name'              => 'Yudha',
                'email'             => 'setdapem123@gmail.com',
                'password'          => bcrypt('Papuaselatan@22#'),
                'kontak'            => '6281220220279',
                'is_admin'          => 0,
                'opd_id'            => 18,
                'email_verified_at' => $now, // Disarankan
                'created_at'        => $now, // Disarankan
                'updated_at'        => $now, // Disarankan
            ],
            [
                'name'              => 'Leon Rettob',
                'email'             => 'setdabarjas123@gmail.com',
                'password'          => bcrypt('Papuaselatan@23#'),
                'kontak'            => '6282199265677',
                'is_admin'          => 0,
                'opd_id'            => 17,
                'email_verified_at' => $now, // Disarankan
                'created_at'        => $now, // Disarankan
                'updated_at'        => $now, // Disarankan
            ],
            [
                'name'              => 'Sarlin',
                'email'             => 'sekdprppapsel123@gmail.com',
                'password'          => bcrypt('Papuaselatan@24#'),
                'kontak'            => '6281247331213',
                'is_admin'          => 0,
                'opd_id'            => 15,
                'email_verified_at' => $now, // Disarankan
                'created_at'        => $now, // Disarankan
                'updated_at'        => $now, // Disarankan
            ],
            [
                'name'              => 'Kelvin Yullans Imkota',
                'email'             => 'bapperidapapsel123@gmail.com',
                'password'          => bcrypt('Papuaselatan@25#'),
                'kontak'            => '6281228071995',
                'is_admin'          => 0,
                'opd_id'            => 19,
                'email_verified_at' => $now, // Disarankan
                'created_at'        => $now, // Disarankan
                'updated_at'        => $now, // Disarankan
            ],
            [
                'name'              => 'Herman',
                'email'             => 'bkpsdmpapsel123@gmail.com',
                'password'          => bcrypt('Papuaselatan@26#'),
                'kontak'            => '6281343037355',
                'is_admin'          => 0,
                'opd_id'            => 6,
                'email_verified_at' => $now, // Disarankan
                'created_at'        => $now, // Disarankan
                'updated_at'        => $now, // Disarankan
            ],
            [
                'name'              => 'Esron Bontong',
                'email'             => 'bakesbangpolpapsel123@gmail.com',
                'password'          => bcrypt('Papuaselatan@28#'),
                'kontak'            => '6282188661313',
                'is_admin'          => 0,
                'opd_id'            => 12,
                'email_verified_at' => $now, // Disarankan
                'created_at'        => $now, // Disarankan
                'updated_at'        => $now, // Disarankan
            ],
            [
                'name'              => 'Tere Ohoiwutun',
                'email'             => 'setmrppapsel123@gmail.com',
                'password'          => bcrypt('Papuaselatan@29#'),
                'kontak'            => '6285251619776',
                'is_admin'          => 0,
                'opd_id'            => 14,
                'email_verified_at' => $now, // Disarankan
                'created_at'        => $now, // Disarankan
                'updated_at'        => $now, // Disarankan
            ],

            [
                'name'              => 'Suwoyo',
                'email'             => 'pendidikanpapsel123@gmail.com',
                'password'          => bcrypt('Papuaselatan@11#'),
                'kontak'            => '685285859993',
                'is_admin'          => 0,
                'opd_id'            => 3,
                'email_verified_at' => $now, // Disarankan
                'created_at'        => $now, // Disarankan
                'updated_at'        => $now, // Disarankan
            ],
        ]);
    }
}