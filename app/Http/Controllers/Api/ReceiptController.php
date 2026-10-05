<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Receipt;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $data = $request->all();

        try {
            $receipt = Receipt::create([
                'number' => $data['number'],
                'close_date' => $data['closeDate'] ? $this->parseCloseDate($data['closeDate']) : null,
                'type' => $data['type'],
                'status' => 'pending',
                'total' => $data['total'],
                'user' => data_get($data, 'user.name') ?: data_get($data, 'user.text'),
                'payload' => $data,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        }

        return response()->json([
            'id' => $receipt->id,
        ], 200);
    }

    private function parseCloseDate(string $date): Carbon
    {
        foreach (['d.m.y', 'd.m.Y', 'Y-m-d'] as $format) {
            try {
                return Carbon::createFromFormat($format, $date)->startOfDay();
            } catch (\Throwable) {
                continue;
            }
        }

        throw new \InvalidArgumentException("Unable to parse closeDate: {$date}");
    }
}
