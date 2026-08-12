<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Mail\NewChapterLaunched;
use App\Models\Book;
use App\Models\Chapter;
use App\Models\Subscriber;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class ChapterController extends Controller
{
    public function get(Request $request)
    {
        $query = Chapter::query();

        if (!empty($request->id) && empty($request->no)) {
            $query->where('id', $request->id);
        }
        if (!empty($request->no)) {
            if (!empty($request->id)) {
                $query->where('id', '!=', $request->id)->where('book_id', $request->book_id)->where('no', $request->no);
            }
            $query->where('book_id', $request->book_id)->where('no', $request->no);
        }

        $chapters = $query->get();

        return response()->json($chapters);
    }

    // Index Page
    public function index(Request $request)
    {
        $totalChapter = Chapter::count();
        $book_id = null;
        session()->forget('book_id');

        if ($request->has('book_id')) {
            session(['book_id' => $request->get('book_id')]);
        }
        $session_book = session('book_id'); // Always retrieve

        $books = Book::get();

        if ($request->ajax()) {
            $chapter = Chapter::query();
            if (!empty($session_book) && $request->get('book_id') == null) {
                $chapter->where('book_id', $session_book);
            }
            if ($request->book_id != null) {
                $chapter->where('book_id', $request->book_id);
            }
            $data = $chapter->latest()->get();
            $totalChapter = $chapter->count();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('book.title', function ($data) {
                    return '<i class="ri-book-line"></i> <i class="me-2"></i> ' . $data->book->title . '';
                })
                ->addColumn('audio', function ($data) {
                    return '<audio controls>
                                <source src="' . asset($data->audio) . '" type="audio/mpeg">
                                Your browser does not support the audio element.
                            </audio>';
                })
                ->addColumn('date', function ($data) {
                    if($data->date){
                        return Carbon::parse($data->date)->format('d-m-Y');
                    }else{
                        return 'No Date Selected';
                    }
                })
                ->addColumn('action', function ($data) {
                    return '<button onclick="editChapter(' . $data->id . ')" type="button" class="btn btn-info">
                                <i class="mdi mdi-pencil"></i>
                            </button>
                            <button type="button"  onclick="deleteData(\'' . route('chapter.destroy', $data->id) . '\')" class="btn btn-danger del">
                                <i class="mdi mdi-delete"></i>
                            </button>';
                })
                ->setRowAttr([
                    'data-id' => function ($data) {
                        return $data->id;
                    }
                ])
                ->rawColumns(['book.title', 'action', 'audio'])
                ->with(['totalChapter' => $totalChapter])
                ->toJson();
        }
        return view('backend.chapter.index', compact('books', 'totalChapter', 'book_id'));
    }
    public function store(Request $request)
    {
        $data = $request->all();

        $validate = Validator::make($request->all(), [
            'book_id'  => 'required|numeric|exists:books,id',
            'title'    => 'required',
            'no'       => 'nullable|numeric',
            'date'     => 'nullable|date',
            'duration' => 'nullable|numeric',
            'audio'    => 'nullable|mimes:mp3,wav',
        ]);
        if ($validate->fails()) {
            return redirect()->back()->with('error', $validate->errors()->first())->withInput();
        }

        if($request->file('audio')){
            $audio = $request->file('audio');
            $audioPath = $this->fileUpload($audio, 'book/chapter/audio');
            if (!$audioPath) {
                return response()->json([
                    'status' => false,
                    'message' => 'Audio upload failed',
                ]);
            }
            $data['audio'] = $audioPath;
        }else{
            $data['audio'] = null;
        }

        if (empty($data['no'])) {
            $highestno = Chapter::where('book_id', $data['book_id'])->max('no');
            $data['no'] = $highestno ? $highestno + 1 : 1;
        }
        $chapternoExists = Chapter::where('book_id', $data['book_id'])
            ->where('no', $data['no'])
            ->exists();
        if ($chapternoExists) {
            return redirect()->route('chapter.index')->with('error', 'Chapter no already exists for this book.')->withInput();
        }

        $data['duration'] = $data['duration'] ? $data['duration'] : 0;

        $book = Book::find($data['book_id']);

        $chapter = Chapter::create($data);

        $subscribers = Subscriber::all();

        foreach ($subscribers as $subscriber) {
            Mail::to($subscriber->email)->queue(new NewChapterLaunched($book, $chapter));
        }

        return redirect()->route('chapter.index')->with('success', 'Chapter created successfully');

    }

    public function update(Request $request)
    {
        $chapter = Chapter::find($request->id);

        if (!$chapter) {
            return redirect()->back()->with('error', 'Chapter not found.');
        }

        $validate = Validator::make($request->all(), [
            'book_id'  => 'required|numeric|exists:books,id',
            'title'    => 'required',
            'no'       => 'nullable|numeric',
            'duration' => 'required',
            'date'     => 'nullable|date',
            'audio'    => 'nullable|mimes:mp3,wav',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->with('error', $validate->errors()->first())->withInput();
        }

        $data = $request->all();

        // Handle audio upload if provided
        if ($request->hasFile('audio')) {
            $audio = $request->file('audio');
            $audioPath = $this->fileUpload($audio, 'book/chapter/audio');
            if (!$audioPath) {
                return redirect()->back()->with('error', 'Audio upload failed.')->withInput();
            }
            $data['audio'] = $audioPath;
        } else {
            // Keep existing audio if not replaced
            unset($data['audio']);
        }

        // Set default no if not provided
        if (empty($data['no'])) {
            $highestNo = Chapter::where('book_id', $data['book_id'])->max('no');
            $data['no'] = $highestNo ? $highestNo + 1 : 1;
        }

        // Check for duplicate 'no' except current chapter
        $exists = Chapter::where('book_id', $data['book_id'])
            ->where('no', $data['no'])
            ->where('id', '!=', $chapter->id)
            ->exists();

        if ($exists) {
            return redirect()->route('chapter.index')->with('error', 'Chapter no already exists for this book.')->withInput();
        }

        // Update the chapter
        $updated = $chapter->update($data);

        if ($updated) {
            return redirect()->route('chapter.index')->with('success', 'Chapter updated successfully.');
        } else {
            return redirect()->route('chapter.index')->with('error', 'Chapter update failed.');
        }
    }

    public function destroy($id)
    {
        $chapter = Chapter::find($id);
        if ($chapter) {
            // Delete the audio file if it exists
            if ($chapter->audio && file_exists(public_path($chapter->audio))) {
                unlink(public_path($chapter->audio));
            }
            // Delete the chapter
            $chapter->delete();
            return redirect()->route('chapter.index')->with('success', 'Chapter deleted successfully.');
        } else {
            return redirect()->route('chapter.index')->with('error', 'Chapter not found.');
        }
    }
}
