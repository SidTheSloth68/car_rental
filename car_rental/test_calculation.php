<?php
require 'vendor/autoload.php';
use Carbon\Carbon;

$pickup = Carbon::now()->addDays(1);
$return = Carbon::now()->addDays(3);
$days = max(1, $pickup->diffInDays($return));

echo "Pickup: " . $pickup->format('Y-m-d H:i') . PHP_EOL;
echo "Return: " . $return->format('Y-m-d H:i') . PHP_EOL;
echo "Days: " . $days . PHP_EOL;

$dailyRate = 100;
$totalAmount = $dailyRate * $days;
$taxAmount = $totalAmount * 0.10;
$finalAmount = $totalAmount + $taxAmount;

echo "Total Amount: $" . $totalAmount . PHP_EOL;
echo "Tax Amount: $" . $taxAmount . PHP_EOL;
echo "Final Amount: $" . $finalAmount . PHP_EOL;
echo "Expected loyalty points: " . (int)$finalAmount . PHP_EOL;