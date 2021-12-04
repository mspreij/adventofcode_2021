<?php
$values = explode("\n", trim(file_get_contents("3.txt")));

// 3a: count the bits in 12 slots ($count)
$count = array_fill(0, 12, 0);
foreach($values as $value) {
  foreach(str_split($value) as $i => $bit) {
    $count[$i] += $bit;
  }
}
$gamma = bindec(join('', array_map(fn($x) => (int) ($x > 500), $count))); // > 500 == "1 = most common"
$epsilon = $gamma ^ bindec(str_repeat(1, 12)); // just flip bits for "least common"..
echo $gamma * $epsilon;


// 3b
$oxvals = $covals = $values;

// figured I'd just split the values in two arrays and reuse the array that I needed.
// I tried to do it in a single loop (nested one deeper) but that failed..
for($i=0;$i<12;$i++) {
  $arrays = [0=>[], 1=>[]];
  foreach($oxvals as $value) {
    $bits = str_split($value);
    $arrays[$bits[$i]][] = $value;
  }
  $oxvals = $arrays[(int) (count($arrays[1]) >= count($arrays[0]))]; // magic trick
  if (count($oxvals) === 1) break;
}
$oxygen = bindec(current($oxvals));

for($i=0;$i<12;$i++) {
  $arrays = [0=>[], 1=>[]];
  foreach($covals as $value) {
    $bits = str_split($value);
    $arrays[$bits[$i]][] = $value;
  }
  $covals = $arrays[(count($arrays[0]) > count($arrays[1]))];
  if (count($covals) === 1) break;
}

$coscrubs = bindec(current($covals));
echo $oxygen * $coscrubs;
