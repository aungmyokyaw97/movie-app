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
        return $query->whereHas('genres', function ($query) use ($ids) {
            $query->whereIn('genre_id', $ids);
        });
    }

    public function scopeRelatedDirector($query,$name)
    {
        return $query->where('director', $name);
    }

    public function scopeRelatedTags($query,$tags)
    {
        return $query->where('tags', $tags);
    }

    //Related Movie


    // Movie filter

    public function scopeWithDirector($query, $request)
    {
        if ($request->has('director')) {
            return $query->where('director', $request->director);
        }

        return $query;
    }

    public function scopeWithTags($query, $request)
    {
        if ($request->has('tags')) {
            return $query->where('director', $request->tags);
        }

        return $query;
    }

    //Movie Filter


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