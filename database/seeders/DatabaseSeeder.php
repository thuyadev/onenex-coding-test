<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Comment;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         User::factory(10)->create();
         Genre::factory(10)->create();
         Tag::factory(10)->create();
         Movie::factory(10)->create();

         $movies = Movie::all();

         foreach ($movies as $movie)
         {
             $genres = Genre::all()->random(3)->pluck('id')->toArray();
             $tags = Tag::all()->random(3)->pluck('id')->toArray();

             $movie->genres()->attach($genres);
             $movie->tags()->attach($tags);
         }

         Comment::factory(20)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
