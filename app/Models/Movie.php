<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title','director','rating','tags','user_id'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($movie) 
        {
            $movie->user_id = auth()->user()->id;
        });
    }

    public function scopeMyMovie($query)
    {
        return $query->where('user_id',auth()->user()->id);
    }

    //Related Movie

    public function scopeRelatedGenres($query,$ids)
    {
        return $query->orWhereHas('genres', function ($query) use ($ids) {
            $query->whereIn('genre_id', $ids);
        });
    }

    public function scopeRelatedDirector($query,$name)
    {
        return $query->orWhere('director', $name);
    }

    public function scopeRelatedTags($query,$tags)
    {
        return $query->orWhere('tags', $tags);
    }

    //Related Movie

    //Filter Movie

    public function scopeFilterGenres($query,$ids)
    {
        return $query->WhereHas('genres', function ($query) use ($ids) {
            $query->whereIn('genre_id', $ids);
        });
    }

    public function scopeFilterDirector($query,$name)
    {
        return $query->where('director', $name);
    }

    public function scopeFilterTags($query,$tags)
    {
        return $query->where('tags', $tags);
    }

    //Filter Movie


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviews()
    {
        return $this->hasMany(MovieReview::class,'movie_id','id');
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class,'movie_genres');
    }


}