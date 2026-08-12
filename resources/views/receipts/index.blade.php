<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Receipts</title>

    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            padding: 2rem;
            font-family: -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif;
            background: #f3f4f6;
            color: #111827;
        }
        h1 {
            margin: 0 0 1rem;
            font-size: 1.5rem;
        }
        .table-wrap {
            height: 600px;
            overflow-y: auto;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            background: #fff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.875rem;
        }
        thead th {
            position: sticky;
            top: 0;
            background: #f9fafb;
            text-align: left;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #e5e7eb;
            white-space: nowrap;
        }
        tbody td {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #f3f4f6;
            white-space: nowrap;
        }
        tbody tr:last-child td {
            border-bottom: none;
        }
        tbody tr:hover {
            background: #f9fafb;
        }
        .status {
            display: inline-block;
            padding: 0.125rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .status-pending { background: #fef3c7; color: #92400e; }
        .status-sent { background: #d1fae5; color: #065f46; }
        .status-failed { background: #fee2e2; color: #991b1b; }
        .empty {
            padding: 2rem;
            text-align: center;
            color: #6b7280;
        }
        .filters {
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .filters label {
            font-size: 0.875rem;
            font-weight: 600;
        }
        .filters select {
            padding: 0.375rem 0.5rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            background: #fff;
        }
    </style>

    @livewireStyles
</head>
<body>
    <h1>Receipts</h1>

    <livewire:receipts-table />

    @livewireScripts
</body>
</html>
