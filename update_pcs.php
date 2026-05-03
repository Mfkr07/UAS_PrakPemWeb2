<?php
foreach (\App\Models\Computer::orderBy('id')->get() as $i => $c) {
    $idx = $i + 1;
    if ($idx >= 6 && $idx <= 8) {
        $c->update(['name' => 'VIP-0' . $idx, 'price_per_hour' => 10000]);
    } elseif ($idx >= 9 && $idx <= 10) {
        $c->update(['name' => 'VVIP-' . str_pad($idx, 2, '0', STR_PAD_LEFT), 'price_per_hour' => 25000]);
    } else {
        $c->update(['name' => 'PC-0' . $idx, 'price_per_hour' => 5000]);
    }
}
echo "PCs updated.\n";
