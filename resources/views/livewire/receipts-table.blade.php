<div>
    <form class="filters">
        <label for="sync">Synced</label>
        <select name="sync" id="sync" wire:model.live="sync">
            <option value="false">False</option>
            <option value="true">True</option>
            <option value="all">All</option>
        </select>
    </form>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Number</th>
                    <th>Close Date</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>User</th>
                    <th>Sync</th>
                    <th>Attempts</th>
                    <th>Message</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($receipts as $receipt)
                    <tr wire:key="receipt-{{ $receipt->id }}" wire:click="show({{ $receipt->id }})">
                        <td>{{ $receipt->id }}</td>
                        <td>{{ $receipt->number }}</td>
                        <td>{{ $receipt->close_date?->format('Y-m-d') }}</td>
                        <td>{{ $receipt->type }}</td>
                        <td><span class="status status-{{ $receipt->status }}">{{ $receipt->status }}</span></td>
                        <td>{{ $receipt->total }}</td>
                        <td>{{ $receipt->user }}</td>
                        <td>{{ $receipt->sync ? 'Yes' : 'No' }}</td>
                        <td>{{ $receipt->attempts }}</td>
                        <td>{{ $receipt->message }}</td>
                        <td>{{ $receipt->created_at }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="empty">No receipts yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($selectedReceipt)
        <div class="modal-backdrop" wire:click="closeModal">
            <div class="receipt-paper" wire:click.stop>
                <button type="button" class="receipt-close" wire:click="closeModal">&times;</button>

                <div class="receipt-header">
                    <div class="shop-title">Shop #{{ data_get($selectedReceipt->payload, 'shop') }} / POS {{ data_get($selectedReceipt->payload, 'pos') }}</div>
                    <div class="receipt-meta">Receipt &#8470;{{ $selectedReceipt->number }}</div>
                    <div class="receipt-meta">{{ data_get($selectedReceipt->payload, 'openDate') }} {{ data_get($selectedReceipt->payload, 'openTime') }}</div>
                    <div class="receipt-meta">Cashier: {{ data_get($selectedReceipt->payload, 'user.name') ?: data_get($selectedReceipt->payload, 'user.text') }}</div>
                </div>

                <div class="receipt-divider"></div>

                <div class="receipt-items">
                    @foreach (data_get($selectedReceipt->payload, 'positions', []) as $position)
                        <div class="receipt-item">
                            <div class="item-name">{{ data_get($position, 'item.name') }}</div>
                            <div class="item-line">
                                <span>{{ data_get($position, 'qty') }} pcs</span>
                                <span>{{ number_format((float) data_get($position, 'totalSum', data_get($position, 'sum', 0)), 2) }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="receipt-divider"></div>

                <div class="receipt-totals">
                    <div class="receipt-row">
                        <span>Positions</span>
                        <span>{{ data_get($selectedReceipt->payload, 'qtyPositions') }}</span>
                    </div>
                    <div class="receipt-row">
                        <span>Qty</span>
                        <span>{{ data_get($selectedReceipt->payload, 'qtyBuys') }}</span>
                    </div>
                    <div class="receipt-row grand-total">
                        <span>Total</span>
                        <span>{{ number_format((float) $selectedReceipt->total, 2) }}</span>
                    </div>
                </div>

                <div class="receipt-divider"></div>

                <div class="receipt-payments">
                    @foreach (data_get($selectedReceipt->payload, 'payments', []) as $payment)
                        <div class="receipt-row">
                            <span>{{ data_get($payment, 'name') }}</span>
                            <span>{{ number_format((float) data_get($payment, 'value', 0), 2) }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="receipt-footer">
                    @if (data_get($selectedReceipt->payload, 'closeDate'))
                        <div>Closed: {{ data_get($selectedReceipt->payload, 'closeDate') }}</div>
                    @endif
                    @if (data_get($selectedReceipt->payload, 'fiscal'))
                        <div>Fiscal: {{ data_get($selectedReceipt->payload, 'fiscal') }}</div>
                    @endif
                    @if (data_get($selectedReceipt->payload, 'barcode'))
                        <div>{{ data_get($selectedReceipt->payload, 'barcode') }}</div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
