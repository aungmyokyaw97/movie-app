<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\MovieCreateRequest;
use App\Http\Requests\API\v1\MovieIdRequest;
use App\Http\Requests\API\v1\MovieReviewRequest;
use App\Http\Requests\API\v1\MovieUpdateRequest;
use App\Http\Resources\API\v1\MovieDetailResource;
use App\Http\Resources\API\v1\MovieListResource;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\MovieReview;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MoviesExport;
use App\Http\Requests\API\v1\MovieExportRequest;

class MovieController extends Controller
{

    public function index()
    {
        $movie = Movie::myMovie()->select('id','title','rating')->paginate(10);

        return $this->paginateResponse(data:$movie);
    }

    
    public function create(MovieCreateRequest $request)
    {
        $data = $request->validated();
        
        $ids = $this->handleGenres($data['genres']);

        $movie = Movie::create($data);
        $movie->genres()->attach($ids);

        return $this->successResponse(message:'Successfully created');
    }

    
    private function handleGenres($genres){           
        $ids = [];
     
        foreach ($genres as $key => $value) {
            $ids[] = Genre::findGenre($value)->id;
        }
     
        return $ids;
    }

    
    public function edit(MovieUpdateRequest $request)
    {
        $movie = Movie::findOrFail($request->movie_id);
        $this->authorize('edit', $movie);

        $data = $request->validated();
        
        $ids = $this->handleGenres($data['genres']);
        
        $movie->update($data);
        $movie->genres()->sync($ids);

        return $this->successResponse(message:'Successfully updated');
    }

    
    public function destroy(MovieIdRequest $request)
    {
        $movie = Movie::findOrFail($request->movie_id);
        $this->authorize('delete', $movie);
        $movie->genres()->detach();
        $movie->delete();

        return $this->successResponse(message:'Successfully deleted');
    }


    public function detail(MovieIdRequest $request)
    {
        $movie = Movie::with(['genres','reviews','user'])->findOrFail($request->movie_id);
        
        $relatedMovies = Movie::relatedGenres($movie->genres->pluck('id'))->relatedDirector($movie->director)->relatedTags($movie->tags)->select('id','title','director','tags')->where('id', '<>', $movie->id)->inRandomOrder()->limit(5)->get();
        
        $movie['related_movie'] = $relatedMovies;
        //return response()->json($movie);
        return $this->successResponse(data:new MovieDetailResource($movie));
    }


    public function list(Request $request)
    {
        $movies = Movie::with(['genres','user']);

        if ($request->has('genres')) {
            $movies->filterGenres($this->handleGenres($request->genres));
        }

        if ($request->has('director')) {
            $movies->filterDirector($request->director);
        }

        if ($request->has('tags')) {
            $movies->filterTags($request->tags);
        }

        $data = $movies->paginate(10);

        return $this->paginateResponse(data:MovieListResource::collection($data));
    }

    
    public function movieReview(MovieReviewRequest $request)
    {
        MovieReview::create($request->validated());

        return $this->successResponse(message:'Successfully created');
    }


    public function export(MovieExportRequest $request)
    {
        $temporaryUrl['temporary_url'] = \URL::temporarySignedRoute(
            'download-csv', now()->addMinutes(30),
            $request->toArray()
        );

        return $this->successResponse(data:$temporaryUrl);
    }


    public function download(Request $request)
    {   
        return Excel::download(new MoviesExport($request), 'movies.csv');
    }


}
