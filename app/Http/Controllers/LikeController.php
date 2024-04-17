<?php

namespace App\Http\Controllers;

use App\Models\DogImage;
use App\Models\User;
use App\Models\UserLikedImage;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function getLikedImages()
    {
        $imgUrls = [];
        $userLikedImages = UserLikedImage::where('user_id', auth()->user()->id)->get();

        foreach ($userLikedImages as $userLikedImage) {
            if ($userLikedImage->dogImage) {
                $imgUrls[] = $userLikedImage->dogImage->image_url;
            }
        }

        return response()->json(['data' => $imgUrls, 'message' => 'Successfully fetched.'], 200);

    }

    public function likeImage(Request $request)
    {
        try {
            $user = auth()->user();

            $imgUrl = $request->imgUrl;
            $dogImage = DogImage::firstOrCreate([
                'image_url' => $imgUrl
            ]);

            $userLikedImage = UserLikedImage::where([
                'user_id' => $user->id,
                'dog_image_id' => $dogImage->id
            ])->first();

            if ($userLikedImage) {
                $userLikedImage->delete();

                $message = 'Image unliked successfully.';
                $action = 'unlike';
            } else {

                $likedImageCount = UserLikedImage::where('user_id', $user->id)->count();
                if ($likedImageCount >= 3) {
                    return response()->json(['error' => 'You have already liked three images.'], 200);
                }

                UserLikedImage::create([
                    'user_id' => $user->id,
                    'dog_image_id' => $dogImage->id
                ]);

                $message = 'Image liked successfully.';
                $action = 'like';
            }

            return response()->json(['message' => $message, 'action' => $action], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to like image'], 500);
        }
    }

    public function getUserLikedImages($user_id){
        $imgUrls = [];
        $user = User::find($user_id);

        $userLikedImages = UserLikedImage::where('user_id', $user_id)->get();

        foreach ($userLikedImages as $userLikedImage) {
            if ($userLikedImage->dogImage) {
                $imgUrls[] = $userLikedImage->dogImage->image_url;
            }
        }

        return response()->json(['data' => [
            'user' => $user,
            'imgUrls' => $imgUrls
        ], 'message' => 'Successfully fetched.'], 200);

    }
}
