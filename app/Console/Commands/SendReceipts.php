<?php

namespace App\Console\Commands;

use App\Models\Receipt;
use Illuminate\Console\Command;

class SendReceipts extends Command
{
    protected $signature = 'receipts:send';

    protected $description = 'Send receipts that have not been synced yet';

    public function handle(): int
    {
        $receipts = Receipt::where('sync', false)->get();

        if ($receipts->isEmpty()) {
            $this->info('No receipts to send.');

            return self::SUCCESS;
        }

        foreach ($receipts as $receipt) {
            try {
                // TODO: replace with the actual call that sends $receipt->payload
                // to the destination service (e.g. fiscal/OFD server).

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
