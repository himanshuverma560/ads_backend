<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    /**
     * Return all cities that belong to the given state ID.
     */
    public function index($id)
    {
        try {
            $cities = City::query()
                ->where('state_id', $id)
                ->orderBy('name')
                ->get();

            return response()->json([
                'status' => true,
                'data' => $cities,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Return all cities regardless of state.
     */
    public function all()
    {
        try {
            $cities = City::query()
                ->orderBy('name')
                ->get();

            return response()->json([
                'status' => true,
                'data' => $cities,
            ]);
        } catch (\Throwable $e) {
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
                'name' => 'required|string|unique:cities,name',
                'state_id' => 'required|exists:states,id',
                'image' => 'nullable|image',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors(),
                ], 422);
            }

            $data = $validator->validated();
            if ($request->hasFile('image')) {
                $fileName = uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
                $request->file('image')->move(public_path('city_images'), $fileName);
                $data['image'] = 'city_images/' . $fileName;
            }

            $city = City::create($data);
            return response()->json([
                'status' => true,
                'data' => $city,
            ], 201);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, City $city)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|unique:cities,name,' . $city->id,
                'state_id' => 'required|exists:states,id',
                'image' => 'nullable|image',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors(),
                ], 422);
            }

            $data = $validator->validated();
            if ($request->hasFile('image')) {
                $fileName = uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
                $request->file('image')->move(public_path('city_images'), $fileName);
                $data['image'] = 'city_images/' . $fileName;
            }

            $city->update($data);

            return response()->json([
                'status' => true,
                'data' => $city,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
