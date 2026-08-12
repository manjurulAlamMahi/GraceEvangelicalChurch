<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SubscriberController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Subscriber::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('created_at', function ($data) {
                    return '<span class="badge bg-soft-success text-success">' . $data->created_at->format('d M Y') . '</span>';
                })
                ->addColumn('email', function ($data) {
                    return '✉️ ' . $data->email;
                })
                ->addColumn('action', function ($data) {
                    return '<button type="button"  onclick="deleteData(\'' . route('subscriber.destroy', $data->id) . '\')" class="btn btn-danger btn-sm del">
                                <i class="mdi mdi-delete"></i> Remove
                            </button>';
                })
                ->rawColumns(['created_at', 'email', 'action'])
                ->make(true);
        }

        return view('backend.layout.subscriber.index');
    }

    public function destroy($id)
    {
        $subscriber = Subscriber::findOrFail($id);
        $subscriber->delete();

        return back()->with('success', 'Subscriber deleted successfully.');
    }
}
