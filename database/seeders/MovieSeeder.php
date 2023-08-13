<?php

namespace Database\Seeders;

use App\Models\Movie;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $movies1 = [
            ['title' => 'Movie 1','director' => 'Aung Aung','rating' => 6.5,'tags' => 'tag1','user_id' => 1],
            ['title' => 'Movie 2','director' => 'Aung Min','rating' => 3.5,'tags' => 'tag1','user_id' => 1],
            ['title' => 'Movie 3','director' => 'Aung Sat','rating' => 2.5,'tags' => 'tag2','user_id' => 1],
            ['title' => 'Movie 4','director' => 'Aung Aung','rating' => 7.5,'tags' => 'tag2','user_id' => 1],
            ['title' => 'Movie 5','director' => 'Aung Min','rating' => 5.5,'tags' => 'tag1','user_id' => 1],
        ];

        $genres1 = [
            [1,2],
            [2,3],
            [1,4],
            [5,2],
            [3,2]
        ];

        foreach ($movies1 as $key => $row) {
            $movie = Movie::create($row);
            $movie->genres()->attach($genres1[$key]);
        }

        $movies2 = [
            ['title' => 'Movie 6','director' => 'Aung Thu','rating' => 6.5,'tags' => 'tag1','user_id' => 2],
            ['title' => 'Movie 7','director' => 'Aung Min','rating' => 3.5,'tags' => 'tag1','user_id' => 2],
            ['title' => 'Movie 8','director' => 'Ko Sat','rating' => 2.5,'tags' => 'tag2','user_id' => 2],
            ['title' => 'Movie 9','director' => 'Min Aung','rating' => 7.5,'tags' => 'tag2','user_id' => 2],
            ['title' => 'Movie 10','director' => 'Aung Min','rating' => 5.5,'tags' => 'tag1','user_id' => 2],
        ];

        foreach ($movies2 as $key => $row) {
            $movie = Movie::create($row);
            $movie->genres()->attach($genres1[$key]);
        }
    }
}
