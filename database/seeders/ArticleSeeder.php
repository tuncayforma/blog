<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

require_once 'vendor/autoload.php';


class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for ($i = 0; $i < 20;$i++) {
            $title = $faker->sentence(6);
            DB::table('articles')->insert([
                'category_id' => rand(1,5),
                'title' => $title,
                'image' => $faker->imageUrl(800,400,'cats',true,'Faker'),
                'content' => $faker->paragraph(6),
                'hit' => rand(1,99999),
                'slug' => Str::slug($title),
                'created_at' => $faker->dateTime('now'),
                'updated_at' => now()
            ]);
        }
    }
}
