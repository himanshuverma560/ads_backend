<?php

namespace App\Http\Controllers;

use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StateController extends Controller
{
    /**
     * Return all states that belong to the given country ID.
     */
    public function index($id)
    {
        try {
            $states = State::query()
                ->where('country_id', $id)
                ->orderBy('name')
                ->get();

            return response()->json([
                'status' => true,
                'data' => $states,
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
                'name' => 'required|string|unique:states,name',
                'country_id' => 'required|exists:countries,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors(),
                ], 422);
            }

            $state = State::create($validator->validated());
            return response()->json([
                'status' => true,
                'data' => $state,
            ], 201);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, State $state)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|unique:states,name,' . $state->id,
                'country_id' => 'required|exists:countries,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors(),
                ], 422);
            }

            $state->update($validator->validated());
            return response()->json([
                'status' => true,
                'data' => $state,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
