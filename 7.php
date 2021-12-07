<?php

$startTime = microtime(1);
$input = trim(file_get_contents('7.txt'));
// $input = '16,1,2,0,4,2,7,1,2,14';

$crabs = explode(',', $input);

// A.
sort($crabs);
$median = $crabs[floor(count($crabs)/2)];
$fuel = 0;
foreach($crabs as $crab) {
  $fuel += abs($crab - $median);
}
echo "Fuel A: $fuel\n";
echo "Took ".round(microtime(1)-$startTime,4)."\n";

// B.
$startTime = microtime(1);
$avg = floor(array_sum($crabs)/count($crabs));

$fuel = 0;
foreach($crabs as $crab) $fuel += thing(abs($crab - $avg));

echo "\nAvg $avg, fuel B: $fuel\n";
echo "Took ".round(microtime(1)-$startTime,4)."\n";

function thing($x) {
  static $cache=[];
  if (isset($cache[$x])) return $cache[$x];
  $sum = 0;
  for($i=1;$i<=$x;$i++) {
    $sum += $i;
  }
  return $cache[$x] = $sum;
}
