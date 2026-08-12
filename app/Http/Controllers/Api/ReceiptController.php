<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Receipt;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $data = $request->all();

        $receipt = Receipt::create([
            'number' => $data['number'],
            'type' => $data['type'],
            'status' => 'pending',
            'total' => $data['total'],
            'user' => $data['user']['name'] ?: $data['user']['text'],
            'payload' => $data,
        ]);

        return response()->json([
            'id' => $receipt->id,
        ], 200);
    }
}
