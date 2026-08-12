<?php

namespace App\Livewire;

use App\Models\Receipt;
use Livewire\Component;

class ReceiptsTable extends Component
{
    public string $sync = 'false';

    public ?int $selectedReceiptId = null;

    public function show(int $id): void
    {
        $this->selectedReceiptId = $id;
    }

    public function closeModal(): void
    {
        $this->selectedReceiptId = null;
    }

    public function render()
    {
        $receipts = Receipt::when($this->sync !== 'all', function ($query) {
            $query->where('sync', $this->sync === 'true');
        })->latest()->get();

        return view('livewire.receipts-table', [
            'receipts' => $receipts,
            'selectedReceipt' => $this->selectedReceiptId
                ? Receipt::find($this->selectedReceiptId)
                : null,
        ]);
    }
}
