<?php

namespace App\Exports;

use App\Models\Movie;
use App\Models\Genre;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MoviesExport implements FromCollection, WithMapping, WithHeadings
{

    protected $request; 

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $movies = Movie::with(['genres','user']);

        if ($this->request->has('genres')) {
            $movies->relatedGenres($this->handleGenres($this->request->genres));
        }

        if ($this->request->has('director')) {
            $movies->relatedDirector($this->request->director);
        }

        if ($this->request->has('tags')) {
            $movies->relatedTags($this->request->tags);
        }

        $data = $movies->get();

        return $data;
    }

    private function handleGenres($genres){           
        $ids = [];
     
        foreach ($genres as $key => $value) {
            $ids[] = Genre::findGenre($value)->id;
        }
     
        return $ids;
    }

    public function headings(): array
    {
        return [
            'id',            
            'title',
            'director',
            'tags',
            'rating',
            'created_by',
            'genres'
        ];
    }


    public function map($row): array
    {
        $genres = implode(",",$row->genres->pluck('title')->toArray());
        return [
            $row->id,
            $row->title,
            $row->director,
            $row->tags,
            $row->rating,
            $row->user->name,
            $genres
        ];
    }
}
