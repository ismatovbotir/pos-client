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
                    <tr wire:key="receipt-{{ $receipt->id }}">
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
</div>
