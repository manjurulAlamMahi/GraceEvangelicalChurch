<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\SiteMessage;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class InboxController extends Controller
{
    // Index
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SiteMessage::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('messager_info', function ($data) {
                    return '
                            <div class="text-start">
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">👤 ' . $data->name . '</h6>
                                    <p class="mb-0 text-muted">📧 ' . $data->subject . '</p>
                                    <p class="mb-0 text-muted">✉️ ' . $data->email . '</p>
                                    <p class="mb-0 text-muted">📱 ' . $data->phone . '</p>
                                </div>
                            </div>';
                })
                ->addColumn('created_at', function ($data) {
                    return '<span class="badge bg-soft-success text-success">' . $data->created_at->diffForHumans() . '</span>';
                })
                ->addColumn('message', function ($data) {
                    return '<div class="card card-body">
                            <p class="mb-0 text-muted">' . $data->message . '</p>
                        </div>';
                })
                ->addColumn('action', function ($data) {
                    if ($data->status == 'read') {
                        return '<span class="badge bg-success text-white">Read</span>
                        <button type="button"  onclick="deleteData(\'' . route('inbox.destroy', $data->id) . '\')" class="btn btn-danger btn-sm del">
                                <i class="mdi mdi-delete"></i>
                            </button>';
                    }
                    if ($data->status == 'unread') {
                        return '<a href="' . route('inbox.read', $data->id) . '" class="btn btn-primary">
                                Read
                            </a>

                            <button type="button"  onclick="deleteData(\'' . route('inbox.destroy', $data->id) . '\')" class="btn btn-danger del">
                                <i class="mdi mdi-delete"></i>
                            </button>';
                    }
                })
                ->rawColumns(['messager_info', 'message', 'created_at', 'action'])
                ->make(true);
        }

        return view('backend.layout.inbox.index');
    }

    // Read
    public function read($id)
    {
        $data = SiteMessage::findOrFail($id);
        $data->status = 'read';
        $data->save();
        return redirect()->route('inbox.index')->with('success', 'Message marked as read successfully.');
    }

    // Destroy
    public function destroy($id)
    {
        $data = SiteMessage::findOrFail($id);
        $data->delete();
        return redirect()->route('inbox.index')->with('success', 'Message deleted successfully.');
    }
}
