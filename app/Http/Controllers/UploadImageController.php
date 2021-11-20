<?php

namespace App\Http\Controllers;

use App\Models\PostImage;
use Illuminate\Http\Request;

class UploadImageController extends Controller
{

    public function store(Request $request)
    {
        //validate the image
        $this->validate($request, [
            'image' => "required|image|mimes:jpg,png,jpeg,gif,svg|max:2048"
        ]);

        //create the new image name
        $newImageName = time() . '-' . rand() . 'image' . '.' . $request->image->extension();
        //move the image to public path
        $request->image->move(public_path('images'), $newImageName);

        //response 
        return response([
            'message' => 'image uploaded',
            'image' => asset('images') . '/' . $newImageName
        ], 401);
    }
}
