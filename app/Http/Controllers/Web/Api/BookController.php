<?php

namespace App\Http\Controllers\Web\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Chapter;
use App\Traits\apiresponse;
use Illuminate\Http\Request;

class BookController extends Controller
{
    use apiresponse;
    public function book(Request $request)
    {
        $query = Book::with('user:id,name', 'category:id,name', 'chapters:id,book_id,title');

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('search')) {
            $searchTerm = $request->search;

            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                    // ->orWhere('description', 'like', '%' . $searchTerm . '%')
                    ->orWhereHas('category', function ($q2) use ($searchTerm) {
                        $q2->where('name', 'like', '%' . $searchTerm . '%');
                    })
                    ->orWhereHas('chapters', function ($q3) use ($searchTerm) {
                        $q3->where('title', 'like', '%' . $searchTerm . '%');
                    })
                    ->orWhereHas('user', function ($q4) use ($searchTerm) {
                        $q4->where('name', 'like', '%' . $searchTerm . '%');
                    });
            });
        }

        if ($request->has('sort_by')) {
            $query->orderBy('created_at', $request->sort_by);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        if ($request->has('limit')) {
            $query->limit($request->limit);
        }

        $books = $query->where('status', 'active')
            ->select('id', 'title', 'slug', 'description', 'category_id') // You need user_id for relation
            ->get();

        $books->map(function ($book) {
            $book->authorName = $book->user->name ?? null;
            unset($book->user);
        });

        return $this->success($books, 'Successfully!', 200);
    }
    public function book_details(Request $request, $id)
    {
        $season = $request->get('season', 1); // Default to season 1
        $chaptersPerSeason = 6;
        $offset = ($season - 1) * $chaptersPerSeason;

        // Select specific book fields
        $book = Book::select('id', 'title', 'slug', 'description', 'category_id', 'author')
            ->where('id', $id)
            ->with([
                'category:id,name',
                'user:id,name',
                'chapters' => function ($query) use ($offset, $chaptersPerSeason) {
                    $query->select('id', 'book_id', 'date', 'title', 'duration', 'audio', 'no')
                        ->orderBy('no') // Assuming chapter numbers
                        ->skip($offset)
                        ->take($chaptersPerSeason);
                }
            ])
            ->first();

        if (!$book) {
            return $this->error('Book not found', 404);
        }

        // Total chapters for season logic
        $totalChapters = Chapter::where('book_id', $book->id)->count();
        $totalSeasons = ceil($totalChapters / $chaptersPerSeason);
 
        // Format audio path and calculate total duration for current season
        $totalDuration = 0;
        $book->chapters->map(function ($chapter) use (&$totalDuration) {
            $chapter->audio = asset($chapter->audio);
            $totalDuration += $chapter->duration;
            return $chapter;
        });

        // Add computed values
        $book->total_chapters  = $totalChapters;
        $book->total_seasons   = $totalSeasons;
        $book->current_season  = (int) $season;
        $book->season_duration = $totalDuration;
        $book->authorName = $book->user->name ?? null;

        return $this->success($book, 'Successfully!', 200);
    }
}
