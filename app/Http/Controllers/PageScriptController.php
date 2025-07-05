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

            $items = $payload;
            // If the payload is a single associative array, wrap it into an array
            if ($items === [] || array_keys($items) !== range(0, count($items) - 1)) {
                $items = [$items];
            }

            $created = [];
            foreach ($items as $item) {
                $validator = Validator::make($item, [
                    'page_type' => 'required|string',
                    'script' => 'required|string',
                    'position' => 'required|integer|unique:page_scripts,position,NULL,id,page_type,' . ($item['page_type'] ?? null),
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'status' => false,
                        'errors' => $validator->errors(),
                    ], 422);
                }

                $created[] = PageScript::create($validator->validated());
            }

            $data = count($created) === 1 ? $created[0] : $created;

            return response()->json([
                'status' => true,
                'data' => $data,
            ], 201);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
