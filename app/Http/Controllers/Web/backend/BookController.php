<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Mail\NewBookLaunched;
use App\Models\Book;
use App\Models\Category;
use App\Models\Chapter;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class BookController extends Controller
{
    // Index
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Book::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('category', function ($data) {
                    return $data->category->name ?? 'N/A';
                })
                ->addColumn('sessions', function ($data) {
                    $chapterCount = $data->chapters->count();
                    $sessions = ceil($chapterCount / 6);
                    return $sessions;
                })
                ->addColumn('chapters', function ($data) {
                    return $data->chapters->count();
                })
                ->addColumn('status', function ($data) {
                    return '<div class="form-check form-switch mb-2">
                                <input class="form-check-input" onclick="statusBook(' . $data->id . ')" type="checkbox" ' . ($data->status == 'active' ? 'checked' : '') . '>
                            </div>';
                })
                ->addColumn('action', function ($data) {
                    return '<a href="' . route('chapter.index', ['book_id' => $data->id]) . '" class="btn btn-primary">
                                <i class="ri-file-add-line"></i> Add Chapter
                            </a>
                            <a href="' . route('book.edit', $data->id) . '" class="btn btn-info">
                                <i class="mdi mdi-pencil"></i>
                            </a>
                            <button type="button" onclick="deleteData(\'' . route('book.destroy', $data->id) . '\')" class="btn btn-danger del">
                                <i class="mdi mdi-delete"></i>
                            </button>';
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
        return view('backend.book.index');
    }
    public function create()
    {
        $categories = Category::get();
        return view('backend.book.create', compact('categories'));
    }
    public function edit($id)
    {
        $categories = Category::get();
        $book = Book::find($id);
        return view('backend.book.edit', compact('categories', 'book'));
    }
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'title' => 'required',
            'category' => 'required',
            'description' => 'required',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->with('error', $validate->errors()->first())->withInput();
        }
        try {
            $book = new Book();
            $book->title = $request->title;
            $book->slug = $this->generateUniqueSlug($request->title, Book::class);
            $book->category_id = $request->category;
            $book->description = $request->description;
            $book->author = Auth::id();
            $book->save();


            $subscribers = Subscriber::all();

            foreach ($subscribers as $subscriber) {
                Mail::to($subscriber->email)->queue(new NewBookLaunched($book, $subscriber));
            }
            return redirect()->route('book.index')->with('success', 'Book added successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }
    public function status(Request $request)
    {
        $cate = Book::find($request->id);


        if ($cate->status == 'active') {
            $cate->update([
                'status' => 'inactive',
            ]);
        } else {
            $cate->update([
                'status' => 'active',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Status Updated'
        ]);
    }
    public function update(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'title' => 'required',
            'category' => 'required',
            'description' => 'required',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->with('error', $validate->errors()->first())->withInput();
        }
        try {
            $book              = Book::find($request->id);
            $originalTitle     = $book->title;
            $book->title       = $request->title;
            $book->slug        = $originalTitle === $request->title ? $book->slug : $this->generateUniqueSlug($request->title, Book::class);
            $book->category_id = $request->category;
            $book->description = $request->description;
            $book->save();
            return redirect()->route('book.index')->with('success', 'Book updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $delete = Book::find($id)->delete();
            Chapter::where('book_id', $id)->delete();
            DB::commit();
            if ($delete) {
                return back()->with('success', 'Deleted Successfully');
            } else {
                return back()->with('error', 'Try Again!');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Try Again!');
        }
    }
}
