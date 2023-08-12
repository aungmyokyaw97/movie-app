<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    protected $fillable = [
        'title','slug'
    ];

    public function scopeFindGenre($query,$title){
        $slug = \Str::slug($title);           
        return $query->firstOrCreate(['slug' => $slug],['title' => $title,'slug' => $slug]);
    }

    public function movie()
    {
        return $this->belongsToMany(Movie::class,'movie_genres');
    }
}
