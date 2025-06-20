<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Profile::query();

            if ($city = $request->query('city')) {
                $query->where('city', $city);
            }

            if ($request->boolean('is_random')) {
                $query->inRandomOrder();
            } else {
                $sortBy = $request->query('sort_by', 'id');
                $sortOrder = $request->query('sort_order', 'asc');
                $query->orderBy($sortBy, $sortOrder);
            }

            $perPage = (int) $request->query('per_page', 15);
            $profiles = $query->paginate($perPage);

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

    public function show(Profile $profile)
    {
        try {
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
                    // Move file directly into public/profile_images
                    $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('profile_images'), $fileName);
                    $paths[] = 'profile_images/' . $fileName;
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
                    // Move file directly into public/profile_images
                    $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('profile_images'), $fileName);
                    $paths[] = 'profile_images/' . $fileName;
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
