<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ImageUploadController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
    
            // Get the desired name from the request
            $desiredName = $request->input('name'); // Name provided from frontend
            $fullFileName = time().'.'.$image->getClientOriginalExtension();
    
            // Store the file with the new name in the 'uploads' directory
            $path = $image->storeAs('uploads', $fullFileName, 'public');
    
            // Optionally: Save the image path and other data to the database
            // Example: $user = User::find($request->user_id);
            // $user->profile_image = $path;
            // $user->save();
    
            return response()->json([
                'success'=>true,
                'message' => 'Image uploaded and renamed successfully!',
                'image' => $fullFileName,
            ]);
        }

        return response()->json(['message' => 'No image uploaded'], 400);
    }
}
