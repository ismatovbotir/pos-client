<?php

namespace App\Livewire;

use App\Models\Receipt;
use Livewire\Component;

class ReceiptsTable extends Component
{
    public string $sync = 'false';

    public function render()
    {
        $receipts = Receipt::when($this->sync !== 'all', function ($query) {
            $query->where('sync', $this->sync === 'true');
        })->latest()->get();

        return view('livewire.receipts-table', [
            'receipts' => $receipts,
        ]);
    }
}
