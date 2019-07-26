<?php

use Illuminate\Database\Seeder;


class QuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $csv = array_map('str_getcsv', file('database/seeds/Questions.csv'));

        for($i =1 ; $i < sizeof($csv); $i++){
            $c= $csv[$i];
            DB::table('questions')->insert([
                'title' => $c[0],
                'dimension' =>$c[1],
                'direction'=>$c[2],
                'meaning' =>$c[3],
                'created_at' =>now(),
                'updated_at' => now()
            ]);
        }
       
       
    }
}
