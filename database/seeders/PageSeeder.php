<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages=['Hakkımızda','Kariyer','Vizyon','Misyon'];
        $count =0;
        foreach ($pages as $page){
            $count++;
            DB::table('pages')->insert([
                'title'=> $page,
                'slug'=> Str::slug($page),
                'content'=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                Sed vitae nulla tempor, aliquet sem eu, rhoncus arcu. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.
                Morbi at ante rhoncus, elementum metus nec, volutpat tellus. Fusce at arcu ut massa consequat lacinia sit amet eget erat. Duis varius purus mi, vel pretium est faucibus a.
                 Vestibulum eget erat et augue pulvinar rutrum nec quis massa.
                 Sed ac mollis tellus, non finibus diam. Quisque at bibendum arcu. In in faucibus lectus, et dictum justo. Etiam fermentum varius neque non venenatis.',
                'image' => 'https://gordontredgold.com/wp-content/uploads/2018/08/business.jpg',
                'order' => $count,
                'created_at' => now(),
                'updated_at' => now()

            ]);
        }
    }
}
