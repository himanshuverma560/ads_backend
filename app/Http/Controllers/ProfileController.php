<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        try {
            $profiles = Profile::all();
            return response()->json([
                'status' => true,
                'data' => $profiles,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
            'mobile' => 'required|string',
            'facebook' => 'nullable|string',
            'insta_id' => 'nullable|string',
            'telegram_id' => 'nullable|string',
            'about_us' => 'nullable|string',
            'city' => 'nullable|string',
            'age' => 'nullable|integer',
            'images.*' => 'image'
        ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors(),
                ], 422);
            }

            $data = $validator->validated();

            if ($request->hasFile('images')) {
                $paths = [];
                foreach ($request->file('images') as $image) {
                    $paths[] = $image->store('profile_images', 'public');
                }
                $data['images'] = $paths;
            }

            $profile = Profile::create($data);

            return response()->json([
                'status' => true,
                'data' => $profile,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, Profile $profile)
    {
        try {
            $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string',
            'email' => 'sometimes|required|email',
            'mobile' => 'sometimes|required|string',
            'facebook' => 'nullable|string',
            'insta_id' => 'nullable|string',
            'telegram_id' => 'nullable|string',
            'about_us' => 'nullable|string',
            'city' => 'nullable|string',
            'age' => 'nullable|integer',
            'images.*' => 'image'
        ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors(),
                ], 422);
            }

            $data = $validator->validated();

            if ($request->hasFile('images')) {
                $paths = [];
                foreach ($request->file('images') as $image) {
                    $paths[] = $image->store('profile_images', 'public');
                }
                $data['images'] = $paths;
            }

            $profile->update($data);

            return response()->json([
                'status' => true,
                'data' => $profile,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
