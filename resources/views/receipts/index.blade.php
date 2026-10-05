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
        tbody tr {
            cursor: pointer;
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

        .modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(17, 24, 39, 0.6);
            display: flex;
            align-items: flex-start;
            justify-content: center;
            overflow-y: auto;
            padding: 3rem 1rem;
            z-index: 50;
        }
        .receipt-paper {
            position: relative;
            width: 320px;
            max-width: 100%;
            background: #fff;
            font-family: 'Courier New', Courier, monospace;
            font-size: 0.8125rem;
            line-height: 1.45;
            color: #111827;
            padding: 1.5rem 1.25rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4);
            border-radius: 0.25rem;
        }
        .receipt-close {
            position: absolute;
            top: 0.5rem;
            right: 0.75rem;
            background: none;
            border: none;
            font-size: 1.25rem;
            line-height: 1;
            color: #9ca3af;
            cursor: pointer;
        }
        .receipt-close:hover {
            color: #111827;
        }
        .receipt-header {
            text-align: center;
            margin-bottom: 0.5rem;
        }
        .receipt-header .shop-title {
            font-weight: 700;
            font-size: 1rem;
            letter-spacing: 0.05em;
        }
        .receipt-meta {
            color: #4b5563;
            font-size: 0.75rem;
        }
        .receipt-status-badge {
            display: inline-block;
            margin-top: 0.375rem;
            padding: 0.125rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.6875rem;
            font-weight: 700;
            letter-spacing: 0.05em;
        }
        .receipt-status-success {
            background: #d1fae5;
            color: #065f46;
        }
        .receipt-status-other {
            background: #fee2e2;
            color: #991b1b;
        }
        .receipt-divider {
            border-top: 1px dashed #9ca3af;
            margin: 0.6rem 0;
        }
        .receipt-row {
            display: flex;
            justify-content: space-between;
            gap: 0.75rem;
        }
        .receipt-items .receipt-item {
            margin-bottom: 0.5rem;
        }
        .receipt-item .item-name {
            white-space: normal;
            word-break: break-word;
        }
        .receipt-item .item-line {
            display: flex;
            justify-content: space-between;
            color: #4b5563;
        }
        .receipt-totals .receipt-row {
            margin-bottom: 0.25rem;
        }
        .receipt-totals .grand-total {
            font-weight: 700;
            font-size: 0.9375rem;
        }
        .receipt-footer {
            text-align: center;
            margin-top: 0.75rem;
            color: #6b7280;
            font-size: 0.75rem;
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
