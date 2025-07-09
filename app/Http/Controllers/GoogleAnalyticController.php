<?php

namespace App\Http\Controllers;

use App\Models\GoogleAnalytic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GoogleAnalyticController extends Controller
{
    public function index()
    {
        try {
            $code = GoogleAnalytic::first();
            return response()->json([
                'status' => true,
                'data' => $code,
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
                'code' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors(),
                ], 422);
            }

            $data = $validator->validated();
            $code = GoogleAnalytic::updateOrCreate(['id' => 1], $data);

            return response()->json([
                'status' => true,
                'data' => $code,
            ], 201);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
