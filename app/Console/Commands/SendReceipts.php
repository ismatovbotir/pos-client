<?php

namespace App\Console\Commands;

use App\Models\Receipt;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SendReceipts extends Command
{
    protected $signature = 'receipts:send';

    protected $description = 'Send receipts that have not been synced yet';

    public function handle(): int
    {
        $address = config('services.server.address');
        $port = config('services.server.port');
        $headerKey = config('services.server.header_key');
        $headerValue = config('services.server.header_value');

        if (! $address || ! $headerKey || ! $headerValue) {
            $this->error('SERVER_ADDRESS, SERVER_HEADER_KEY or SERVER_HEADER_VALUE is not set in .env');

            return self::FAILURE;
        }

        $address = trim($address);

       // if (! str_contains($address, '://')) {
      //      $address = 'http://'.ltrim($address, '/');
      //  }

        //$parts = parse_url($address);

       // if (empty($parts['host'])) {
      //      $this->error("SERVER_ADDRESS is invalid: {$address}");

      //      return self::FAILURE;
      //  }

       // if ($port) {
            $address = $address.':'.$port."/api/receipts";
        //}

        $receipts = Receipt::where('sync', false)->get();

        if ($receipts->isEmpty()) {
            $this->info('No receipts to send.');

            return self::SUCCESS;
        }

        foreach ($receipts as $receipt) {
            try {
                $response = Http::withHeaders([$headerKey => $headerValue])
                    ->post($address, $receipt->payload);

                if ($response->failed()) {
                    throw new \RuntimeException($response->body());
                }

                $receipt->update([
                    'sync' => true,
                    'status' => 'sent',
                    'message' => null,
                ]);

                $this->info("Receipt #{$receipt->number} sent.");
            } catch (\Throwable $e) {
                $receipt->increment('attempts');
                $receipt->update([
                    'status' => 'failed',
                    'message' => $e->getMessage(),
                ]);

                $this->error("Receipt #{$receipt->number} failed: {$e->getMessage()}");
            }
        }

        return self::SUCCESS;
    }
}
