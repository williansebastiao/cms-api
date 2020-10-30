<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('users')->truncate();
        $users = [
            [
                'name' => "Josianne Walsh",
                'avatar' => "https://s3.amazonaws.com/uifaces/faces/twitter/iduuck/128.jpg",
                'email' => "Jaeden86@gmail.com",
                'password' => '12345678',
                'active' => true
            ],
            [
                'name' => "Autumn Hackett",
                'avatar' => "https://s3.amazonaws.com/uifaces/faces/twitter/agustincruiz/128.jpg",
                'email' => "Tanner.Purdy64@yahoo.com",
                'password' => '12345678',
                'active' => true
            ],
            [
                'name' => "Ciara Simonis",
                'avatar' => "https://s3.amazonaws.com/uifaces/faces/twitter/nitinhayaran/128.jpg",
                'email' => "Will67@hotmail.com",
                'password' => '12345678',
                'active' => true
            ],
            [
                'name' => "Bertram Ullrich",
                'avatar' => "https://s3.amazonaws.com/uifaces/faces/twitter/haligaliharun/128.jpg",
                'email' => "Francis4@gmail.com",
                'password' => '12345678',
                'active' => true
            ],
            [
                'name' => "Gayle Murazik",
                'avatar' => "https://s3.amazonaws.com/uifaces/faces/twitter/bowbrick/128.jpg",
                'email' => "Stephany37@gmail.com",
                'password' => '12345678',
                'active' => true
            ],
            [
                'name' => "Scottie O'Reilly",
                'avatar' => "https://s3.amazonaws.com/uifaces/faces/twitter/xadhix/128.jpg",
                'email' => "Oma24@gmail.com",
                'password' => '12345678',
                'active' => true
            ],
            [
                'name' => "Angel Brakus",
                'avatar' => "https://s3.amazonaws.com/uifaces/faces/twitter/chrisvanderkooi/128.jpg",
                'email' => "Mable.Wintheiser7@hotmail.com",
                'password' => '12345678',
                'active' => true
            ],
            [
                'name' => "Quincy Deckow",
                'avatar' => "https://s3.amazonaws.com/uifaces/faces/twitter/devankoshal/128.jpg",
                'email' => "Travon_Smitham69@yahoo.com",
                'password' => '12345678',
                'active' => true
            ],
            [
                'name' => "Karson Beier",
                'avatar' => "https://s3.amazonaws.com/uifaces/faces/twitter/derekebradley/128.jpg",
                'email' => "Carol_Balistreri45@gmail.com",
                'password' => '12345678',
                'active' => true
            ],
            [
                'name' => "Santa Doyle",
                'avatar' => "https://s3.amazonaws.com/uifaces/faces/twitter/_yardenoon/128.jpg",
                'email' => "Pattie_Quitzon@hotmail.com",
                'password' => '12345678',
                'active' => true
            ],
            [
                'name' => "Aubrey Moore",
                'avatar' => "https://s3.amazonaws.com/uifaces/faces/twitter/louis_currie/128.jpg",
                'email' => "Jon_Dooley86@yahoo.com",
                'password' => '12345678',
                'active' => true
            ],
            [
                'name' => "Oran Weissnat",
                'avatar' => "https://s3.amazonaws.com/uifaces/faces/twitter/baluli/128.jpg",
                'email' => "Lia_Hermann@hotmail.com",
                'password' => '12345678',
                'active' => true
            ],
            [
                'name' => "Granville Langworth",
                'avatar' => "https://s3.amazonaws.com/uifaces/faces/twitter/vovkasolovev/128.jpg",
                'email' => "Jaeden_Bernhard86@hotmail.com",
                'password' => '12345678',
                'active' => true
            ],
            [
                'name' => "Miss Viva Wiza",
                'avatar' => "https://s3.amazonaws.com/uifaces/faces/twitter/prrstn/128.jpg",
                'email' => "Teagan_Langosh@gmail.com",
                'password' => '12345678',
                'active' => true
            ],
            [
                'name' => "Louisa Mante I",
                'avatar' => "https://s3.amazonaws.com/uifaces/faces/twitter/zauerkraut/128.jpg",
                'email' => "Adam_Hahn@yahoo.com",
                'password' => '12345678',
                'active' => true
            ],
            [
                'name' => "Serena Upton",
                'avatar' => "https://s3.amazonaws.com/uifaces/faces/twitter/_scottburgess/128.jpg",
                'email' => "Lempi48@gmail.com",
                'password' => '12345678',
                'active' => true
            ],
            [
                'name' => "Nestor Breitenberg III",
                'avatar' => "https://s3.amazonaws.com/uifaces/faces/twitter/vickyshits/128.jpg",
                'email' => "Vance63@hotmail.com",
                'password' => '12345678',
                'active' => true
            ],
            [
                'name' => "Osbaldo Brown",
                'avatar' => "https://s3.amazonaws.com/uifaces/faces/twitter/vonachoo/128.jpg",
                'email' => "Andy_Langosh72@hotmail.com",
                'password' => '12345678',
                'active' => true
            ],
            [
                'name' => "Hanna Dooley",
                'avatar' => "https://s3.amazonaws.com/uifaces/faces/twitter/d33pthought/128.jpg",
                'email' => "Magdalen.Nitzsche30@yahoo.com",
                'password' => '12345678',
                'active' => true
            ],
            [
                'name' => "Devon Emard",
                'avatar' => "https://s3.amazonaws.com/uifaces/faces/twitter/hanna_smi/128.jpg",
                'email' => "Jamil94@gmail.com",
                'password' => '12345678',
                'active' => true
            ],
            [
                'name' => "Vida Stark IV",
                'avatar' => "https://s3.amazonaws.com/uifaces/faces/twitter/santi_urso/128.jpg",
                'email' => "Alba.Klocko@hotmail.com",
                'password' => '12345678',
                'active' => true
            ],
            [
                'name' => "Dr. Oswald Barrows",
                'avatar' => "https://s3.amazonaws.com/uifaces/faces/twitter/vicivadeline/128.jpg",
                'email' => "Jimmie_Glover70@yahoo.com",
                'password' => '12345678',
                'active' => true
            ],
            [
                'name' => "Jamarcus Cassin",
                'avatar' => "https://s3.amazonaws.com/uifaces/faces/twitter/duck4fuck/128.jpg",
                'email' => "Delmer_Nader@yahoo.com",
                'password' => '12345678',
                'active' => true
            ],
            [
                'name' => "Dr. Issac Beahan",
                'avatar' => "https://s3.amazonaws.com/uifaces/faces/twitter/maximseshuk/128.jpg",
                'email' => "Ruthe_Cruickshank94@hotmail.com",
                'password' => '12345678',
                'active' => true
            ],
            [
                'name' => "Shyanne Dare Jr.",
                'avatar' => "https://s3.amazonaws.com/uifaces/faces/twitter/gt/128.jpg",
                'email' => "Edyth_Morar@hotmail.com",
                'password' => '12345678',
                'active' => true
            ],
            [
                'name' => "Mrs. Elva Roberts",
                'avatar' => "https://s3.amazonaws.com/uifaces/faces/twitter/pierrestoffe/128.jpg",
                'email' => "Oswald.Schuppe51@hotmail.com",
                'password' => '12345678',
                'active' => true
            ],
            [
                'name' => "Cedrick Carter",
                'avatar' => "https://s3.amazonaws.com/uifaces/faces/twitter/betraydan/128.jpg",
                'email' => "Carlee57@gmail.com",
                'password' => '12345678',
                'active' => true
            ],
            [
                'name' => "Finn O'Hara",
                'avatar' => "https://s3.amazonaws.com/uifaces/faces/twitter/dnezkumar/128.jpg",
                'email' => "Zaria.Sipes@gmail.com",
                'password' => '12345678',
                'active' => true
            ],
            [
                'name' => "Cale Medhurst",
                'avatar' => "https://s3.amazonaws.com/uifaces/faces/twitter/motionthinks/128.jpg",
                'email' => "Amos_Keebler9@yahoo.com",
                'password' => '12345678',
                'active' => true
            ],
            [
                'name' => "Erin Dicki",
                'avatar' => "https://s3.amazonaws.com/uifaces/faces/twitter/nwdsha/128.jpg",
                'email' => "Roel.Glover97@yahoo.com",
                'password' => '12345678',
                'active' => true
            ],
            [
                'name' => "Willy Nikolaus",
                'avatar' => "https://s3.amazonaws.com/uifaces/faces/twitter/ahmadajmi/128.jpg",
                'email' => "Gregorio89@gmail.com",
                'password' => '12345678',
                'active' => true
            ],
            [
                'name' => "Joanne Padberg",
                'avatar' => "https://s3.amazonaws.com/uifaces/faces/twitter/felipecsl/128.jpg",
                'email' => "Ned14@gmail.com",
                'password' => '12345678',
                'active' => true
            ],
            [
                'name' => "Doug Langosh",
                'avatar' => "https://s3.amazonaws.com/uifaces/faces/twitter/supjoey/128.jpg",
                'email' => "Jarod.Pacocha39@hotmail.com",
                'password' => '12345678',
                'active' => true
            ],
            [
                'name' => "Lennie Deckow",
                'avatar' => "https://s3.amazonaws.com/uifaces/faces/twitter/karalek/128.jpg",
                'email' => "Granville_Fahey42@hotmail.com",
                'password' => '12345678',
                'active' => true
            ],
            [
                'name' => "Michael Gerlach",
                'avatar' => "https://s3.amazonaws.com/uifaces/faces/twitter/antongenkin/128.jpg",
                'email' => "Casimir_Bins36@gmail.com",
                'password' => '12345678',
                'active' => true
            ],
            [
                'name' => "Tanner Kulas DDS",
                'avatar' => "https://s3.amazonaws.com/uifaces/faces/twitter/kennyadr/128.jpg",
                'email' => "Cara.Considine@yahoo.com",
                'password' => '12345678',
                'active' => true
            ],
            [
                'name' => "Lamar Daniel",
                'avatar' => "https://s3.amazonaws.com/uifaces/faces/twitter/anaami/128.jpg",
                'email' => "Berniece6@hotmail.com",
                'password' => '12345678',
                'active' => true
            ],
            [
                'name' => "Jerad Schroeder",
                'avatar' => "https://s3.amazonaws.com/uifaces/faces/twitter/paulfarino/128.jpg",
                'email' => "Mohammed_Murray86@gmail.com",
                'password' => '12345678',
                'active' => true
            ]
        ];
        foreach ($users as $user) {
            User::create($user);
        }
    }
}
