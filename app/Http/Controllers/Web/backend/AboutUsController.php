<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AboutUsController extends Controller
{
    // Index
    public function index()
    {
        $aboutus = AboutUs::first();
        return view('backend.layout.aboutus.index', compact('aboutus'));
    }

    // Update
    public function update(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'title.required' => 'The title field is required.',
            'description.required' => 'The description field is required.',
            'image.image' => 'The image must be a file of type: jpeg, png, jpg, gif, svg.',
        ]);
        if($validate->fails()){
            return redirect()->back()->with('error', $validate->errors()->first())->withInput();
        }
        try{
            $aboutus = AboutUs::first();
            $image = $request->image;
            $oldImage = $aboutus->image == 'default.png' ? null : $aboutus->image;
            $aboutus->title = $request->title;
            $aboutus->description = $request->description;
            $aboutus->image = $this->uploadImage($image, $oldImage, 'uploads/aboutUs', 735, 790, 'aboutus');
            $aboutus->save();
            return redirect()->route('aboutus.index')->with('success', 'About Us Updated Successfully');
        }
        catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }

    }
}
