<?php

namespace App\Http\Controllers;

use App\Models\PageScript;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PageScriptController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = PageScript::query();
            if ($pageType = $request->query('page_type')) {
                $query->where('page_type', $pageType);
            }
            $scripts = $query->orderBy('position')->get();
            return response()->json([
                'status' => true,
                'data' => $scripts,
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
            $payload = $request->all();

            $validator = Validator::make($payload, [
                'page_type' => 'required|string',
                'script' => 'required|string',
                'position' => 'required|integer|unique:page_scripts,position,NULL,id,page_type,' . ($payload['page_type'] ?? null),
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors(),
                ], 422);
            }

            $pageScript = PageScript::create($validator->validated());

            return response()->json([
                'status' => true,
                'data' => $pageScript,
            ], 201);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, PageScript $pageScript)
    {
        try {
            $validator = Validator::make($request->all(), [
                'page_type' => 'required|string',
                'script' => 'required|string',
                'position' => 'required|integer|unique:page_scripts,position,' . $pageScript->id . ',id,page_type,' . $request->input('page_type'),
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors(),
                ], 422);
            }

            $pageScript->update($validator->validated());

            return response()->json([
                'status' => true,
                'data' => $pageScript,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
