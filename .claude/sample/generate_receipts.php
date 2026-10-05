<?php

$items = [
    ['id' => 101, 'art' => 'A101', 'name' => 'Coca-Cola 0.5', 'class_code' => 'КЛ 10001', 'package_code' => ''],
    ['id' => 102, 'art' => 'A102', 'name' => 'Bread white', 'class_code' => 'КЛ 10002', 'package_code' => 'Certifi'],
    ['id' => 103, 'art' => 'A103', 'name' => 'Milk 1L', 'class_code' => 'КЛ 10003', 'package_code' => ''],
    ['id' => 104, 'art' => 'A104', 'name' => 'Butter 200g', 'class_code' => 'КЛ 10004', 'package_code' => ''],
    ['id' => 105, 'art' => 'A105', 'name' => 'Cheese 100g', 'class_code' => 'КЛ 10005', 'package_code' => 'Certifi'],
    ['id' => 106, 'art' => 'A106', 'name' => 'Apple 1kg', 'class_code' => 'КЛ 10006', 'package_code' => ''],
    ['id' => 107, 'art' => 'A107', 'name' => 'Rice 1kg', 'class_code' => 'КЛ 10007', 'package_code' => ''],
    ['id' => 108, 'art' => 'A108', 'name' => 'Sugar 1kg', 'class_code' => 'КЛ 10008', 'package_code' => ''],
    ['id' => 109, 'art' => 'A109', 'name' => 'Tea black 100g', 'class_code' => 'КЛ 10009', 'package_code' => ''],
    ['id' => 110, 'art' => 'A110', 'name' => 'Chocolate bar', 'class_code' => 'КЛ 10010', 'package_code' => ''],
];

$cashiers = [
    ['id' => 1, 'name' => 'Иванова Мария'],
    ['id' => 2, 'name' => 'Петров Алексей'],
    ['id' => 3, 'name' => 'Сидорова Ольга'],
    ['id' => 4, 'name' => ''], // forces fallback to text
];

$paymentNames = ['Наличные', 'Карта', 'Смешанная'];

function randDateTime(int $daysAgoMax): array
{
    $daysAgo = random_int(0, $daysAgoMax);
    $ts = strtotime("-{$daysAgo} days") - random_int(0, 6 * 3600);
    return [
        'date' => date('d.m.y', $ts),
        'time' => date('H:i:s', $ts),
        'ts' => $ts,
    ];
}

$receipts = [];

for ($i = 1; $i <= 20; $i++) {
    $open = randDateTime(14);
    $closeTs = $open['ts'] + random_int(60, 900);

    $isSuccess = random_int(1, 10) > 1; // ~90% success, some failed/other
    $status = $isSuccess ? 'success' : (random_int(0, 1) ? 'failed' : 'cancelled');

    $positionsCount = random_int(1, 5);
    $positions = [];
    $sum = 0;
    $qtyBuys = 0;

    for ($p = 0; $p < $positionsCount; $p++) {
        $item = $items[array_rand($items)];
        $qty = round(random_int(1, 30) / 10, 3);
        $price = random_int(500, 15000) / 10;
        $lineSum = round($qty * $price, 2);
        $discount = random_int(0, 1) ? round($lineSum * (random_int(0, 15) / 100), 2) : 0;
        $totalSum = round($lineSum - $discount, 2);

        $positions[] = [
            'item' => $item,
            'labels' => [],
            'barcode' => (string) random_int(1000000000000, 9999999999999),
            'qty' => $qty,
            'storno' => 0,
            'sum' => $lineSum,
            'sumR' => 0,
            'sumWD' => $totalSum,
            'sumWT' => round($totalSum * 0.12, 2),
            'totalSum' => $totalSum,
        ];

        $sum += $lineSum;
        $qtyBuys += $qty;
    }

    $sum = round($sum, 2);
    $totalDiscount = round(array_sum(array_map(fn ($pos) => $pos['sum'] - $pos['sumWD'], $positions)), 2);
    $sumWithDiscs = round($sum - $totalDiscount, 2);

    $cashier = $cashiers[array_rand($cashiers)];

    $paymentName = $paymentNames[array_rand($paymentNames)];

    $receipts[] = [
        'shop' => random_int(1, 8),
        'pos' => random_int(1, 4),
        'barcode' => (string) random_int(10000, 99999),
        'card' => (string) random_int(1000000000, 9999999999),
        'openDate' => $open['date'],
        'openTime' => $open['time'],
        'closeDate' => date('d.m.y', $closeTs),
        'closeTime' => date('H:i:s', $closeTs),
        'number' => (string) (100 + $i),
        'user' => [
            'id' => $cashier['id'],
            'name' => $cashier['name'],
            'text' => $cashier['name'] ?: 'Кассир #' . $cashier['id'],
        ],
        'payments' => [
            [
                'name' => $paymentName,
                'value' => $sumWithDiscs,
            ],
        ],
        'positions' => $positions,
        'qtyBuys' => round($qtyBuys, 3),
        'qtyPositions' => $positionsCount,
        'session' => random_int(1, 3),
        'type' => 1,
        'status' => $status,
        'sum' => $sum,
        'sumWithDiscs' => $sumWithDiscs,
        'total' => $sumWithDiscs,
        'aos' => new stdClass(),
        'fiscal' => $isSuccess ? (string) random_int(1000000000000, 9999999999999) : '',
    ];
}

$outDir = __DIR__ . '/generated';
if (! is_dir($outDir)) {
    mkdir($outDir, 0777, true);
}

foreach ($receipts as $idx => $receipt) {
    $n = str_pad((string) ($idx + 1), 2, '0', STR_PAD_LEFT);
    file_put_contents(
        "{$outDir}/receipt-{$n}.json",
        json_encode($receipt, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
    );
}

file_put_contents(
    "{$outDir}/receipts-all.json",
    json_encode($receipts, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
);

echo "Generated " . count($receipts) . " receipts into {$outDir}\n";
