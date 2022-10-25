<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    

        Brand::factory()->count(10)->create();




                //********** manually data create ********

            //***************for multiple data***********
 
        // Brand::insert([
        //     'name' => 'Toy',
        //     'description'=> Str::random(10),
        //     'image'=>'apple.png'
        // ],
        //  [
        //     'name' =>'Food',
        //     'description' => Str::random(10),
        //     'image' => 'apple2.png'
        // ]);

            //************for single data**************

        // Brand::create(
        //     [
        //         'name' => 'Toy',
        //         'description' => Str::random(10),
        //         'image' => 'apple.png'
        //     ],
        // );
    }
}
